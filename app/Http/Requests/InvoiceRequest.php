<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $return = [
            'source' => 'required|in:1,2',
            'title' => 'required|string',
//            'number' => 'required|string',
            'order_ids' => 'required|array',
            'texture' => 'required|in:1,2',
            'send' => 'required|in:1,2'
        ];

        // 订单来源
        if ($this->get('source') == 2) {   // 第三方平台
            $return['money'] = 'required|numeric';
        }

        // 发票类型
        if ($this->get('texture') == 1) {   // 纸质发票
            $return['username'] = 'required|string';
            $return['phone'] = 'required|string';
            $return['address'] = 'required|string';
            // 配送方式
            if ($this->get('send') == 1) {   // 配送
                $return['province'] = 'required|string';
                $return['city'] = 'required|string';
                $return['area'] = 'required|string';
            } else {
                $this['province'] = $this['city'] = $this['area'] = '';
            }
            $this['email'] = '';
            // 发票说明
            $this['describe'] = $this->get('describe', 2) == 1 ? '已开票' : '未开票';
        } else {
            $return['email'] = 'required|email';
            $this['username'] = $this['phone'] = $this['address'] = $this['province'] = $this['city'] = $this['area'] = '';
            // 发票说明
            $this['describe'] = '未开票';
        }
        return $return;
    }
}
