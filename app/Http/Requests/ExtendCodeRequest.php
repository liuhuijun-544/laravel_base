<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExtendCodeRequest extends FormRequest
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
            'province' => 'required|int',
            'city' => 'required|int',
            'area' => 'required|int',
            'department' => 'required|string',
            'number' => 'required|string',
            'parent_id' => 'required|int'
        ];

        if (!$this->get('id')) {
            $return['user_id'] = 'required|numeric|unique:extend_code';
        }
        return $return;
    }
}
