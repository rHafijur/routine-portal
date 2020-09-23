<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OverlapApplication extends Model
{
    protected $fillable=['student_id','semester_id','term','c1_id','c1_teacher_id','c1_status','c2_id','c2_teacher_id','c2_status'];

    public function student()
    {
        return $this->belongsTo('App\Student'); 
    }
    public function semester()
    {
        return $this->belongsTo('App\Semester');
    }
    
}
