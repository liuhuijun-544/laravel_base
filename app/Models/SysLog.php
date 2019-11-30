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

    public static $optModuleName = [
        self::manage_user => '用户管理',
        self::manage_role => '角色管理',
        self::manage_permission => '权限管理',
    ];

    // 操作类型名称
    const add = 1;  // 添加
    const edit = 2;   // 修改
    const delete = 3;   // 删除
    const import = 4;   // 导入
    const export = 5;   // 导出

    public static $optTypeName = [
        self::add => '添加',
        self::edit => '修改',
        self::delete => '删除',
        self::import => '导入',
        self::export => '导出'
    ];
}
