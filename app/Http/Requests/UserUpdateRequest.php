<?php

namespace App\Http\Requests;

use App\Models\Role;
use App\Models\Store;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
        $reture = [
            'id' => 'required|numeric',
            'role_id' => 'required|numeric',
//            'storelist' => 'required|array',
            'name' => 'required',
            'sex' => 'required|in:1,2',
//            'email' => 'required|unique:users,email,'.$this->get('id').',id|email',
            'phone' => 'required|numeric|regex:/^1[345789][0-9]{9}$/|unique:users,phone,' . $this->get('id') . ',id',
//            'username'  => 'required|min:4|max:14|unique:users,username,'.$this->get('id').',id',
        ];
        if ($this->get('password')) {
            $reture['password'] = 'required|min:6|max:14';
        }

        // 获取当前角色的使用范围
        $role = Role::query()->select('range')->findOrFail($this->get('role_id'));
        if ($role->range == 1) {    // 公司，需要关联所有门店
            $this['storelist'] = Store::query()->pluck('id')->toArray();
        } else {    // 门店，则需要选择门店
            $return['storelist'] = 'required|array';
        }

        return $reture;
    }
}
