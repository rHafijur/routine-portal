<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SWE Exam Routine Portal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <script src="https://kit.fontawesome.com/dbdf98a2b4.js" crossorigin="anonymous"></script>

    <!-- Styles -->
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    SWE Exam Routine Portal
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @auth
                        @if (auth()->user()->isAdmin())
                            @include('layouts.admin_menu')
                        @endif
                        @if (auth()->user()->isStudent())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('add_overlap_application') }}">{{ __('Apply for Overlap Exam') }}</a>
                        </li>
                        @endif
                        @endauth
                        <li class="nav-item @if(request()->segment(1)=='notices') active @endif">
                            <a class="nav-link" href="{{ route('notices') }}">{{ __('Notices') }}</a>
                        </li>
                        <li class="nav-item @if(request()->segment(1)=='routine') active @endif">
                            <a class="nav-link" href="#" data-toggle="modal" data-target="#routineSelectionModal">{{ __('Routines') }}</a>
                        </li>
                        <li class="nav-item @if(request()->segment(1)=='overlap_routine') active @endif">
                            <a class="nav-link" href="#" data-toggle="modal" data-target="#overlapRoutineSelectionModal">{{ __('Overlap Routines') }}</a>
                        </li>
                        {{-- <li class="nav-item @if(request()->segment(1)=='routine') active @endif">
                            <a class="nav-link" href="#" data-toggle="modal" data-target="#overlapSelectionModal">{{ __('Overlap Requests') }}</a>
                        </li> --}}
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ url('notifications') }}">
                                        {{ __('Notifications') }} ({{Auth::user()->notification()->where('is_seen',0)->get()->count()}})
                                    </a>
                                    <a class="dropdown-item" href="{{ route('change_password') }}">
                                        {{ __('Change Password') }}
                                    </a>
                                    <a class="dropdown-item" href="#"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <!-- Routine Modal -->
<div class="modal fade" id="routineSelectionModal" tabindex="-1" aria-labelledby="routineSelectionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="GET" action="{{url("routine")}}">
        <div class="modal-header">
          <h5 class="modal-title" id="routineSelectionModalLabel">Please choice Semester and Term</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
                <div class="row">
                  <div class="col">
                    <select name="semester" class="form-control">
                        <option value="">Select Semester</option>
                        @foreach (App\Semester::all() as $semester)
                            <option value="{{$semester->semester_code}}">{{$semester->title}}</option>
                        @endforeach
                    </select>
                  </div>
                  <div class="col">
                    <select name="term" class="form-control">
                        <option value="">Select Term</option>
                        <option value="mid">Mid Term</option>
                        <option value="final">Final</option>
                    </select>
                  </div>
                </div>
        </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">View Routine</button>
            </div>
        </form>
      </div>
    </div>
  </div>


  <div class="modal fade" id="overlapRoutineSelectionModal" tabindex="-1" aria-labelledby="overlapRoutineSelectionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="GET" action="{{url("overlap_routine")}}">
        <div class="modal-header">
          <h5 class="modal-title" id="overlapRoutineSelectionModalLabel">Please choice Semester and Term</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
                <div class="row">
                  <div class="col">
                    <select name="semester" class="form-control">
                        <option value="">Select Semester</option>
                        @foreach (App\Semester::all() as $semester)
                            <option value="{{$semester->semester_code}}">{{$semester->title}}</option>
                        @endforeach
                    </select>
                  </div>
                  <div class="col">
                    <select name="term" class="form-control">
                        <option value="">Select Term</option>
                        <option value="mid">Mid Term</option>
                        <option value="final">Final</option>
                    </select>
                  </div>
                </div>
        </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">View Routine</button>
            </div>
        </form>
      </div>
    </div>
  </div>


  <div class="modal fade" id="overlapSelectionModal" tabindex="-1" aria-labelledby="overlapSelectionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="GET" action="{{route("overlapRequest")}}">
        <div class="modal-header">
          <h5 class="modal-title" id="overlapSelectionModal">Please choice Semester and Term</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
                <div class="row">
                  <div class="col">
                    <select name="semester" class="form-control">
                        <option value="">Select Semester</option>
                        @foreach (App\Semester::all() as $semester)
                            <option value="{{$semester->semester_code}}">{{$semester->title}}</option>
                        @endforeach
                    </select>
                  </div>
                  <div class="col">
                    <select name="term" class="form-control">
                        <option value="">Select Term</option>
                        <option value="mid">Mid Term</option>
                        <option value="final">Final</option>
                    </select>
                  </div>
                </div>
        </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">View Requests</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
