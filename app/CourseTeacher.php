<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseTeacher extends Model
{
    protected $fillable=['teacher_id','course_id','semester_id','section','number_of_students'];

    public function teacher(){
        return $this->belongsTo("App\Teacher");
    }
    public function course(){
        return $this->belongsTo("App\Course");
    }
    public function semester(){
        return $this->belongsTo("App\Semester");
    }
}
