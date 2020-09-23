<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CourseTeacher;
use App\Semester;
class CourseTeacherController extends Controller
{
    public function save(Request $request){
        // dd($request);
        $request->validate([
            'semester_id' => ['required', 'integer',],
            'teacher_id' => ['required', 'integer'],
            'course_id' => ['required', 'integer'],
            'section' => ['required', 'string'],
            'number_of_students' => ['required', 'integer'],
        ]); 
        CourseTeacher::create([
            'semester_id' => $request->semester_id,
            'teacher_id' => $request->teacher_id,
            'course_id' => $request->course_id,
            'section' => $request->section,
            'number_of_students' => $request->number_of_students,
        ]);
        return redirect()->back();
    }
    public function update(Request $request){
        // dd($request);
        // $request->validate([
        //     'semester_id' => ['required', 'integer',],
        //     'teacher_id' => ['required', 'integer'],
        //     'course_id' => ['required', 'integer'],
        //     'section' => ['required', 'string'],
        //     'number_of_students' => ['required', 'integer'],
        // ]); 
        $course_teacher= CourseTeacher::find($request->id);
        $course_teacher->semester_id=$request->semester_id;
        $course_teacher->teacher_id=$request->teacher_id;
        $course_teacher->course_id=$request->course_id;
        $course_teacher->section=$request->section;
        $course_teacher->number_of_students=$request->number_of_students;
        $course_teacher->save();
        return redirect()->back();
    }
    public function delete($id){
        CourseTeacher::find($id)->delete();
        return redirect()->back();
    }
    public function getCourseTeacher($sid,$cid){
       $courses=  CourseTeacher::where('semester_id',$sid)->where('course_id',$cid)->get();
       return $courses;
    }
    public function getCourses($sid){
       $courses=  Semester::find($sid)->courses()->select('courses.id','course_code','title')->distinct()->get();
       return $courses;
    }
}
