<?php

namespace App\Http\Requests;

use App\Models\Printer;
use App\Models\SysArea;
use App\Models\SysCustomerLimit;
use App\Models\WxMessage;
use Illuminate\Foundation\Http\FormRequest;

class SysCustomerLimitRequest extends FormRequest
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
            'province' => 'required|numeric',
            'city' => 'required|string',
            'area' => 'required|string',
            'total' => 'required|numeric',
//            'delivery' => 'required|array',
//            'type' => 'required|in:' . implode(',', array_keys(SysCustomerLimit::$type)),
            'hint' => 'required|string'
        ];

        // 配送方式
        if ($this['delivery'] && count($this['delivery']) > 0) {
            if (in_array(1, $this['delivery'])) {
                $this['package'] = 1;
            }
            if (in_array(2, $this['delivery'])) {
                $this['canteen'] = 1;
            }
            if (in_array(3, $this['delivery'])) {
                $this['personal'] = 1;
            }
        }

        // aid=>id 将aid转换为id
        $all = SysArea::query()->pluck('id', 'aid');
        // 省
        $this['province'] = $all[$this['province']];
        // 市
        $city_aids = explode(',', $this['city']);
        $city_ids = [];
        foreach ($city_aids as $aid) {
            $city_ids[] = $all[$aid];
        }
        $this['city'] = implode(',', $city_ids);
        // 区县
        $area_aids = explode(',', $this['area']);
        $area_ids = [];
        foreach ($area_aids as $aid) {
            $area_ids[] = $all[$aid];
        }
        $this['area'] = implode(',', $area_ids);

        // 配送方式
        $this['package'] = $this->has('package') ? 1 : 0;
        $this['canteen'] = $this->has('canteen') ? 1 : 0;
        $this['personal'] = $this->has('personal') ? 1 : 0;

        // 是否启用
        $this['status'] = $this->has('status') ? 1 : 0;
        return $return;
    }
}
