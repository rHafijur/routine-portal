<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Users;

class StudentController extends Controller
{
    public function index(){
        $data=[];
        $data['user_type']="Student";
        $data['users']=Student::all();
        // dd($data['users'][0]->user->name);
        return view("admin.users",compact('data'));
    }
}
