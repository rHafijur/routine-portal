@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit semester') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('update_semester') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{$semester->id}}">
                        <div class="form-group row">
                            <label for="semester_code" class="col-md-4 col-form-label text-md-right">{{ __('Semester code') }}</label>

                            <div class="col-md-6">
                                <input id="semester_code" value="{{$semester->semester_code}}" type="text" class="form-control @error('semester_code') is-invalid @enderror" name="semester_code" value="{{ old('semester_code') }}" required autocomplete="semester_code" autofocus>

                                @error('semester_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="title" type="text" value="{{$semester->title}}" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
