<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'sys_messages';
    protected $guarded = [];

    public $read_status=[
        '1'=>'未读',
        '2'=>'已读'
    ];

}
