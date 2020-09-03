@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('New Notice') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('save_notice') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="subject" class="col-md-4 col-form-label text-md-right">{{ __('Subject') }}</label>

                            <div class="col-md-6">
                                <input id="subject" type="text" class="form-control @error('subject') is-invalid @enderror" name="subject" value="{{ old('subject') }}" required autocomplete="subject" autofocus>

                                @error('subject')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div id="files">
                            <div class="form-group row">
                                <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('File') }}</label>
    
                                <div class="col-md-6">
                                    <input  type="file" class="form-control @error('files') is-invalid @enderror" name="documents[]" required aria-describedby="button-addon2">
                                    {{-- <button class="btn btn-sm btn-secondary" type="button"><i class="far fa-plus-square"></i></button> --}}
                                </div>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-success" onclick="addMore()" type="button"><i class="far fa-plus-square"></i></button>
                                </div>
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
<script>
    function addMore(){
        $("#files").append(`
        <div class="form-group row">
                                <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('File') }}</label>
    
                                <div class="col-md-6">
                                    <input  type="file" class="form-control @error('files') is-invalid @enderror" name="documents[]" required aria-describedby="button-addon2">
                                    {{-- <button class="btn btn-sm btn-secondary" type="button"><i class="far fa-plus-square"></i></button> --}}
                                </div>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-danger" onclick="$(this).closest('.row').remove()" type="button"><i class="far fa-minus-square"></i></button>
                                </div>
                            </div>
        `);
    }
</script>
@endsection
