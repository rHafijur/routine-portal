<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $fillable=['semester_code','title'];

    public function courseTeachers(){
        return $this->hasMany("App\CourseTeacher");
    }
}
