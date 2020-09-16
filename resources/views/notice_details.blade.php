@extends('layouts.app')
@php
    use Illuminate\Support\Facades\Storage as Storage;
@endphp
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Notice on: {{ $notice->subject }}</h3>
                    <h5>{{Carbon\Carbon::parse($notice->created_at)->toFormattedDateString()}}</h5>
                    <h6>Views: {{$notice->views}}</h6>
                </div>
                <div class="card-body">
                    @foreach (json_decode($notice->file_path) as $path)
                        @if (strpos($path, '.pdf') !== false)
                        <iframe src = "/ViewerJS/#..{{Storage::url($path)}}" width='600' height='400' allowfullscreen webkitallowfullscreen></iframe>
                        @else
                        <a href="{{Storage::url($path)}}">{{Storage::url($path)}}</a> <br>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
