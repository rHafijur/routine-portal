<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable=["course_code","title","total_credits","has_mid","has_final","has_lab"];
}
