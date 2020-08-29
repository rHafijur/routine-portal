<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CourseTeacher;
use App\Semester;
use DB as DB;
class RoutineController extends Controller
{
    public function generate(){
        $semester_id=Semester::where("semester_code",request()->semester)->get()[0]->id;
        // $course_teacher=CourseTeacher::where("semester_id",)->get();
        $student_per_course=DB::table("course_teachers")->select(DB::raw('sum(number_of_students) as student_count, course_id'))->where('semester_id', '=', $semester_id)->groupBy('course_id')->get();
        $teacher_per_course=DB::table("course_teachers")->join("teachers","course_teachers.teacher_id","teachers.id")
        ->select(DB::raw('course_id,teachers.initial'))->where('semester_id', '=', $semester_id)->get();
        // dd($teacher_per_course);
        return view("admin.generate_routine",compact('student_per_course','teacher_per_course'));
    }
}
