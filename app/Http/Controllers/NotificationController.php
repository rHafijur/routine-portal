<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;
class NotificationController extends Controller
{
    public function  index(){
        $notifications=auth()->user()->notification()->latest()->get();
        // dd($notifications);
        return view('notifications',compact('notifications'));
    }
}
