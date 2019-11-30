<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use App\Notifications\ResetPasswordNotification;

class SysLogDetail extends Authenticatable
{
    protected $table = 'sys_log_detail';
    protected $fillable = ['model','model_id','type','user_id','user_name','reason','created_at','rcode_detail_id'];

    //与member表 多对多
    public function member()
    {

        return $this->belongsTo('App\Models\Member','model_id','id');
    }



}
