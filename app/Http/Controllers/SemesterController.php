<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Semester;
use App\CourseTeacher;

class SemesterController extends Controller
{
    public function index(){
        $semesters=Semester::all();
        return view('admin.semesters',compact('semesters'));
    }
    public function add(){
        return view('admin.add_semester');
    }
    public function save(Request $request){
        $request->validate([
            'semester_code' => ['required', 'string', 'max:55','unique:semesters'],
            'title' => ['required', 'string', 'max:25'],
        ]);
        Semester::create([
            'semester_code'=>$request->semester_code,
            'title'=>$request->title,
        ]);
        return redirect()->route("semesters");
    }
    public function edit($id){
        $semester=Semester::find($id);
        return view('admin.edit_semester',compact('semester'));
    }
    public function update(Request $request){
        $request->validate([
            'semester_code' => ['required', 'string', 'max:55'],
            'title' => ['required', 'string', 'max:25'],
        ]);
        $semester=Semester::find($request->id);
        $semester->semester_code=$request->semester_code;
        $semester->title=$request->title;
        $semester->save();
        return redirect()->route("semesters");
    }
    public function details($id){
        $semester=Semester::find($id);
        return view('admin.semester_details',compact('semester'));
    }
}
