<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'user_id','student_id', 'batch',
    ];
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
