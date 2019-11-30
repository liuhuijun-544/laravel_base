<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/24
 * Time: 13:51
 */

namespace App\Logic;


class CouponRuleLogic
{
    public function prescription($now,$row){
        $prescription = '';
        switch ($row['date_type']){
            // 永久有效
            case 1:
                $prescription = '<span style="color: #6ce26c">&nbsp;<br>永久(进行中)&nbsp;<br>&nbsp;<br></span>';
                break;
            // 截止到什么时候
            case 2:
                $now > $row['end'] ? ( $prescription = '<span style="color: red"><br>'.$row['end'].'前有效<br>(已结束)</span>'): ($prescription = '<span style="color: #6ce26c"><br />'.$row['end'].'前有效<br />(进行中)</span>');
                break;
            // 某段时间
            case 3:
                if($row['start']>$now){
                    $prescription = $row['start'].'开始<br />(未开始)';
                }elseif($row['end']<$now){
                    $prescription = '<span style="color: red"><br />'.$row['end'].'前有效<br />(已结束)</span>';
                }else{
                    $prescription = '<span style="color: #6ce26c">'.$row['start'].'至<br />'.$row['end'].'有效<br />(进行中)</span>';
                }
                break;
        }
        return $prescription;
    }

    public function coupon_prescription($now,$row){
        $prescription = '';
        switch ($row['date_type']){
            // 发送后多少天有效
            case 1:
                $prescription = '<span style="color: #6ce26c">发送后'.$row['date_start'].'(有效)</span>';
                break;
            // 截止到什么时候
            case 2:
                $now > $row['coupon_date_end'] ? ( $prescription = '<span style="color: red">'.$row['coupon_date_end'].'前有效(失效)</span>'): ($prescription = '<span style="color: #6ce26c">'.$row['coupon_date_end'].'前有效(有效)</span>');
                break;
            // 某段时间
            case 3:
                if($row['coupon_date_start']>$now){
                    $prescription = $row['coupon_date_start'].'开始<br />(未开始)';
                }elseif($row['coupon_date_end']<$now){
                    $prescription = '<span style="color: red">'.$row['coupon_date_end'].'前有效<br />(失效)</span>';
                }else{
                    $prescription = '<span style="color: #6ce26c">'.$row['coupon_date_start'].'至<br />'.$row['coupon_date_end'].'有效<br />(有效)</span>';
                }
                break;
        }
        return $prescription;
    }
}