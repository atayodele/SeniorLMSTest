<div class="navbar">
    <div class="navbar-inner container">
        <div class="sidebar-pusher">
            <a href="javascript:void(0);" class="waves-effect waves-button waves-classic push-sidebar">
                <i class="fa fa-bars"></i>
            </a>
        </div>
        <div class="logo-box">
            <a href="{{ url('/') }}" class="logo-text"><span>Springfield</span></a>
        </div><!-- Logo Box -->
        <div class="search-button">
            <a href="javascript:void(0);" class="waves-effect waves-button waves-classic show-search"><i class="fa fa-search"></i></a>
        </div>
        <div class="topmenu-outer">
            <div class="top-menu">
                <ul class="nav navbar-nav navbar-left">
                    <li>		
                        <a href="javascript:void(0);" class="waves-effect waves-button waves-classic sidebar-toggle"><i class="fa fa-bars"></i></a>
                    </li>
                    <li>
                        <a href="#cd-nav" class="waves-effect waves-button waves-classic cd-nav-trigger"><i class="fa fa-diamond"></i></a>
                    </li>
                    <li>		
                        <a href="javascript:void(0);" class="waves-effect waves-button waves-classic toggle-fullscreen"><i class="fa fa-expand"></i></a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic" data-toggle="dropdown">
                            <span class="user-name">{{ Auth::user()->email }}<i class="fa fa-angle-down"></i></span>
                            <img class="img-circle avatar" src="{{ asset('assets/images/avatar1.png') }}" width="40" height="40" alt="">
                        </a>
                    </li>
                </ul><!-- Nav -->
            </div><!-- Top Menu -->
        </div>
    </div>
</div><!-- Navbar -->
<div class="page-sidebar sidebar horizontal-bar">
    <div class="page-sidebar-inner">
        <ul class="menu accordion-menu">
            @if (Auth::user()->hasRole('admin'))
                <li class="active"><a href="{{ url('/') }}"><span class="menu-icon icon-speedometer"></span><p>Dashboard</p></a></li>
                <li><a href="{{ route('admin.session.index') }}"><span class="menu-icon icon-briefcase"></span><p>Session</p></a></li> 
                <li><a href="{{ route('admin.semester.index') }}"><span class="menu-icon icon-briefcase"></span><p>Semester</p></a> </li> 
                <li><a href="{{ route('admin.level.index') }}"><span class="menu-icon icon-wrench"></span><p>Level</p></a> </li> 
                <li><a href="{{ route('admin.dept.index') }}"><span class="menu-icon icon-wrench"></span><p>Department</p></a> </li> 
                <li><a href="{{ route('admin.course.index') }}"><span class="menu-icon icon-speedometer"></span><p>Course</p></a> </li> 
                <li><a href="{{ route('admin.student.index') }}"><span class="menu-icon icon-users"></span><p>Student</p></a> </li> 
                <li><a href="{{ route('admin.lecturer.index') }}"><span class="menu-icon icon-user"></span><p>Lecturer</p></a> </li> 
            @endif
            @if (Auth::user()->hasRole('student'))
                <li class="active"><a href="{{ url('/student') }}"><span class="menu-icon icon-speedometer"></span><p>Dashboard</p></a></li> 
            @endif
            @if (Auth::user()->hasRole('lecturer'))
                <li class="active"><a href="{{ url('/author') }}"><span class="menu-icon icon-speedometer"></span><p>Dashboard</p></a></li> 
            @endif
            <li>
                <a href="{{ url('/logout') }}" onclick="event.preventDefault();
                                  document.getElementById('logout-form').submit();"><span class="fa fa-sign-out"></span><p> Logout</p></a>
                     <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
            </li>
        </ul>
    </div><!-- Page Sidebar Inner -->
</div><!-- Page Sidebar -->