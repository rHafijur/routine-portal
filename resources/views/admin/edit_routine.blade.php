@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                  {{ __("Edit Routine (".strtoupper($term).")") }}
                  <button class="btn btn-primary float-right" onclick="save()">Update and Publish</button>
                </div>
                
                <div class="card-body">
                    <div class="row justify-content-md-center">
                        <div class="col">
                            <div id="routineRows">
                                @foreach (json_decode($routine->data) as $day)
                                <div class="row border routine_row">
                                    <div class="col-md-2">
                                        <input class="form-control routine_date" value="{{$day->date}}" type="date">
                                    </div>
                                    <div class="time_slots col row">
                                                @php
                                                    $inc=0;
                                                @endphp
                                        @foreach ($day->slots as $slot)
                                        <div class="card col time_slot" data-slot='{!!json_encode($slot)!!}'>
                                            <div class="card-header">
                                                <b>Slot {{$slot->name}}</b> <b>{{$slot->starts}}-{{$slot->ends}}</b> <br>
                                                <small>total student <b id="ts-{{$inc}}">0</b></small>
                                                <button type="button" class="close" onclick='$(this).closest(".time_slot").remove()' aria-label="Close">
                                                    <span aria-hidden="true"><i class="fas fa-minus-circle"></i></span>
                                                </button>
                                                <button type="button" class="close" data-toggle="modal" onclick="editSlot(this)" data-target="#editSlotModal" aria-label="edit">
                                                    <span aria-hidden="true"><i class="fas fa-edit"></i></span>
                                                </button>
                                            </div>
                                            <div class="card-body" style="padding: 0">
                                                <ul class="list-group">
                                                    @php
                                                        $inc2=0;
                                                    @endphp
                                                    @foreach ($slot->courses as $course)
                                                    @php
                                                        $course=App\Course::find($course);
                                                    @endphp
                                                    <li style="background-color:{{$course->level->color}};" class="list-group-item">{{$course->course_code}} - {{$course->title}} <span id="ct-{{$inc2}}"></span> - <span id="stc-{{$inc2}}"></span></li>
                                                    <script>
                                                        $(function(){
                                                            $("#ct-{{$inc2}}").html(getCourseTeachers({{$course->id}}));
                                                            var stcount=getNumberOfStudentPerCourse({{$course->id}});
                                                            $("#stc-{{$inc2}}").html(stcount);
                                                            var ts=$("#ts-{{$inc}}");
                                                            ts.html(parseInt(ts.html())+parseInt(stcount)); 
                                                        });
                                                    </script>
                                                        @php
                                                        $inc2++;
                                                        @endphp
                                                    @endforeach
                                                    @php
                                                        $inc++;
                                                    @endphp
                                                </ul>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <button type="button" class="close" data-toggle="modal" onclick="addSlot(this)" data-target="#addSlotModal" aria-label="Close">
                                        <span aria-hidden="true"><i class="far fa-plus-square"></i></span>
                                    </button>
                                    <button type="button" class="close" onclick='$(this).closest(".routine_row").remove()' aria-label="Close">
                                        <span aria-hidden="true"><i class="fas fa-minus-circle"></i></span>
                                    </button>
                                </div>
                                @endforeach
                            </div>
                            <div class="row justify-content-md-center">
                                <div class="col-md-auto">
                                    <button onclick="addDay()" title="Add Day" class="btn btn-lg btn-info"><i class="far fa-plus-square"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Button trigger modal -->
<form action="{{route('update_routine')}}" method="POST" id="saveForm">
    @csrf
    <input type="hidden" id="save_id" name="id" value="{{$routine->id}}">
    <input type="hidden" id="save_term" name="term" value="{{$term}}">
    <input type="hidden" id="save_semester_id" name="semester_id" value="{{$semester->id}}">
    <input type="hidden" id="save_data" name="data" >
</form>
<datalist id="slot_list">
    <option value="A">
    <option value="B">
    <option value="C">
    <option value="D">
</datalist>
<datalist id="time_list">
    <option value="8:30 AM">
    <option value="9:00 AM">
    <option value="9:30 AM">
    <option value="10:00 AM">
    <option value="10:30 AM">
    <option value="11:00 AM">
    <option value="11:30 AM">
    <option value="12:00 PM">
    <option value="12:30 PM">
    <option value="01:00 PM">
    <option value="01:30 PM">
    <option value="02:00 PM">
    <option value="02:30 PM">
    <option value="03:00 PM">
    <option value="03:30 PM">
    <option value="04:00 PM">
    <option value="04:30 PM">
    <option value="05:00 PM">
</datalist>
  <!-- Modal -->
  <div class="modal fade" id="addSlotModal" tabindex="-1" role="dialog" aria-labelledby="addSlotModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addSlotModalLabel">Add Slot</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="slot_name">Slot name</label>
                <input list="slot_list" class="form-control" id="slot_name" aria-describedby="emailHelp">
            </div>
            <div class="form-group">
                <label for="slot_starts">Starts</label>
                <input list="time_list" class="form-control" id="slot_starts">
            </div>
            <div class="form-group">
                <label for="slot_ends">Ends</label>
                <input list="time_list" class="form-control" id="slot_ends">
            </div>
            <div class="form-group">
                <label for="slot_ends">Courses <small>(You can selcet multiple courses)</small></label>
                <select class="form-control" id="slot_courses" multiple>
                    @foreach ($courses as $course)
                        <option style="background-color:{{$course->level->color}};color:white;" value="{{$course->id}}">{{$course->title}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="saveSlot()">Save changes</button>
        </div>
      </div>
    </div>
  </div>
  

  <div class="modal fade" id="editSlotModal" tabindex="-1" role="dialog" aria-labelledby="editSlotModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editSlotModalLabel">Edit Slot</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="slot_name">Slot name</label>
                <input list="slot_list" class="form-control" id="edit_slot_name" aria-describedby="emailHelp">
            </div>
            <div class="form-group">
                <label for="slot_starts">Starts</label>
                <input list="time_list" class="form-control" id="edit_slot_starts">
            </div>
            <div class="form-group">
                <label for="slot_ends">Ends</label>
                <input list="time_list" class="form-control" id="edit_slot_ends">
            </div>
            <div class="form-group">
                <label for="slot_ends">Courses <small>(You can selcet multiple courses)</small></label>
                <select class="form-control" id="edit_slot_courses" multiple>
                    @foreach ($courses as $course)
                        <option style="background-color:{{$course->level->color}};color:white;" value="{{$course->id}}">{{$course->title}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="updateSlot()">Save changes</button>
        </div>
      </div>
    </div>
  </div>




<script>
    var courses=`{!!json_encode($courses)!!}`;
    var levels=`{!!json_encode(App\Level::all())!!}`;
    var student_per_course=`{!!json_encode($student_per_course)!!}`;
    var teacher_per_course=`{!!json_encode($teacher_per_course)!!}`;
    courses=JSON.parse(courses);
    student_per_course=JSON.parse(student_per_course);
    teacher_per_course=JSON.parse(teacher_per_course);
    levels=JSON.parse(levels);
    var routine_row;
    var edit_slot;
    function addDay(){
        $("#routineRows").append(`
        <div class="row border routine_row">
            <div class="col-md-2">
                <input class="form-control routine_date" type="date">
            </div>
            <div class="time_slots col row">
                
            </div>
            <button type="button" class="close" data-toggle="modal" onclick="addSlot(this)" data-target="#addSlotModal" aria-label="Close">
                <span aria-hidden="true"><i class="far fa-plus-square"></i></span>
            </button>
            <button type="button" class="close" onclick='$(this).closest(".routine_row").remove()' aria-label="Close">
                <span aria-hidden="true"><i class="fas fa-minus-circle"></i></span>
            </button>
        </div>
        `);
    }
    function addSlot(obj){
        routine_row= $(obj).closest(".routine_row");
        console.log(routine_row);
        filterOptionForAdd();
    }
    function editSlot(obj){
        edit_slot= $(obj).closest(".time_slot");
        var data= $(edit_slot).data("slot");
        // console.log(data);
        $("#edit_slot_name").val(data["name"]);
        $("#edit_slot_starts").val(data["starts"]);
        $("#edit_slot_ends").val(data["ends"]);
        $("#edit_slot_courses").val(data["courses"]);
        filterOptionForEdit(data["courses"]);
    }
    function saveSlot(){
       var slots= $(routine_row).find(".time_slots");
       var slot_name=$("#slot_name");
       var slot_starts=$("#slot_starts");
       var slot_ends=$("#slot_ends");
       var slot_courses=$("#slot_courses");
       var course_arr=getCourses(slot_courses.val());
       var course_list_html="";
       var total_students=0;
       var obj={
           "name":slot_name.val(),
           "starts":slot_starts.val(),
           "ends":slot_ends.val(),
           "courses":slot_courses.val(),
       };
       for(course of course_arr){
           var st_count=getNumberOfStudentPerCourse(course["id"]);
           total_students+=parseInt(st_count);
        course_list_html+=`<li style='background-color:`+getColor(course['level_id'])+`' class="list-group-item">`+course["course_code"]+` - `+course["title"]+` `+getCourseTeachers(course["id"])+` -`+st_count+`</li>`;
       }
    //    console.log(course_list_html);
       $(slots).append(`
       <div class="card col time_slot" data-slot='`+JSON.stringify(obj)+`'>
            <div class="card-header">
                <b>Slot`+slot_name.val()+`</b> <b>`+slot_starts.val()+`-`+slot_ends.val()+`</b> <br>
                <small>total student <b>`+total_students+`</b></small>
                <button type="button" class="close" onclick='$(this).closest(".time_slot").remove()' aria-label="Close">
                    <span aria-hidden="true"><i class="fas fa-minus-circle"></i></span>
                </button>
                <button type="button" class="close" data-toggle="modal" onclick="editSlot(this)" data-target="#editSlotModal" aria-label="edit">
                    <span aria-hidden="true"><i class="fas fa-edit"></i></span>
                </button>
            </div>
            <div class="card-body" style="padding: 0">
                <ul class="list-group">
                    `+course_list_html+`
                </ul>
            </div>
        </div>
       `);
       slot_name.val("");
       slot_starts.val("");
       slot_ends.val("");
       slot_courses.val([]);
    }
    function updateSlot(){
    //    var slots= $(routine_row).find(".time_slots");
       var slot_name=$("#edit_slot_name");
       var slot_starts=$("#edit_slot_starts");
       var slot_ends=$("#edit_slot_ends");
       var slot_courses=$("#edit_slot_courses");
       var course_arr=getCourses(slot_courses.val());
       var course_list_html="";
       var total_students=0;
       var obj={
           "name":slot_name.val(),
           "starts":slot_starts.val(),
           "ends":slot_ends.val(),
           "courses":slot_courses.val(),
       };
       for(course of course_arr){
        var st_count=getNumberOfStudentPerCourse(course["id"]);
        total_students+=parseInt(st_count);
        course_list_html+=`<li style='background-color:`+getColor(course['level_id'])+`' class="list-group-item">`+course["course_code"]+` - `+course["title"]+` `+getCourseTeachers(course["id"])+` -`+st_count+`</li>`;
       }
    //    console.log(course_list_html);
    //    $(editSlot).empty();
       $(edit_slot).html(`
            <div class="card-header">
                <b>Slot `+slot_name.val()+`</b> <b>`+slot_starts.val()+`-`+slot_ends.val()+`</b><br>
                <small>total student <b>`+total_students+`</b></small>
                <button type="button" class="close" onclick='$(this).closest(".time_slot").remove()' aria-label="Close">
                    <span aria-hidden="true"><i class="fas fa-minus-circle"></i></span>
                </button>
                <button type="button" class="close" data-toggle="modal" onclick="editSlot(this)" data-target="#editSlotModal" aria-label="edit">
                    <span aria-hidden="true"><i class="fas fa-edit"></i></span>
                </button>
            </div>
            <div class="card-body" >
                <ul class="list-group">
                    `+course_list_html+`
                </ul>
            </div>
       `);
       slot_name.val("");
       slot_starts.val("");
       slot_ends.val("");
       slot_courses.val([]);
       $(edit_slot).data("slot",obj);
    }
    function getCourses(ids){
        var arr=[];
        for(course of courses){
            // console.log(course);
            for(id of ids){
                if(id==course['id']){
                    arr.push(course);
                    break;
                }
            }
        }
        return arr;
    }
    function getCourseTeachers(id){
        var initials="(";
        for(c of teacher_per_course){
            if(c['course_id']==id){
                initials+=c['initial']+",";
            }
        }
        initials+=")";
        initials=initials.replace(",)",")");
        return initials.toUpperCase();
    }
    function getNumberOfStudentPerCourse(id){
        var count=0;
        for(c of student_per_course){
            if(c['course_id']==id){
                count=c["student_count"];
            }
        }
        return count;
    }
    function routineJSON(){
        var routine=[];
        var routine_rows= $(".routine_row");
        for(rr of routine_rows){
            var routine_date=$($(rr).find(".routine_date")[0]).val();
            var sls=$(rr).find(".time_slot");
            var slot_data_array=[];
            for(sl of sls){
                slot_data_array.push($(sl).data("slot"));
            }
            routine.push({
                "date":routine_date,
                "slots":slot_data_array
            });
        }
        return JSON.stringify(routine);
    }
    function save(){
        var count= courses.length - routineCourses().length;
        if(count>0){
            alert("You Still have "+count+" course(s) to add. You must have to add the course to the routine.");
            return;
        }
        $("#save_data").val(routineJSON());
        $("#saveForm").submit();
    }
    function getColor(level_id){
        for(level of levels){
            if(level_id==level['id']){
                return level['color'];
            }
        }
        return 'white';
    }
    function routineCourses(){
        routine=JSON.parse(routineJSON());
        var course_ids=[]
        for(day of routine){
            for(slot of day.slots){
                for(course_id of slot.courses){
                    course_ids.push(course_id);
                }
            }
        }
        return course_ids;
    }
    function filterOptionForAdd(){
        cs=routineCourses();
        for(opt of $('#slot_courses').children()){
            opt= $(opt);
            if(cs.includes(opt.val())){
                opt.hide();
            }else{
                opt.show();
            }
        }
    }
    function filterOptionForEdit(ids){
        cs=routineCourses();
        for(opt of $('#edit_slot_courses').children()){
            opt= $(opt);
            if(ids.includes(opt.val())){
                opt.show();
                continue;
            }
            console.log("ids");
            if(cs.includes(opt.val())){
                opt.hide();
            }else{
                opt.show();
            }
        }
    }
</script>
@endsection
