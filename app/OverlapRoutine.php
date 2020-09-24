<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OverlapRoutine extends Model
{
    protected $fillable=['term','semester_id','data'];
    public function semester(){
        return $this->belongsTo("App\Semester");
    }
}
