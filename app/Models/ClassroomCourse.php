<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassroomCourse extends Model
{
	protected $table = 'classroom_course';
    protected $guarded = [];

    public function classroom()
    {
        return $this->hasOne('App\Models\Classroom','id','classroom_id');
    }

    public function course()
    {
        return $this->hasOne('App\Models\Course','id','course_id');
    }

    public function teacher_info()
    {
        return $this->hasOne('App\Models\User','id','teacher');
    }

    public function detail()
    {
        return $this->hasMany('App\Models\ClassroomCourseDetail','classroom_course_id','id');
    }
}
    