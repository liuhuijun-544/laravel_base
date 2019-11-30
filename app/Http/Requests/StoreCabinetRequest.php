<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCabinetRequest extends FormRequest
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
            'name' => 'required|string',
            'no' => 'required|string',
            'number' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'rows' => 'required|numeric',
            'cols' => 'required|numeric',
            'max_num' => 'required|numeric',
            'sort' => 'required|numeric',
            'status' => 'required|in:1,2,3',
        ];

        // 开放时间
        $this['start_time'] .= ':00';
        $this['end_time'] .= ':00';

        // 状态 部分停用
        if ($this->get('status') == 3) {
            $return['stop_cell'] = 'required|string';
        }
        return $return;
    }
}
