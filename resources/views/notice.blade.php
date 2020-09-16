@extends('layouts.app')

@section('content')
@php
  $isAdmin=false;
    if(auth()->check()){
      $isAdmin=auth()->user()->isAdmin();
    }
@endphp
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                  {{ __("Notices") }}
                  <a href="{{url("add/notice")}}">
                    @if ($isAdmin)
                    <button class="btn btn-sm btn-secondary">Add</button>
                    @endif
                  </a>
                </div>
                <div class="card-body">
                    <table class="table">
                      <thead>
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Views</th>
                          <th scope="col">Subject</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($notices as $notice)
                        <tr>
                            <th scope="row">{{Carbon\Carbon::parse($notice->created_at)->toFormattedDateString()}}</th>
                            <th scope="row">{{$notice->views}}</th>
                          <td>{{$notice->subject}}</td>
                          <td>
                              <a href="{{url("notice/".$notice->id."")}}"><button class="btn btn-sm btn-info">Details</button></a>
                              @if ($isAdmin)
                              <a href="{{url("notice/".$notice->id."/edit")}}"><button class="btn btn-sm btn-warning">Edit</button></a>
                              <a href="{{url("notice/".$notice->id."/delete")}}"><button class="btn btn-sm btn-danger">delete</button></a>
                              @endif
                          </td>
                        </tr>
                        @endforeach
                        
                      </tbody>
                    </table>
                    {{ $notices->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
