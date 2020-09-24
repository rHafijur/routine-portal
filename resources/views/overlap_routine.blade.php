@extends('layouts.app')

@section('content')
<style>
    @media print {
  body * {
    visibility: hidden;
  }
  #printable, #printable * {
    visibility: visible;
  }
  #printable {
    position: absolute;
    left: 0;
    top: 0;
  }
}
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ __("Overlap Routine: ".$semester->title." ".strtoupper($routine->term)) }}
                    @auth
                    @if (auth()->user()->isAdmin())
                    <div class="float-right">
                        <a href="{{url('edit_overlap_routine/?semester='.$semester->semester_code."&term=".$routine->term)}}"><button class="btn btn-info">Edit</button></a>
                    </div>
                    @endif
                    @endauth
                </div>
                <div class="card-body" id="printable">
                    <div class="row justify-content-md-center">
                        <div class="col">
                            <div class="d-flex justify-content-center" style="text-align: center">
                                <div class="row">
                                    <div class="col-md-3">
                                        <img height="110px" width="100px" src="{{asset('assets/images/logo.png')}}" alt="DIU logo" margin="0 -10px 20px 0">
                                    </div>
                                   <div class="col-md-9">
                                    Daffodil International University <br>
                                    Department of software Engineering (SWE) <br>
                                    Faculty of Science & Information Technology (FSIT) <br>
                                    {{ __("Overlap Exam ".$semester->title." ".strtoupper($routine->term)) }}
                                   </div>
                                </div>
                            </div>
                            @foreach (json_decode($routine->data) as $day)
                            {{-- @php
                                dd($day);
                            @endphp --}}
                            <div class="row border routine_row">
                                <div class="col-md-2">
                                    <div class="align-middle">
                                        {{Carbon\Carbon::parse($day->date)->toFormattedDateString()}} <br>
                                        {{Carbon\Carbon::parse($day->date)->englishDayOfWeek}}
                                    </div>
                                </div>
                                <div class="time_slots col row">
                                    @foreach ($day->slots as $slot)
                                    <div class="card col time_slot">
                                        <div class="card-header">
                                            <b>Slot {{$slot->name}}</b> <b>{{$slot->starts}} - {{$slot->ends}}</b> <br>
                                            {{-- <small>total student <b>`+total_students+`</b></small> --}}
                                        </div>
                                        <div class="card-body" style="padding: 0">
                                            <ul class="list-group">
                                                @foreach ($slot->courses as $course)
                                                    @php
                                                        $course=App\Course::find($course);
                                                        $cnt=App\OverlapApplication::where('semester_id',$semester->id)->where('term',$routine->term)->where('c1_status',1)->where('c2_status',1)->where('c2_id',$course->id)->select(DB::raw("count(c2_id) as student_count, c2_id as course_id"))->groupBy('course_id')->first();
                                                        // dump($cnt);
                                                    @endphp
                                                    <li class="list-group-item">{{$course->course_code}} - {{$course->title}} <small>({{$cnt->student_count}} person)</small></li>
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
