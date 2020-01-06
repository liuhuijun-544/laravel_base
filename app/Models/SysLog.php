<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use App\Notifications\ResetPasswordNotification;

class SysLog extends Authenticatable
{
    protected $table = 'sys_log';
    protected $guarded = [];


    // 操作模块名称
    const manage_user = 1; // 用户管理
    const manage_role = 2;
    const manage_permission = 3;
    const manage_customer = 4;
    const manage_course = 5;
    const manage_student = 6;
    const manage_classroom = 7;
    const manage_classroom_course = 8;
    const manage_order = 9;

    public static $optModuleName = [
        self::manage_user => '用户管理',
        self::manage_role => '角色管理',
        self::manage_permission => '权限管理',
        self::manage_customer => '人员管理',
        self::manage_course => '班级管理',
        self::manage_student => '学员管理',
        self::manage_classroom => '教室管理',
        self::manage_classroom_course => '课程安排',
        self::manage_order =>'收款管理'
    ];

    // 操作类型名称
    const add = 1;  // 添加
    const edit = 2;   // 修改
    const delete = 3;   // 删除
    const import = 4;   // 导入
    const export = 5;   // 导出
    const distribute = 6;//分配
    const refund = 7;//退款

    public static $optTypeName = [
        self::add => '添加',
        self::edit => '修改',
        self::delete => '删除',
        self::import => '导入',
        self::export => '导出',
        self::distribute => '分配学员',
        self::refund => '退款'
    ];
}
