<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
	protected $table = 'customer';
    protected $guarded = [];

    public $timestamps = true;

    // 数据验证
    protected $role = [
        'username'   => 'required|string',
        'phone'   => 'required|telphone|unique:customer',
        // 'wx_name' => 'required|string',
        'level'   => 'required',
        'company'   => 'required|string',
        'address'   => 'required|string',
        // 'comment'   => 'required|string',
    ];
    // 提示信息
    protected $msgs = [
        'required'          => ':attribute不能为空',
        'min'               => ':attribute最少:min字符',
        'max'               => ':attribute最多:max字符',
        'between'           => ':attribute必须在:min到:max之间',
        'integer'           => ':attribute必须为整型数字',
        'telphone'     => ':attribute必须为手机号格式',
    ];

    // 自定义字段名称
    protected $custom = [
        'username'       => '姓名',
        'phone'       => '手机号',
        'wx_name'     => '微信名',
        'company'     => '公司名',
        'address'    => '地址',
        'comment'    => '备注',
        'level'    => '等级',
    ];

    public function createData($cellData)
    {
    	// 验证器
        $validator = \Validator::make($cellData,$this->role,$this->msgs,$this->custom);
        if($validator->fails()){//验证字段失败
            // dd($validator->errors()->first());
            return $validator->errors()->first();
        }else{

        
        return 'ok';
        }
    }


}
    