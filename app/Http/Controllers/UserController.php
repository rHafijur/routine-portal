<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function setStat($id,$status){
        $user=User::find($id);
        $user->is_active=$status;
        $user->save();
        return redirect()->back();
    }
}
