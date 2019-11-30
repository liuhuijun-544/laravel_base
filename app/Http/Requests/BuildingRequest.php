<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BuildingRequest extends FormRequest
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
        return [
            'username'   => 'required|string',
            'phone'   => 'required|telephone',
            'wx_name' => 'required|string',
            'additional'   => 'required|numeric',
            'level'   => 'required|numeric',
            'status'   => 'required|numeric',
            'company'   => 'required|string',
            'address'   => 'required|string',
            'comment'   => 'required|string',
        ];
    }
}
