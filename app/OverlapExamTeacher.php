<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OverlapExamTeacher extends Model
{
    protected $fillable=['teacher_id','semester_id','course_id','term'];
    public function course(){
        return $this->belongsTo('App\Course');
    }
    public function teacher(){
        return $this->belongsTo('App\Teacher');
    }
}
