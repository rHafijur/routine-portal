<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $fillable=['semester_code','title'];

    public function courseTeachers(){
        return $this->hasMany("App\CourseTeacher");
    }
    public function courses(){
        return $this->belongsToMany("App\Course",'course_teachers');
    }
    public function overlapCourseApprovals(){
        return $this->hasMany("App\OverlapCourseApproval");
    }
    public function overlapCourses(){
        return $this->hasMany("App\OverlapCourse");
    }
    public static function all($columns = []){
        // dd(self::all()->sortByDesc("semester_code")->get());
        return self::orderBy('semester_code','desc')->get();
    }
}
