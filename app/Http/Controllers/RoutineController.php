<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoutineController extends Controller
{
    public function generate(){
        return view("admin.generate_routine");
    }
}
