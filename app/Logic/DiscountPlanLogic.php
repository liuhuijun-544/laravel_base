<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/24
 * Time: 14:52
 */

namespace App\Logic;


class DiscountPlanLogic
{
    /**
     * 计算时效
     * @param $now
     * @param $row
     * @return string
     */
    public function prescription($now, $row){
        $prescription = '';
        switch ($row['date_type']){
            // 永久有效
            case 1:
                $prescription = '进行中';
                break;
            // 截止到什么时候
            case 2:
                $now > $row['end'] ? $prescription = '已结束':$prescription = '进行中';
                break;
            // 某段时间
            case 3:
                if($row['start']>$now){
                    $prescription = '未开始';
                }elseif($row['end']<$now){
                    $prescription = '已结束';
                }else{
                    $prescription = '进行中';
                }
                break;
        }
        return $prescription;
    }

    /**
     * 梯度计算
     * @param $min  array [满减]
     * @param $rebate  array [优惠(金额/折扣)
     * @param $sort
     * @return bool
     */
    public function gradient($min, $rebate, $sort){

        if(count($min) == 1){
            return true;
        }

        $arr = [];
        foreach ($min as $k=>$v){
            $arr[$v] = $rebate[$k];
        }
        if(count($min)!=count($arr)){
            return false;
        }
        ksort($arr);

        $r = [];
        foreach ($arr as $k=>$v){
            $r[] = $v;
        }
        $t_r = $r;
        $flip = array_flip($t_r);


        if(count($flip)!=count($t_r)){
            return false;
        }
        sort($r);

        if($sort%2 ==1){
            return $t_r === $r;
        }else{
            return $t_r !== $r;
        }
    }
}