@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                  {{ __($data['user_type']) }}
                  @if ($data['user_type']=="Teachers")
                  <a href="{{url("add/teacher")}}">
                    <button class="btn btn-sm btn-secondary">Add</button>
                  </a>
                  @endif
                </div>
                @php
                    $users=$data['users'];
                @endphp
                <div class="card-body">
                    @if ($data['user_type']=="Student")
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">Student ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Batch</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($users as $student)
                          <tr>
                            <th scope="row">{{$student->student_id}}</th>
                            <td>{{$student->user->name}}</td>
                            <td>{{$student->batch}}</td>
                            <td>{{$student->user->email}}</td>
                            <td>{{$student->user->phone}}</td>
                            <td>
                                @if ($student->user->is_active==1)
                                <a href="{{url("user/".$student->user->id."/set_stat/0")}}"><button class="btn btn-sm btn-danger">Deactivate</button></a>
                                @else
                                <a href="{{url("user/".$student->user->id."/set_stat/1")}}"><button class="btn btn-sm btn-info">Acctivate</button></a>
                                @endif
                            </td>
                          </tr>
                          @endforeach
                          
                        </tbody>
                      </table>

                    @elseif($data['user_type']=="Teachers")
                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">Employee ID</th>
                          <th scope="col">Name</th>
                          <th scope="col">Initial</th>
                          <th scope="col">Email</th>
                          <th scope="col">Phone</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($users as $teacher)
                        <tr>
                          <th scope="row">{{$teacher->employee_id}}</th>
                          <td>{{$teacher->user->name}}</td>
                          <td>{{$teacher->initial}}</td>
                          <td>{{$teacher->user->email}}</td>
                          <td>{{$teacher->user->phone}}</td>
                          <td>
                              @if ($teacher->user->is_active==1)
                              <a href="{{url("user/".$teacher->user->id."/set_stat/0")}}"><button class="btn btn-sm btn-danger">Deactivate</button></a>
                              @else
                              <a href="{{url("user/".$teacher->user->id."/set_stat/1")}}"><button class="btn btn-sm btn-info">Acctivate</button></a>
                              @endif
                          </td>
                        </tr>
                        @endforeach
                        
                      </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
