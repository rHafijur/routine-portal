@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Application') }}</div>
                @php
                    $bg="";
                    if(auth()->user()->isStudent()){
                        if($application->c1_status==1 && $application->c2_status==1){
                            $bg="background-image: url('".asset('assets/images/approved.png')."');background-size: 30% 30%; background-repeat: no-repeat;";
                        }
                        if($application->c1_status==-1 || $application->c2_status==-1){
                            $bg="background-image: url('".asset('assets/images/rejected.png')."');background-size: 30% 30%; background-repeat: no-repeat;";
                        }
                    }
                @endphp
                <div class="card-body" style="padding:75px;{!!$bg!!}">
                    {{Carbon\Carbon::parse($application->created_at)->toFormattedDateString()}} <br>
                    To <br>
                    The Member of Exam Committee,<br>
                    Software Engineering Department,<br>
                    Daffodil International University<br>
                    102, Sukrabad, Mirpur Road, Dhanmondi-1207<br><br>

                    <b>Subject: Application for attending the Overlap of {{($application->term=="mid")?"Mid Term":"Final"}} Exam in {{$application->semester->title}}</b><br><br>

                    Dear Sir, <br>
                    <div align="justify">
                        I am {{$application->student->user->name}}, a regular student in your university. My
                        {{$application->semester->title}} semester {{($application->term=="mid")?"Mid Term":"Final"}} Exam routine is published. This time after getting my exam
                        routine I have noticed that two of my courses are in the same day as well as same time slot. It is not possible
                        for me to attend two courses in the same time.
                    </div>
                    <h6>
                        Details for Overlap Courses
                    </h6>
                    <table class="table table-bordered">
                        <tr>
                            <th>I want to attend this course during regular schedule</th>
                            <th>I want to attend this course during overlap exam</th>
                        </tr>
                        <tr>
                            @php
                                $c1=App\Course::find($application->c1_id);
                                $c2=App\Course::find($application->c2_id);
                            @endphp
                            <td>
                                {{$c1->course_code}} - {{$c1->title}} <br>
                                @if ($application->c1_status==0)
                                    @if (auth()->user()->isTeacher())
                                        @if (auth()->user()->teacher->id==$application->c1_teacher_id)
                                            <a href="{{url("overlap_approve/".$application->id."/1")}}"><button class="btn btn-success btn-sm">Approve</button></a>
                                            <a href="{{url("overlap_reject/".$application->id."/1")}}"><button class="btn btn-danger btn-sm">Reject</button></a>
                                        @endif 
                                     @endif
                                        @elseif($application->c1_status==1)
                                        <button class="btn btn-success btn-sm" disabled>Approved</button>
                                        @elseif($application->c1_status== -1)
                                        <button class="btn btn-danger btn-sm" disabled>Rejected</button>
                                        @endif
                            </td>
                            <td>
                                {{$c2->course_code}} - {{$c2->title}} <br>
                                @if ($application->c2_status==0)
                                    @if (auth()->user()->isTeacher())
                                        @if (auth()->user()->teacher->id==$application->c2_teacher_id)
                                            <a href="{{url("overlap_approve/".$application->id."/2")}}"><button class="btn btn-success btn-sm">Approve</button></a>
                                            <a href="{{url("overlap_reject/".$application->id."/2")}}"><button class="btn btn-danger btn-sm">Reject</button></a>
                                        @endif 
                                     @endif
                                        @elseif($application->c2_status==1)
                                        <button class="btn btn-success btn-sm" disabled>Approved</button>
                                        @elseif($application->c2_status== -1)
                                        <button class="btn btn-danger btn-sm" disabled>Rejected</button>
                                        @endif
                            </td>
                        </tr>
                    </table>
                    <div align="justify">
                        I Therefore, I pray and hope that you will be kind enough to permit me for attending overlap course at the
                        time of Improvement.
                    </div>
                    <br>
                    Yours Obediently, <br>
                    Student Name: {{$application->student->user->name}}<br>
                    Student ID: {{$application->student->student_id}}<br>
                    Batch: {{$application->student->batch}}<br>
                    Mobile: {{$application->student->user->phone}}<br>
                </div>
                {{-- <img style="opacity: 0.4; " src="{{asset('assets/images/approved.png')}}" alt=""> --}}
            </div>
        </div>
    </div>
</div>
@endsection
