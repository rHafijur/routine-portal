@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Application') }}</div>

                <div class="card-body" style="padding:75px">
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
                            <th>Overlap No.</th>
                            <th>Course 1</th>
                            <th>Course 2</th>
                        </tr>
                        @foreach (json_decode($application->courses_per_slot) as $slot)
                        <tr>
                            @php
                                $c1=App\Course::find($slot->c1);
                                $c2=App\Course::find($slot->c2);
                            @endphp
                            <td>{{$loop->iteration}}</td>
                            <td>{{$c1->course_code}} - {{$c1->title}}</td>
                            <td>{{$c2->course_code}} - {{$c2->title}}</td>
                        </tr>
                        @endforeach
                    </table>
                    <div align="justify">
                        ITherefore, I pray and hope that you will be kind enough to permit me for attending overlap course at the
                        time of Improvement.
                    </div>
                    <br>
                    Yours Obediently, <br>
                    Student Name: {{$application->student->user->name}}<br>
                    Student ID: {{$application->student->student_id}}<br>
                    Section: {{$application->section}}<br>
                    Batch: {{$application->student->batch}}<br>
                    Mobile: {{$application->student->user->phone}}<br>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
