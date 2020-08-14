@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                  {{ __("Semesters") }}
                  <a href="{{url("add/semester")}}">
                    <button class="btn btn-sm btn-secondary">Add</button>
                  </a>
                </div>

                <div class="card-body">
                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">Semester code</th>
                          <th scope="col">Title</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($semesters as $semester)
                        <tr>
                          <th scope="row">{{$semester->semester_code}}</th>
                          <td>{{$semester->title}}</td>
                          <td>
                              <a href="{{url("semester/".$semester->id."/edit")}}"><button class="btn btn-sm btn-danger">Edit</button></a>
                              
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
