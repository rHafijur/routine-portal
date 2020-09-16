<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','phone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function student()
    {
        return $this->hasOne('App\Student');
    }
    public function teacher()
    {
        return $this->hasOne('App\Teacher');
    }
    public function notification()
    {
        return $this->hasMany('App\Notification');
    }
    public function privileges()
    {
        return $this->belongsToMany('App\Privilege','privilege_users');
    }
    public function isAdmin(){
        foreach($this->privileges as $privilege){
            if($privilege->id==1){
                return true;
            }
        }
        return false;
    }
    public function isTeacher(){
        foreach($this->privileges as $privilege){
            if($privilege->id==2){
                return true;
            }
        }
        return false;
    }
    public function isStudent(){
        foreach($this->privileges as $privilege){
            if($privilege->id==3){
                return true;
            }
        }
        return false;
    }
}
