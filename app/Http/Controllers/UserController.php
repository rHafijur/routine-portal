<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
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
    public function toggolAdmin($id){
        $user=User::find($id);
        if($user->isAdmin()){
            DB::table('privilege_users')->where('user_id',$id)->where('privilege_id',1)->delete();
        }else{
            DB::table('privilege_users')->insert(
                ['user_id' => $id, 'privilege_id' => 1]
            );
        }
        return redirect()->back();
    }
}
