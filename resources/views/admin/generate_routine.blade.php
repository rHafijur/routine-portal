@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                  {{ __("Generate Routine") }}
                  
                </div>
                
                <div class="card-body">
                    <div class="row justify-content-md-center">
                        <div class="col">
                            <div id="routineRows">
                                
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
                <input type="text" class="form-control" id="slot_name" aria-describedby="emailHelp" placeholder="Ex: Slot A">
            </div>
            <div class="form-group">
                <label for="slot_starts">Starts</label>
                <input type="time" class="form-control" id="slot_starts">
            </div>
            <div class="form-group">
                <label for="slot_ends">Ends</label>
                <input type="time" class="form-control" id="slot_ends">
            </div>
            <div class="form-group">
                <label for="slot_ends">Courses <small>(You can selcet multiple courses)</small></label>
                <select class="form-control" id="slot_courses" multiple>
                    @foreach (App\Course::all() as $course)
                        <option value="{{$course->id}}">{{$course->title}}</option>
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
                <input type="text" class="form-control" id="edit_slot_name" aria-describedby="emailHelp" placeholder="Ex: Slot A">
            </div>
            <div class="form-group">
                <label for="slot_starts">Starts</label>
                <input type="time" class="form-control" id="edit_slot_starts">
            </div>
            <div class="form-group">
                <label for="slot_ends">Ends</label>
                <input type="time" class="form-control" id="edit_slot_ends">
            </div>
            <div class="form-group">
                <label for="slot_ends">Courses <small>(You can selcet multiple courses)</small></label>
                <select class="form-control" id="edit_slot_courses" multiple>
                    @foreach (App\Course::all() as $course)
                        <option value="{{$course->id}}">{{$course->title}}</option>
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
    var courses=`{!!json_encode(App\Course::all())!!}`;
    courses=JSON.parse(courses);
    var routine_row;
    var edit_slot;
    function addDay(){
        $("#routineRows").append(`
        <div class="row border routine_row">
            <div class="col-md-2">
                <input class="form-control" type="date">
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
    }
    function editSlot(obj){
        edit_slot= $(obj).closest(".time_slot");
        var data= $(edit_slot).data("slot");
        // console.log(data);
        $("#edit_slot_name").val(data["name"]);
        $("#edit_slot_starts").val(data["starts"]);
        $("#edit_slot_ends").val(data["ends"]);
        $("#edit_slot_courses").val(data["courses"]);
    }
    function saveSlot(){
       var slots= $(routine_row).find(".time_slots");
       var slot_name=$("#slot_name");
       var slot_starts=$("#slot_starts");
       var slot_ends=$("#slot_ends");
       var slot_courses=$("#slot_courses");
       var course_arr=getCourses(slot_courses.val());
       var course_list_html="";
       var obj={
           "name":slot_name.val(),
           "starts":slot_starts.val(),
           "ends":slot_ends.val(),
           "courses":slot_courses.val(),
       };
       for(course of course_arr){
        course_list_html+=`<li class="list-group-item">`+course["course_code"]+` - `+course["title"]+`</li>`;
       }
    //    console.log(course_list_html);
       $(slots).append(`
       <div class="card col time_slot" data-slot='`+JSON.stringify(obj)+`'>
            <div class="card-header">
                <b>`+slot_name.val()+`</b> <b>`+slot_starts.val()+`-`+slot_ends.val()+`</b> 
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
       var obj={
           "name":slot_name.val(),
           "starts":slot_starts.val(),
           "ends":slot_ends.val(),
           "courses":slot_courses.val(),
       };
       for(course of course_arr){
        course_list_html+=`<li class="list-group-item">`+course["course_code"]+` - `+course["title"]+`</li>`;
       }
    //    console.log(course_list_html);
    //    $(editSlot).empty();
       $(edit_slot).html(`
            <div class="card-header">
                <b>`+slot_name.val()+`</b> <b>`+slot_starts.val()+`-`+slot_ends.val()+`</b> 
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
</script>
@endsection
