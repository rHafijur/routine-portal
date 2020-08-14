<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    protected $fillable=['name'];

    public function users()
    {
        return $this->belongsToMany('App\User','privilege_users');
    }
}
