@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
              {{ __("Number of application per courses approved for Overlap Exam (".$semester->title." - ".$term.")") }}
              {{-- <a href="{{url("add/notice")}}">
                @if ($isAdmin)
                <button class="btn btn-sm btn-secondary">Add</button>
                @endif
              </a> --}}
            </div>
            <div class="card-body">

              <table class="table">
                <tr>
                  <th>Course</th>
                  <th>Number of applications</th>
                </tr>
                @php
                    $apps=App\OverlapApplication::where('semester_id',$semester->id)->where('term',$term)->where('c1_status',1)->where('c2_status',1);
                @endphp
                @foreach ($apps->select('c2_id',DB::raw("count(c2_id) as cnt"))->groupBy('c2_id')->get() as $ap)
                    <tr>
                      <td>{{$ap->c2->title}}</td>
                      <td>{{$ap->cnt}}</td>
                    </tr>
                @endforeach
              </table>
            </div>
        </div>
      </div>
    </div>
    <div class="row justify-content-center" style="margin-top: 10px">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                  {{ __("Overlap Course Approvals by Teachers (".$semester->title." - ".$term.")") }}
                  {{-- <a href="{{url("add/notice")}}">
                    @if ($isAdmin)
                    <button class="btn btn-sm btn-secondary">Add</button>
                    @endif
                  </a> --}}
                </div>
                <div class="card-body">
                    {{-- <table class="table">
                      <thead>
                        <tr>
                            <th scope="col">Course</th>
                            <th scope="col">Approved by</th>
                          <th scope="col">Requested on</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($approvals as $course)
                        <tr>
                            <td scope="row">{{$course->course->course_code." - ".$course->course->title}}</td>
                            <td scope="row">
                                @php
                                    $arr=[];
                                @endphp
                                @foreach ($course->course->overlapCourseApprovals()->where('term',$term)->where('semester_id',$semester->id)->get() as $appr)
                                @php
                                    $name=$appr->teacher->initial." - ".$appr->teacher->user->name;
                                    $data['name']=$name;
                                    $data['id']=$appr->teacher->id;
                                    $arr[]=$data;
                                @endphp
                                    {{$name}} <br>
                                @endforeach
                            </td>
                            <td scope="row">
                                @foreach ($course->course->overlapCourses()->where('term',$term)->where('semester_id',$semester->id)->get() as $app)
                                    {{$app->teacher->initial}} - {{$appr->teacher->user->name}} <br>
                                @endforeach
                            </td>
                            <td>
                                @php
                                    $assigned=App\OverlapExamTeacher::where('term',$term)->where('semester_id',$semester->id)->where('course_id',$course->course->id)->first();
                                @endphp
                                @if ($assigned==null)
                                <button class="btn btn-success btn-sm" onclick='assign(JSON.parse("{!!str_replace('"','\"',json_encode($arr))!!}"),{{$course->course->id}})' data-toggle="modal" data-target="#assignTeacherModal">During Overlap</button>
                                @else
                                <button class="btn btn-secondary" disabled><small>{{$assigned->teacher->initial}} - {{$assigned->teacher->user->name}} (Assigned)</small></button> <br>
                                <a href="{{route('unassign_overlap_teacher',['id'=>$assigned->id])}}"><button class="btn btn-danger btn-sm">Unassign</button></a>
                                @endif                                    
                            </td>
                        </tr>
                        @endforeach
                        
                      </tbody>
                    </table> --}}
                    <table class="table">
                      <tr>
                        <th>Applicant</th>
                        <th>Exam during Scheduled time</th>
                        <th>Exam during Overlap exam</th>
                      </tr>
                      @foreach (App\OverlapApplication::where('semester_id',$semester->id)->where('term',$term)->where('c1_status',1)->where('c2_status',1)->get() as $ap)
                          <tr>
                            <td>{{$ap->student->user->name}}</td>
                            <td>{{$ap->c1->title}} <small>({{$ap->c1_teacher->user->name}})</small></td>
                            <td>{{$ap->c2->title}} <small>({{$ap->c1_teacher->user->name}})</small></td>
                          </tr>
                      @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="assignTeacherModal" tabindex="-1" aria-labelledby="assignTeacherModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="post" action="{{route("assign_overlap_teacher")}}">
            @csrf
            <input type="hidden" name="term" value="{{$term}}" id="term">
            <input type="hidden" name="semester" value="{{$semester->id}}" id="semester">
            <input type="hidden" name="course" id="course">
        <div class="modal-header">
          <h5 class="modal-title" id="assignTeacherModalLabel">Who will prepare The question paper for the overlap exam?</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
                <div class="row">
                  <div class="col">
                    <select name="teacher" id="teacher_field" class="form-control" required>
                        <option value="">Select Teacher</option>
                    </select>
                  </div>
                </div>
        </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Assign</button>
            </div>
        </form>
      </div>
    </div>
  </div>
  <script>
      function assign(teachers,course){
          var html='<option value="">Select Teacher</option>';
        //   teachers=JSON.parse(teachers);
          for(teacher of teachers){
              html+='<option value="'+teacher['id']+'">'+teacher['name']+'</option>';
          }
          $('#teacher_field').html(html);
          $('#course').val(course);
      }
  </script>
@endsection
