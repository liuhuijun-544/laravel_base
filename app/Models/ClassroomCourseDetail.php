<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassroomCourseDetail extends Model
{
	protected $table = 'classroom_course_detail';
    protected $guarded = [];

    public function course_attribute()
    {
        return $this->hasOne('App\Models\CourseAttribute','id','course_attribute_id');
    }
}
    