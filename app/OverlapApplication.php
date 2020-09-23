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
    public function c1()
    {
        return $this->belongsTo('App\Course','c1_id'); 
    }
    public function c2()
    {
        return $this->belongsTo('App\Course','c2_id'); 
    }
    public function c1_teacher()
    {
        return $this->belongsTo('App\Teacher','c1_teacher_id'); 
    }
    public function c2_teacher()
    {
        return $this->belongsTo('App\Teacher','c2_teacher_id'); 
    }
    public function semester()
    {
        return $this->belongsTo('App\Semester');
    }
    
}
