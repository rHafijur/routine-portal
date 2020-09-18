<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\Semester;
use App\OverlapApplication;
use App\CourseTeacher;
use App\Notification;
use App\Privilege;
use App\OverlapCourse;
use App\OverlapCourseApproval;
use DB;

class OverlapApplicationController extends Controller
{
    public function view($id){
        if(request()->ref!=null){
            $notification=Notification::find(request()->ref);
            $notification->is_seen=1;
            $notification->save();
        }
        $application=OverlapApplication::findOrFail($id);
        return view('overlap_application',compact('application'));
    }
    public function requests(){
        $semester=Semester::where("semester_code",request()->semester)->get()[0];
        $term=request()->term;
        $overlapCourses=OverlapCourse::where('teacher_id',auth()->user()->teacher->id)
                                    ->where('semester_id',$semester->id)
                                    ->where('term',$term)->groupBy('course_id')
                                    ->select('course_id', DB::raw('count(student_id) as total_students'))
                                    ->orderBy('total_students','desc')->get();
        // dd($overlapCourses);
        return view('teacher.overlap_request',compact('overlapCourses','semester','term'));
    }
    public function approve($semester,$term,$course){
        OverlapCourseApproval::create([
            'teacher_id'=>auth()->user()->teacher->id,
            'course_id'=>$course,
            'semester_id'=>$semester,
            'term'=>$term
        ]);
        return redirect()->back();
    }
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
        $sid=auth()->user()->student->id;
        $applicationId= OverlapApplication::create([
            'student_id'=>$sid,
            'semester_id'=>$request->semester,
            'section'=>$request->section,
            'term'=>$request->term,
            'courses_per_slot'=>\json_encode($slots),
        ])->id;
        foreach($slots as $slot){
            $c1=$slot['c1'];
            $c2=$slot['c2'];
            $ct1=CourseTeacher::select('teacher_id')->where('semester_id',$request->semester)->where('course_id',$c1)->distinct()->get();
            $ct2=CourseTeacher::select('teacher_id')->where('semester_id',$request->semester)->where('course_id',$c2)->distinct()->get();
            foreach($ct1 as $teacher){
                // dump($teacher);
                OverlapCourse::create([
                    'student_id'=>$sid,
                    'teacher_id'=>$teacher->teacher->id,
                    'course_id'=>$c1,
                    'semester_id'=>$request->semester,
                    'term'=>$request->term
                ]);
                $id=$teacher->teacher->user->id;
                if(!in_array($id,$notificationTo)){
                    // \dump($teacher->teacher->user->id);
                    Notification::create([
                        'user_id'=>$id,
                        'type'=>'OVERLAP_APPLICATION',
                        'link'=>'overlap_application/'.$applicationId,
                        'subject'=>$name." has applied for overlap exam"
                    ]);
                    $notificationTo[]=$id;
                }
            }
            foreach($ct2 as $teacher){
                // dump($teacher);
                OverlapCourse::create([
                    'student_id'=>$sid,
                    'teacher_id'=>$teacher->teacher->id,
                    'course_id'=>$c2,
                    'semester_id'=>$request->semester,
                    'term'=>$request->term
                ]);
                $id=$teacher->teacher->user->id;
                if(!in_array($id,$notificationTo)){
                    // \dump($teacher->teacher->user->id);
                    Notification::create([
                        'user_id'=>$id,
                        'type'=>'OVERLAP_APPLICATION',
                        'link'=>'overlap_application/'.$applicationId,
                        'subject'=>$name." has applied for overlap exam"
                    ]);
                    $notificationTo[]=$id;
                }
            }
        }
        // dd(true);
        foreach(Privilege::find(1)->users as $user){
            if(!in_array($user->teacher->id,$notificationTo)){
                Notification::create([
                    'user_id'=>$user->id,
                    'type'=>'OVERLAP_APPLICATION',
                    'link'=>'overlap_application/'.$applicationId,
                    'subject'=>$name." has applied for overlap exam"
                ]);
            }
        }
        return redirect('overlap_application/'.$applicationId);
    }
}
