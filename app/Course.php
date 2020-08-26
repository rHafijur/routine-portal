<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable=["course_code","title","level_id","total_credits","has_mid","has_final","has_lab"];

    public function level(){
        return $this->belongsTo("App\level");
    }
}
