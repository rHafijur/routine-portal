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
                                <select required name="semester" class="form-control @error('semester') is-invalid @enderror" id="semester">
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
                                <select required name="term" class="form-control @error('term') is-invalid @enderror" id="term">
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
                            <label for="section" class="col-md-4 col-form-label text-md-right">{{ __('Section') }}</label>

                            <div class="col-md-6">
                                <input type="text" name="section" class="form-control @error('section') is-invalid @enderror" id="section"/>
                                @error('section')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div id="overlaps">
                            <div class="form-group row">
                                <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Overlap') }}</label>
    
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col">
                                          <select name="overlaps[c1][]" class="form-control">
                                              <option value="">Course 1</option>
                                              @foreach ($courses as $course)
                                              <option value="{{$course->id}}">{{$course->course_code}}-{{$course->title}}</option>
                                              @endforeach
                                          </select>
                                        </div>
                                        <div class="col">
                                            <select name="overlaps[c2][]" class="form-control">
                                                <option value="">Course 2</option>
                                                @foreach ($courses as $course)
                                                <option value="{{$course->id}}">{{$course->course_code}}-{{$course->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                      </div>
                                </div>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-success" onclick="addMore()" type="button"><i class="far fa-plus-square"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
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
    function addMore(){
        $("#overlaps").append(`
        <div class="form-group row">
                                <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Overlap') }}</label>
    
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col">
                                          <select required name="overlaps[c1][]" class="form-control">
                                              <option value="">Course 1</option>
                                              @foreach ($courses as $course)
                                              <option value="{{$course->id}}">{{$course->course_code}}-{{$course->title}}</option>
                                              @endforeach
                                          </select>
                                        </div>
                                        <div class="col">
                                            <select required name="overlaps[c2][]" class="form-control">
                                                <option value="">Course 2</option>
                                                @foreach ($courses as $course)
                                                <option value="{{$course->id}}">{{$course->course_code}}-{{$course->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                      </div>
                                </div>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-danger" onclick="$(this).closest('.row').remove()" type="button"><i class="far fa-minus-square"></i></button>
                                </div>
                            </div>
        `);
    }
</script>
@endsection
