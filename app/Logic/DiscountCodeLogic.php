<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/1
 * Time: 17:59
 */

namespace App\Logic;


use App\Models\DiscountCode;
use App\Models\MealType;
use App\Models\SysArea;

class DiscountCodeLogic
{
    function make_coupon_card()
    {
        mt_srand((double)microtime() * 10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $code = substr($charid, 0, 3) . substr($charid, 3, 3);
        return $code;
    }

    /**
     *  餐品数据记录
     * @param $data
     * @return array
     */
    public function getMeal($data){
        $info = [];
        $meal_arr = [];
        foreach ($data as $val){
            $info[$val['type']][] =$val;
        }
        $mealType = MealType::query()->pluck('title','id')->toArray();
        foreach ($info as $k=>$va) {
            $meal_html = "【{$mealType[$k]}】&nbsp;&nbsp;";
            foreach ($va as $kk=>$v) {
                $meal_html .= $v['title'].",&nbsp;&nbsp;";
            }
            $meal_arr[] = $meal_html;
        }

        return $meal_arr;
    }

    /**
     *  门店数据记录
     * @param $data
     * @return array
     */
    public function getStore($data){
        $store_arr = [];
        $city = [];
        $cityRet  = SysArea::query()->where('level','2')->pluck('content','id')->toArray();
        $areaRet  = SysArea::query()->where('level','3')->pluck('content','id')->toArray();

        foreach ($data as $va) {
            $city[$va['city']][$va['area']][] = $va['title'];
        }
        foreach ($city as $k=>$va) {
            $store_html = "【{$cityRet[$k]}】&nbsp;&nbsp;";
            foreach ($va as $kk=>$v) {
                $store_html .= "[{$areaRet[$kk]}]&nbsp;&nbsp;";
                foreach ($v as $v1) {
                    $store_html .= $v1.",&nbsp;&nbsp;";
                }
            }
            $store_arr[] = $store_html;
        }

        return $store_arr;
    }

    /**
     * 计算时效
     * @param $now
     * @param $row
     * @return array
     */
    public function prescription($now, $row){
        $prescription = '';
        $key = 1;
        switch ($row['date_type']){
            // 截止到什么时候
            case 1:
                if($now > $row['date_end']){
                    $key = 3;
                    $prescription = '已过期';
                }else{
                    $key = 2;
                    $prescription = '<span style="color: #6ce26c">进行中</span>';
                }
                break;
            // 某段时间
            case 2:
                if($row['date_start']>$now){
                    $key = 1;
                    $prescription = '<span style="color: red">未开始</span>';
                }elseif($row['date_end']<$now){
                    $key = 3;
                    $prescription = '已过期';
                }else{
                    $key = 2;
                    $prescription = '<span style="color: #6ce26c">进行中</span>';
                }
                break;
        }
        return ['key'=>$key,'prescription'=>$prescription];
    }
}