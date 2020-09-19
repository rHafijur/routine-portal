<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Semester;
use App\OverlapExamTeacher;
use App\Notification;
use App\Teacher;
use App\Course;
use DB;

class OverlapCourseController extends Controller
{
    public function approvals(){
        $semester=Semester::findOrFail(request()->semester);
        $term=request()->term;
        $approvals=$semester->overlapCourses()->where('term',$term)->select('course_id')->distinct()->get();
        // dd($approvals);
        return view('admin.overlap_approvals',compact('approvals','semester','term'));
    }
    public function assign(Request $request){
        // dd($request);
        OverlapExamTeacher::create([
            'teacher_id'=>$request->teacher,
            'course_id'=>$request->course,
            'semester_id'=>$request->semester,
            'term'=>$request->term
        ]);
        $teacher=Teacher::find($request->teacher);
        $course=Course::find($request->course);
        $semester=Semester::find($request->semester);
        Notification::create([
            'user_id'=>$teacher->user->id,
            'type'=>'OVERLAP_ASSIGN',
            'link'=>'#',
            'subject'=>"You are Requested to prepare overlap question paper for ".$course->course_code." - ".$course->title." (".$request->term." ".$semester->title.")",
        ]);
        return redirect()->back();
    }
    public function unassign($id){
        // dd($request);
        OverlapExamTeacher::find($id)->delete();
        return redirect()->back();
    }
}
