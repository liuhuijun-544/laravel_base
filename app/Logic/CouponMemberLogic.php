<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/1
 * Time: 11:00
 */

namespace App\Logic;


use App\Models\Coupon;
use App\Models\CouponMember;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CouponMemberLogic
{
    /**
     * 优惠劵发放逻辑计算
     * @param $coupon_id [优惠劵ID]
     * @param array $members  [人员]
     * @param int $type n/0 自动 n/1 手动
     * @param string $reason 发放内容
     * @param bool $distinct 是否去重(一人多张)
     * @return array
     */
    public function couponSend($coupon_id, $members, $type=0, $reason='', $distinct = false){
        $members = is_array($members) ? $members : [$members];
        $coupon = Coupon::query()->where('id',$coupon_id)->first();

        //有效期类型\n1发放后多少天有效，多少天过期\n2指定日期失效\n3.可用时间段
        $date_type = $coupon->date_type;
        $data = [];
        switch ($date_type){
            case 1:
                $data['start'] = Carbon::today()->addDays($coupon->date_start)->toDateTimeString();
                $data['end'] = Carbon::today()->addDays($coupon->date_start+$coupon->date_end)->toDateTimeString();
                break;
            case 2:
                $data['start'] = Carbon::now()->toDateTimeString();
                $data['end'] = $coupon->coupon_date_end;
                break;
            case 3:
                $data['start'] = $coupon->coupon_date_start;
                $data['end'] = $coupon->coupon_date_end;
                break;
        }

        $list = Member::query()->select('id','username','card','phone')->withcount(['couponMembers'=>function($q)use($coupon_id){
            $q->where('coupon_id',$coupon_id);
        }])->whereIn('id',$members)->get();
        $adminUser = [];
        if(1==$type){
            $adminUser = [
                'id'=>Auth::user()->id,
                'name'=>Auth::user()->name,
            ];
        }
        $error = [];
        $insert = [];
        if($list){
            $arr = $distinct ? $members : $list->toArray();
            foreach ($arr as $value){
                if ($distinct) {
                    $value = $list->where('id', $value)->first()->toArray();
                }
                if($value['coupon_members_count']<$coupon->frequency){
                    $insert[] = [
                        'start'=>$data['start'],
                        'end'=>$data['end'],
                        'type'=>$type,
                        'coupon_id'=>$coupon_id,
                        'member_id'=>$value['id'],
                        'reason'=>$reason,
                        'user_id'=>array_get($adminUser,'id',0),
                        'user_name'=>array_get($adminUser,'name',''),
                        'status'=>1,
                        'created_at'=>date("Y-m-d H:i:s"),
                        'updated_at'=>date("Y-m-d H:i:s")
                    ];
                }else{
                    $error[] = '[ '.$value['username'].'('.$value['card'].')'.$value['phone'].' ] 优惠劵已领取上限';
                }
            }
        }
        $count = CouponMember::query()->where('coupon_id',$coupon_id)->count();
        $success = $insert;
        $stock = $coupon->total-$count;
        if($stock<0){
            $stock = 0;
        }
        $insertCount = count($insert);

        if($insertCount>$stock){
            $success = collect($insert)->take($stock);
            $error[] = '优惠劵剩余'.$stock.'张，后'.($insertCount-$stock).'条记录将无法插入';
        }
        return ['errorData'=>$error,'successData'=>$success];
    }
}