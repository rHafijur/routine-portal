<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;

class CourseController extends Controller
{
    public function index(){
        $courses=Course::all();
        return view('admin.courses',compact('courses'));
    }
    public function add(){
        return view('admin.add_course');
    }
    public function save(Request $request){
        $request->validate([
            'course_code' => ['required', 'string', 'max:55','unique:courses'],
            'title' => ['required', 'string', 'max:25'],
            'total_credits' => ['required', 'integer'],
        ]);
        Course::create([
            'course_code'=>$request->course_code,
            'title'=>$request->title,
            'total_credits'=>$request->total_credits,
            'has_mid'=>$request->has_mid,
            'has_final'=>$request->has_final,
            'has_lab'=>$request->has_lab,
        ]);
        return redirect()->route("courses");
    }
    public function edit($id){
        $course=Course::find($id);
        return view('admin.edit_course',compact('course'));
    }
    public function update(Request $request){
        $request->validate([
            'course_code' => ['required', 'string', 'max:55'],
            'title' => ['required', 'string', 'max:25'],
            'total_credits' => ['required', 'integer'],
        ]);
        $course=Course::find($request->id);
        $course->course_code=$request->course_code;
        $course->title=$request->title;
        $course->total_credits=$request->total_credits;
        $course->has_mid=$request->has_mid;
        $course->has_final=$request->has_final;
        $course->has_lab=$request->has_lab;
        $course->save();
        return redirect()->route("courses");
    }
}
