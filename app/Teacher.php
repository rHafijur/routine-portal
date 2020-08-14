<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'user_id','employee_id', 'initial',
    ];
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
