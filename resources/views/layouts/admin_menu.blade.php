<li class="nav-item dropdown">
    <a id="usersNavBarDropDown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
        Users <span class="caret"></span>
    </a>

    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="usersNavBarDropDown">
        <a class="dropdown-item" href="{{ route('all_students') }}">Students</a>
        <a class="dropdown-item" href="{{ route('all_teachers') }}">Teachers</a>    
    </div>
</li>