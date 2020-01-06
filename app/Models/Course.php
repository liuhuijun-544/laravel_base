<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
	protected $table = 'course';
    protected $guarded = [];

    public $timestamps = true;

    public function course_time()
    {
        return $this->hasMany('App\Models\CourseTime','course_id','id');
    }

    public function teacher_1()
    {
        return $this->hasOne('App\Models\User','id','lecturer');
    }

    public function teacher_2()
    {
        return $this->hasOne('App\Models\User','id','edu_teacher_id');
    }

    public function student()
    {
        return $this->hasMany('App\Models\Student','course_id','id');
    }
}
    