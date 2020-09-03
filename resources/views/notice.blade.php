@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                  {{ __("Notices") }}
                  <a href="{{url("add/notice")}}">
                    <button class="btn btn-sm btn-secondary">Add</button>
                  </a>
                </div>
                <div class="card-body">
                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">ID</th>
                          <th scope="col">Date</th>
                          <th scope="col">Subject</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($notices as $notice)
                        <tr>
                          <th scope="row">{{$notice->id}}</th>
                          <th scope="row">{{Carbon\Carbon::parse($notice->created_at)->toFormattedDateString()}}</th>
                          <td>{{$notice->subject}}</td>
                          <td>
                              <a href="{{url("notice/".$notice->id."")}}"><button class="btn btn-sm btn-info">Details</button></a>
                              <a href="{{url("notice/".$notice->id."/edit")}}"><button class="btn btn-sm btn-danger">Edit</button></a>
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
@endsection
