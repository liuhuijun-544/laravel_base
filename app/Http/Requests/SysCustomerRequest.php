<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SysCustomerRequest extends FormRequest
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
            'nickname' => 'required|string',
            'sex' => 'required|in:1,2',
            'phone' => 'required|numeric',
            'company' => 'required|string',
            'department' => 'required|string',
            'position' => 'required|string',
            'address' => 'required|string'
        ];

        if (!$this->get('id')) {
            $return['user_id'] = 'required|numeric';
        }
        if ($this->get('date')) {
            $return['date'] = 'required|date';
        }
        return $return;
    }
}
