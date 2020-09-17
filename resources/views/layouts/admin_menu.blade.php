<li class="nav-item dropdown @if(request()->segment(1)=='users') active @endif">
    <a id="usersNavBarDropDown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
        Users <span class="caret"></span>
    </a>

    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="usersNavBarDropDown">
        <a class="dropdown-item" href="{{ route('all_students') }}">Students</a>
        <a class="dropdown-item" href="{{ route('all_teachers') }}">Teachers</a>    
    </div>
</li>
<li class="nav-item @if(request()->segment(1)=='semesters'||request()->segment(1)=='semester') active @endif"">
    <a class="nav-link" href="{{ route('semesters') }}">{{ __('Semesters') }}</a>
</li>
<li class="nav-item @if(request()->segment(1)=='courses') active @endif"">
    <a class="nav-link" href="{{ route('courses') }}">{{ __('Courses') }}</a>
</li>
{{-- <li class="nav-item">
    <a class="nav-link" href="{{ route('generate_routine') }}">{{ __('Generate Routne') }}</a>
</li> --}}