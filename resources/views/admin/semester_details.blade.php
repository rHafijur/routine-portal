@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span style="font-size:20px">{{$semester->title."-".$semester->semester_code}}</span>
                    <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Add course teacher</button>
                </div>

                <div class="card-body">
                  <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Course</th>
                        <th scope="col">Teacher</th>
                        <th scope="col">Semester</th>
                        <th scope="col">Section</th>
                        <th scope="col">Number of students</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($courseTeachers as $courseTeacher)
                      <tr>
                        <th scope="row">{{$courseTeacher->course->course_code."-".$courseTeacher->course->title}}</th>
                        <td>{{$courseTeacher->teacher->initial." - ".$courseTeacher->teacher->user->name}}</td>
                        <td>{{$courseTeacher->semester->title}}</td>
                        <td>{{$courseTeacher->section}}</td>
                        <td>{{$courseTeacher->number_of_students}}</td>
                        <td>
                            <button class="btn btn-sm btn-danger" onclick="fetchData({{$courseTeacher->id}},{{$courseTeacher->course_id}},{{$courseTeacher->teacher_id}},{{$courseTeacher->semester_id}},'{{$courseTeacher->section}}',{{$courseTeacher->number_of_students}})" data-toggle="modal" data-target="#editModal" >Edit</button>
                            
                            <a href="{{route("delete_course_teacher",['id'=>$courseTeacher->id])}}"><button class="btn btn-sm btn-danger">Delete</button></a>
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





<div class="modal" id="exampleModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Course Teacher To {{$semester->title}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="POST" id="add_course_teacher_form" action="{{route("add_course_teacher")}}">
                @csrf
                <input type="hidden" name="semester_id" value="{{$semester->id}}">
                <div class="form-group">
                  <label for="course" class="col-form-label">Course:</label>
                  <select class="form-control @error('course_id') is-invalid @enderror" name="course_id" id="course">
                      <option value="">Select..</option>
                      @foreach (App\Course::all() as $course)
                        <option value="{{$course->id}}" @if(old('course_id')==$course->id) selected @endif>{{$course->course_code."-".$course->title}}</option>
                      @endforeach
                  </select>
                  @error('course_id')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="form-group">
                    <label for="teacher" class="col-form-label">Teacher:</label>
                    <select class="form-control @error('teacher_id') is-invalid @enderror" name="teacher_id" id="teacher">
                        <option value="">Select..</option>
                        @foreach (App\Teacher::all() as $teacher)
                          <option value="{{$teacher->id}}" @if(old('teacher_id')==$teacher->id) selected @endif>{{$teacher->initial."-".$teacher->user->name}}</option>
                        @endforeach
                    </select>
                    @error('teacher_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="section" class="col-form-label">Section:</label>
                    <select class="form-control @error('section') is-invalid @enderror" name="section" id="section">
                        <option value="">Select..</option>
                        @for ($a='A';$a<='Z';$a++)
                          <option value="{{$a}}" @if(old('section')==$a) selected @endif>{{$a}}</option>
                          @if($a=="AZ")
                            @break
                          @endif
                        @endfor
                    </select>
                    @error('section')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="number_of_students" class="col-form-label">Number of students:</label>
                        <input class="form-control  @error('number_of_students') is-invalid @enderror" value="{{old('number_of_students')}}" type="number" id="number_of_students" name="number_of_students">
                    @error('number_of_students')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
              </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" onclick="$('#add_course_teacher_form').submit()" class="btn btn-primary">Save</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal" id="editModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Course Teacher</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="POST" id="edit_course_teacher_form" action="{{route("update_course_teacher",[])}}">
                @csrf
                <input type="hidden" name="semester_id" value="{{$semester->id}}">
                <input type="hidden" name="id" value="" id="course_teacher_id">
                <div class="form-group">
                  <label for="course_e" class="col-form-label">Course:</label>
                  <select class="form-control" name="course_id" id="course_e">
                      <option value="">Select..</option>
                      @foreach (App\Course::all() as $course)
                        <option value="{{$course->id}}">{{$course->course_code."-".$course->title}}</option>
                      @endforeach
                  </select>
                </div>
                <div class="form-group">
                    <label for="teacher_e" class="col-form-label">Teacher:</label>
                    <select class="form-control" name="teacher_id" id="teacher_e">
                        <option value="">Select..</option>
                        @foreach (App\Teacher::all() as $teacher)
                          <option value="{{$teacher->id}}">{{$teacher->initial."-".$teacher->user->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="section_e" class="col-form-label">Section:</label>
                    <select class="form-control" name="section" id="section_e">
                        <option value="">Select..</option>
                        @for ($a='A';$a<='Z';$a++)
                          <option value="{{$a}}">{{$a}}</option>
                          @if($a=="AZ")
                            @break
                          @endif
                        @endfor
                    </select>
                </div>
                <div class="form-group">
                    <label for="number_of_students_e" class="col-form-label">Number of students:</label>
                        <input class="form-control" value="{{old('number_of_students')}}" type="number" id="number_of_students_e" name="number_of_students">
                </div>
              </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" onclick="$('#edit_course_teacher_form').submit()" class="btn btn-primary">Save</button>
        </div>
      </div>
    </div>
  </div>

  @if ($errors->any())

    <script type="application/javascript">
        $('#exampleModal').modal();
    </script>
  @endif
  <script>
    function fetchData(id,course_id,teacher_id,semester_id,section,number_of_students){
      $("#course_teacher_id").val(id);
      var course_option= $("#course_e").children();
      for(let i=0;i<course_option.length;i++){
        if($(course_option[i]).val()==course_id){
          course_option[i].setAttribute("selected","selected");
        }
      }
      var teacher_option= $("#teacher_e").children();
      for(let i=0;i<teacher_option.length;i++){
        if($(teacher_option[i]).val()==teacher_id){
          teacher_option[i].setAttribute("selected","selected");
        }
      }
      var section_option= $("#section_e").children();
      for(let i=0;i<section_option.length;i++){
        if($(section_option[i]).val()==section){
          section_option[i].setAttribute("selected","selected");
        }
      }
      $("#number_of_students_e").val(number_of_students);
    }
  </script>
@endsection
