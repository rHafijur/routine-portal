<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OverlapCourse extends Model
{
    protected $fillable=['student_id','teacher_id','semester_id','course_id','term'];

    public function course(){
        return $this->belongsTo('App\Course');
    }
}
