@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                  {{ __("Courses") }}
                  <a href="{{url("add/course")}}">
                    <button class="btn btn-sm btn-secondary">Add</button>
                  </a>
                </div>
                @php
                    function yesOrNo($val){
                        if($val==1){
                            return "yes";
                        }else{
                            return "no";
                        }
                    }
                @endphp
                <div class="card-body">
                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">Course code</th>
                          <th scope="col">Title</th>
                          <th scope="col">Total credits</th>
                          <th scope="col">Mid</th>
                          <th scope="col">Final</th>
                          <th scope="col">Lab</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($courses as $course)
                        <tr>
                          <th scope="row">{{$course->course_code}}</th>
                          <td>{{$course->title}}</td>
                          <td>{{$course->total_credits}}</td>
                          <td>{{yesOrNo($course->has_mid)}}</td>
                          <td>{{yesOrNo($course->has_final)}}</td>
                          <td>{{yesOrNo($course->has_lab)}}</td>
                          <td>
                              <a href="{{url("course/".$course->id."/edit")}}"><button class="btn btn-sm btn-danger">Edit</button></a>
                              
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
