<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\Semester;
use App\OverlapApplication;
use App\CourseTeacher;
use App\Notification;

class OverlapApplicationController extends Controller
{
    public function add(){
        $courses=Course::all();
        $semesters=Semester::all();
        return view('student.add_overlap_application',compact("courses","semesters"));
    }
    public function save(Request $request){
        // var_dump($request->overlaps);
        // die();
        $notificationTo=[];
        $slots=[];
        $i=0;
        $name=auth()->user()->name;
        for($i=0;$i<count($request->overlaps['c1']);$i++){
            $slots[$i]['c1']=$request->overlaps['c1'][$i];
            $slots[$i]['c2']=$request->overlaps['c2'][$i];
            // dump($ct1,$ct2);
        }
        // dd(auth()->user()->name);
        $applicationId= OverlapApplication::create([
            'student_id'=>auth()->user()->student->id,
            'semester_id'=>$request->semester,
            'section'=>$request->section,
            'term'=>$request->term,
            'courses_per_slot'=>\json_encode($slots),
        ])->id;
        foreach($slots as $slot){
            $c1=$slot['c1'];
            $c2=$slot['c2'];
            $ct1=CourseTeacher::where('semester_id',$request->semester)->where('course_id',$c1)->get();
            $ct2=CourseTeacher::where('semester_id',$request->semester)->where('course_id',$c2)->get();
            foreach($ct1 as $teacher){
                if(!in_array($teacher->teacher_id,$notificationTo)){
                    // \dump($teacher->teacher->user->id);
                    $id=$teacher->teacher->user->id;
                    Notification::create([
                        'user_id'=>$id,
                        'type'=>'OVERLAP_APPLICATION',
                        'link'=>'overlap_application/'.$applicationId,
                        'subject'=>$name." has applied for overlap exam"
                    ]);
                    $notificationTo[]=$teacher->teacher_id;
                }
            }
        }
    }
}