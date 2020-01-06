<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	protected $table = 'order';
    protected $guarded = [];

    public $timestamps = true;

    public function student()
    {
        return $this->hasOne('App\Models\Student','id','student_id');
    }

    public function created_info()
    {
        return $this->hasOne('App\Models\User','id','created_by');
    }
}
    