<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OverlapApplication extends Model
{
    protected $fillable=['student_id','semester_id','section','term','courses_per_slot'];
}
