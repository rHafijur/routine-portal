@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __("Routine: ".$semester->title." ".strtoupper($routine->term)) }}
                    <div class="float-right">
                        <a href="{{url('edit_routine/?semester='.$semester->semester_code."&term=".$routine->term)}}"><button class="btn btn-info">Edit</button></a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row justify-content-md-center">
                        <div class="col">
                            @foreach (json_decode($routine->data) as $day)
                            {{-- @php
                                dd($day);
                            @endphp --}}
                            <div class="row border routine_row">
                                <div class="col-md-2">
                                    {{$day->date}}
                                </div>
                                <div class="time_slots col row">
                                    @foreach ($day->slots as $slot)
                                    <div class="card col time_slot">
                                        <div class="card-header">
                                            <b>Slot {{$slot->name}}</b> <b>{{$slot->starts}} - {{$slot->ends}}</b> <br>
                                            {{-- <small>total student <b>`+total_students+`</b></small> --}}
                                        </div>
                                        <div class="card-body" >
                                            <ul class="list-group">
                                                @foreach ($slot->courses as $course)
                                                    @php
                                                        $course=App\Course::find($course);
                                                    @endphp
                                                    <li class="list-group-item">{{$course->course_code}} - {{$course->title}} </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
