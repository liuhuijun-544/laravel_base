<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        // 电子发票开票回调地址
        'admin/invoice/callback',
        // 自提柜确认收货
        'admin/orderToday/orderConfirmDeliveryCabinet',
        // 客如云-获取订单推送接口数据
        'admin/keRuYun/getPushOrder',

        /*
         * 门店订货系统接口
         */
        // 获取省-市-区-厨房
        'admin/apiKitchen/getKitchenList',
        // 获取今日生产和今日售出的统计数据
        'admin/apiKitchen/getTodayCountData',
    ];
}
  