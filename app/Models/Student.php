<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
	protected $table = 'student';
    protected $guarded = [];

    public $timestamps = true;

    public function course()
    {
        return $this->hasOne('App\Models\Course','id','course_id');
    }
}
    