<?php

namespace App\Logic;

use Ixudra\Curl\Facades\Curl;

class StoreCabinetLogic
{
    public $apiUrl = 'http://47.101.38.113/box_xi_xiang_api.php';

    /**
     * 请求接口
     *
     * @param array $params 请求参数
     * @return array
     */
    private function toRequest($params)
    {
        $res = ['code' => -1, 'msg' => ''];
        $response = Curl::to($this->apiUrl)->withData($params)->post();
        $result = json_decode($response, true);
        if ($result['code'] == 1111) {
            $res['code'] = 0;
            $res['msg'] = '操作成功';
        } else {
            $res['msg'] = $result['message'];
        }
        $res['api_res'] = $result;
        $res['params'] = $params;
        \Log::info('自提柜消息:'.json_encode($res));
        return $res;
    }

    /**
     * 开柜（格子）
     *
     * @param string $cabinet_no 柜子设备号
     * @param string $cell_no 格子编号
     * @return array
     */
    public function openBox($cabinet_no, $cell_no)
    {
        $params = [
            'F_type' => 'Open_box',
            'box_key_no' => $cabinet_no,
            'xiang_no' => $cell_no,
            'key' => md5($cabinet_no . $cell_no)
        ];
        return $this->toRequest($params);
    }

    /**
     * 存货
     *
     * @param string $cabinetData 柜子设备号和其中的格子，柜子-格子,柜子-格子,柜子-格子
     * @param string $order_no 订单号
     * @param string $tel 手机号
     * @param string $goods_name 商品信息字符串（直接显示在屏幕上）
     * @return array
     */
    public function saveBox($cabinetData, $order_no, $tel, $goods_name)
    {
        $params = [
            'F_type' => 'Save_box',
            'box_xiang_no' => $cabinetData,
            'order_no' => $order_no,
            'tel' => $tel,
            'goods_name' => $goods_name,
            'key' => md5($cabinetData . $order_no . $tel)
        ];
        return $this->toRequest($params);
    }

    /**
     * 清柜
     *
     * @param string $cabinet_nos 柜子设备号，多个英文逗号分隔
     * @return array
     */
    public function clearBox($cabinet_nos)
    {
        $params = [
            'F_type' => 'Clear_box',
            'box_key_no' => $cabinet_nos,
            'key' => md5($cabinet_nos)
        ];
        return $this->toRequest($params);
    }
}