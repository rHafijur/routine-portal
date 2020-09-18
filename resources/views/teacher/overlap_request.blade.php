@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                  {{ __("Overlap Requests on My Courses (".$semester->title." - ".$term.")") }}
                  {{-- <a href="{{url("add/notice")}}">
                    @if ($isAdmin)
                    <button class="btn btn-sm btn-secondary">Add</button>
                    @endif
                  </a> --}}
                </div>
                <div class="card-body">
                    <table class="table">
                      <thead>
                        <tr>
                            <th scope="col">Course</th>
                            <th scope="col">Total Students</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($overlapCourses as $course)
                        <tr>
                            <td scope="row">{{$course->course->course_code." - ".$course->course->title}}</td>
                            <td scope="row">{{$course->total_students}}</td>
                          <td>
                              @if (App\OverlapCourseApproval::where('semester_id',$semester->id)->where('term',$term)->where('teacher_id',auth()->user()->teacher->id)->where('course_id',$course->course_id)->get()->count()>0)
                                  <button class="btn btn-secondary" disabled>Approved</button>
                              @else
                              <a href="{{url("overlap_approve/".$semester->id."/".$term."/".$course->course_id)}}"><button class="btn btn-sm btn-info">Approve</button></a>
                              @endif
                          </td>
                        </tr>
                        @endforeach
                        
                      </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
