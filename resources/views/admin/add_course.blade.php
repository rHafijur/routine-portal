@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('New Course') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('save_course') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="course_code" class="col-md-4 col-form-label text-md-right">{{ __('Course code') }}</label>

                            <div class="col-md-6">
                                <input id="course_code" type="text" class="form-control @error('course_code') is-invalid @enderror" name="course_code" value="{{ old('course_code') }}" required autocomplete="course_code" autofocus>

                                @error('course_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="total_credits" class="col-md-4 col-form-label text-md-right">{{ __('Total credits') }}</label>

                            <div class="col-md-6">
                                <input id="total_credits" type="number" class="form-control @error('total_credits') is-invalid @enderror" name="total_credits" value="{{ old('total_credits') }}" required autocomplete="total_credits" autofocus>

                                @error('total_credits')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="has_mid" class="col-md-4 col-form-label text-md-right">{{ __('Has mid') }}</label>

                            <div class="col-md-6">
                                <select class="form-control" name="has_mid" id="has_mid">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                                @error('has_mid')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="has_final" class="col-md-4 col-form-label text-md-right">{{ __('Has final') }}</label>

                            <div class="col-md-6">
                                <select class="form-control" name="has_final" id="has_final">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                                @error('has_final')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="has_lab" class="col-md-4 col-form-label text-md-right">{{ __('Has lab') }}</label>

                            <div class="col-md-6">
                                <select class="form-control" name="has_lab" id="has_lab">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                                @error('has_lab')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Save') }}
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
