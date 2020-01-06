<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseTime extends Model
{
	protected $table = 'course_time';
    protected $guarded = [];

    public $timestamps = true;

//    public function class_time()
//    {
//        return $this->belongsTo('App\Models\CourseTime','course_id','id');
//    }
}
    