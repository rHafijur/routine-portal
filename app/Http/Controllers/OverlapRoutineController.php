<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CourseTeacher;
use App\Semester;
use App\OverlapRoutine;
use App\Course;
use App\OverlapApplication;
use DB as DB;

class OverlapRoutineController extends Controller
{
    public function generate(){
        $semester=Semester::where("semester_code",request()->semester)->get()[0];
        $semester_id=$semester->id;
        $term=request()->term;
        // if($term=="mid"){
        //     $courses= $semester->courses()->where('has_mid',1)->distinct()->get();
        // }else{
        //     $courses= $semester->courses()->where('has_final',1)->distinct()->get();
        // }
        $cs= OverlapApplication::where('semester_id',$semester->id)->where('term',$term)->where('c1_status',1)->where('c2_status',1)->select('c2_id')->distinct()->get();
        $courses=[];
        foreach($cs as $c){
            $courses[]=$c->c2;
        }
        // dd($courses);
        // $course_teacher=CourseTeacher::where("semester_id",)->get();
        $student_per_course=OverlapApplication::where('semester_id',$semester->id)->where('term',$term)->where('c1_status',1)->where('c2_status',1)->select(DB::raw("count(c2_id) as student_count, c2_id as course_id"))->groupBy('course_id')->get();
        // $student_per_course=DB::table("course_teachers")->select(DB::raw('sum(number_of_students) as student_count, course_id'))->where('semester_id', '=', $semester_id)->groupBy('course_id')->get();
        // dd($student_per_course);
        $teacher_per_course=DB::table("course_teachers")->join("teachers","course_teachers.teacher_id","teachers.id")
        ->select(DB::raw('course_id,teachers.initial'))->where('semester_id', '=', $semester_id)->get();
        // dd($teacher_per_course);
        return view("admin.generate_overlap_routine",compact('student_per_course','teacher_per_course','semester','term','courses'));
    }
    public function edit(){
        $semester=Semester::where("semester_code",request()->semester)->get()[0];
        $semester_id=$semester->id;
        $term=request()->term;
        // if($term=="mid"){
        //     $courses= $semester->courses()->where('has_mid',1)->distinct()->get();
        // }else{
        //     $courses= $semester->courses()->where('has_final',1)->distinct()->get();
        // }
        $cs= OverlapApplication::where('semester_id',$semester->id)->where('term',$term)->where('c1_status',1)->where('c2_status',1)->select('c2_id')->distinct()->get();
        $courses=[];
        foreach($cs as $c){
            $courses[]=$c->c2;
        }
        // $course_teacher=CourseTeacher::where("semester_id",)->get();
        $routine= OverlapRoutine::where("semester_id",$semester->id)->where('term',$term)->first();
        // $student_per_course=DB::table("course_teachers")->select(DB::raw('sum(number_of_students) as student_count, course_id'))->where('semester_id', '=', $semester_id)->groupBy('course_id')->get();
        $teacher_per_course=DB::table("course_teachers")->join("teachers","course_teachers.teacher_id","teachers.id")
        ->select(DB::raw('course_id,teachers.initial'))->where('semester_id', '=', $semester_id)->get();
        $student_per_course=OverlapApplication::where('semester_id',$semester->id)->where('term',$term)->where('c1_status',1)->where('c2_status',1)->select(DB::raw("count(c2_id) as student_count, c2_id as course_id"))->groupBy('course_id')->get();
        // dd($teacher_per_course);
        return view("admin.edit_overlap_routine",compact('student_per_course','teacher_per_course','semester','term','routine','courses'));
    }
    public function save(Request $request){
        // dd($request);
        OverlapRoutine::create([
            'data'=>$request->data,
            'term'=>$request->term,
            'semester_id'=>$request->semester_id,
        ]);
        return redirect('overlap_approvals?semester='.$request->semester_id."&term=".$request->term);
    }
    public function update(Request $request){
        // dd($request);
        $routine=OverlapRoutine::find($request->id);
        $routine->data=$request->data;
        $routine->save();
        return redirect('overlap_routine/?semester='.$routine->semester->semester_code."&term=".$request->term);
    }
    public function view(){
        $semester=Semester::where("semester_code",request()->semester)->get()[0];
        // $semester_id=$semester->id;
        $term=request()->term;
        $routine= OverlapRoutine::where("semester_id",$semester->id)->where('term',$term)->first();
        if($routine==null){
            return view('errors.routine');
        }
        return view('overlap_routine',compact('semester','routine'));
    }
    public function getSlotCourses($sid,$term,$cid){
        $_slot=[];
        $routine= Routine::where("semester_id",$sid)->where('term',$term)->first();
        foreach(json_decode($routine->data) as $date){
            foreach($date->slots as $slot){
                // dump($slot->courses);
                foreach($slot->courses as $course){
                    if($course==$cid){
                        $_slot=$slot->courses;
                    break;
                    }
                }
            }
        }
        $courses=[];
        foreach($_slot as $c){
            if($cid==$c){
                continue;
            }
            $courses[]=Course::find($c);
        }
        return $courses;
    }
}
