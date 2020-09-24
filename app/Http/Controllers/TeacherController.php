<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Teacher;
use App\User;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function index(){
        $data=[];
        $data['user_type']="Teachers";
        $data['users']=Teacher::latest()->paginate(15);
        return view("admin.users",compact('data'));
    }
    public function add(){
        return view("admin.add_teacher");
    }
    public function edit($id){
        // dd($id);
        $user=User::findOrFail($id);
        return view("admin.edit_teacher",compact('user'));
    }
    public function register(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255','unique:users'],
            'initial' => ['required', 'string', 'max:25'],
            'employee_id' => ['required', 'string', 'max:25'],
            'email' => ['required', 'string', 'email', 'max:255', 'regex:/(.*)@diu\.edu\.bd/i', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $user= User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        Teacher::create([
            'user_id' => $user->id,
            'employee_id'=>$request->employee_id,
            'initial'=>$request->initial,
        ]);
        $user->privileges()->attach(2);
        return redirect()->route('all_teachers');
        // return view("admin.add_teacher");
    }
    public function update(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'initial' => ['required', 'string', 'max:25'],
            'employee_id' => ['required', 'string', 'max:25'],
            'email' => ['required', 'string', 'email', 'max:255', 'regex:/(.*)@diu\.edu\.bd/i'],
        ]);
        $user=User::findOrFail($request->id);
            $user->name= $request->name;
            $user->phone= $request->phone;
            $user->email= $request->email;
            $user->save();
        $teacher=$user->teacher;
        $teacher->employee_id=$request->employee_id;
        $teacher->initial=$request->initial;
        $teacher->save();
        return redirect()->route('all_teachers');
        // return view("admin.add_teacher");
    }
}
