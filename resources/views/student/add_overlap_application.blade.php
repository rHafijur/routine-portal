@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Overlap Application') }}</div>

                <div class="card-body">
                    <form method="POST" id="applicationForm" action="{{ route('save_overlap_application') }}" >
                        @csrf
                        <div class="form-group row">
                            <label for="semester" class="col-md-4 col-form-label text-md-right">{{ __('Semester') }}</label>

                            <div class="col-md-6">
                                <select required name="semester" id="semester" class="form-control @error('semester') is-invalid @enderror" onchange="semesterChange(this)" id="semester">
                                    <option value="">Select...</option>
                                    @foreach ($semesters as $semester)
                                        <option value="{{$semester->id}}">{{$semester->title}}</option>
                                    @endforeach
                                </select>
                                @error('semester')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="term" class="col-md-4 col-form-label text-md-right">{{ __('Term') }}</label>

                            <div class="col-md-6">
                                <select required name="term" id="term" class="form-control @error('term') is-invalid @enderror" id="term">
                                    <option value="">Select...</option>
                                    <option value="mid">Mid</option>
                                    <option value="final">Final</option>
                                </select>
                                @error('term')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('During Exam') }}</label>

                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col">
                                      <select name="c1_id" id="c1" class="form-control" onchange="c1change(this)"required>
                                          
                                      </select>
                                    </div>
                                    <div class="col">
                                        <select class="form-control" name="c1_teacher_id" id="c1section" required>
                                        </select>
                                    </div>
                                  </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('During Overlap Exam') }}</label>

                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col">
                                      <select name="c2_id" id="c2" onchange="c2change(this)" class="form-control" required>
                                          
                                      </select>
                                    </div>
                                    <div class="col">
                                        <select class="form-control" name="c2_teacher_id" id="c2section" required>
                                        </select>
                                    </div>
                                  </div>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                    {{ __('Apply') }}
                                </button> --}}
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Apply') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Alert</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            Are you sure, you want to apply for the overlap exam? <br>
            Please remember, overlap exam application can not be undone.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" onclick='$("#applicationForm").submit()' class="btn btn-primary">Apply</button>
        </div>
      </div>
    </div>
  </div>

<script>
    function semesterChange(obj){
        var sid=$(obj).val();
        $.get('{{url("/ajax/get_courses")}}/'+sid,function(data,status){
            if(status=="success"){
                // console.log(data);
                // data=JSON.parse(data);
                var html=`<option value="">Course</option>`;
                for(course of data){
                    html+=`<option value="`+course['id']+`">`+course['course_code']+` - `+course['title']+`</option>`;
                }
                $("#c1").html(html);
            }
        });  
    }
    function c1change(obj){
        var cid=$(obj).val();
        var sid=$('#semester').val();
        cchange(cid,sid,1);
        renderC2();
    }
    function c2change(obj){
        var cid=$(obj).val();
        var sid=$('#semester').val();
        cchange(cid,sid,2);
    }
    function renderC2(){
        var term=$("#term").val();
        var c1=$("#c1").val();
        var semester=$("#semester").val();
        $.get('{{url("/ajax/get_same_slot_courses")}}/'+semester+"/"+term+"/"+c1,function(data,status){
            if(status=="success"){
                // console.log(data);
                // data=JSON.parse(data);
                var html=`<option value="">Course</option>`;
                for(course of data){
                    html+=`<option value="`+course['id']+`">`+course['course_code']+` - `+course['title']+`</option>`;
                }
                $("#c2").html(html);
            }
        });  
    }
    function cchange(cid,sid,no){
        $.get('{{url("ajax/get_course_teachers/")}}/'+sid+"/"+cid,function(data,status){
            if(status=="success"){
                // console.log(data);
                // data=JSON.parse(data);
                var html=`<option value="">Section</option>`;
                for(section of data){
                    html+=`<option value="`+section['teacher_id']+`">`+section['section']+`</option>`;
                }
                $("#c"+no+"section").html(html);
            }
        });  
    }
</script>
@endsection
