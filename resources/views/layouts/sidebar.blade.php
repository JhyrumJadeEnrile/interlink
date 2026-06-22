<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <div class="logo-header" data-background-color="dark">
            <a href="{{ url('/dashboard') }}" class="logo">
                <img src="{{ asset('assets/img/kaiadmin/logo_light.svg') }}" alt="InternLink" class="navbar-brand" height="20">
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar"><i class="gg-menu-right"></i></button>
                <button class="btn btn-toggle sidenav-toggler"><i class="gg-menu-left"></i></button>
            </div>
            <button class="topbar-toggler more"><i class="gg-more-vertical-alt"></i></button>
        </div>
    </div>

    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">

                {{-- Dashboard --}}
                <li class="nav-item {{ Request::is('dashboard') ? 'active' : '' }}">
                    <a href="{{ url('/dashboard') }}">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                @auth
                @php $role = session('role'); @endphp

                {{-- ── ADMIN ── --}}
                @if($role === 'admin')
                <li class="nav-section">
                    <span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span>
                    <h4 class="text-section">Administration</h4>
                </li>
                <li class="nav-item {{ Request::is('admin/students') ? 'active' : '' }}">
                    <a href="{{ route('admin.student-assignments') }}">
                        <i class="fas fa-user-tag"></i>
                        <p>Student Assignments</p>
                    </a>
                </li>
                @endif

                {{-- ── STUDENT ── --}}
                @if($role === 'student')
                <li class="nav-section">
                    <span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span>
                    <h4 class="text-section">My OJT</h4>
                </li>
                <li class="nav-item {{ Request::is('student/timelogs') ? 'active' : '' }}">
                    <a href="{{ route('student.timelogs') }}">
                        <i class="fas fa-clock"></i>
                        <p>Time Logs</p>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('student/journals') ? 'active' : '' }}">
                    <a href="{{ route('student.journals') }}">
                        <i class="fas fa-book"></i>
                        <p>Weekly Journals</p>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('student/documents') ? 'active' : '' }}">
                    <a href="{{ route('student.documents') }}">
                        <i class="fas fa-file-alt"></i>
                        <p>Documents</p>
                    </a>
                </li>
                @endif

                {{-- ── COORDINATOR ── --}}
                @if($role === 'coordinator')
                <li class="nav-section">
                    <span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span>
                    <h4 class="text-section">Coordinator</h4>
                </li>
                <li class="nav-item {{ Request::is('teacher/students') ? 'active' : '' }}">
                    <a href="{{ route('teacher.students') }}">
                        <i class="fas fa-users"></i>
                        <p>My Students</p>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('teacher/approved-logs') ? 'active' : '' }}">
                    <a href="{{ route('teacher.approved-logs') }}">
                        <i class="fas fa-check-circle"></i>
                        <p>Approved Logs</p>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('reports/final') ? 'active' : '' }}">
                    <a href="{{ route('reports.final') }}">
                        <i class="fas fa-file-pdf"></i>
                        <p>Final OJT Report</p>
                    </a>
                </li>
                @endif

                {{-- ── SUPERVISOR ── --}}
                @if($role === 'supervisor')
                <li class="nav-section">
                    <span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span>
                    <h4 class="text-section">Supervisor</h4>
                </li>
                <li class="nav-item {{ Request::is('supervisor/timelogs/pending') ? 'active' : '' }}">
                    <a href="{{ route('supervisor.timelogs.pending') }}">
                        <i class="fas fa-hourglass-half"></i>
                        <p>Pending Time Logs</p>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('supervisor/profile') ? 'active' : '' }}">
                    <a href="{{ route('supervisor.profile.edit') }}">
                        <i class="fas fa-building"></i>
                        <p>Company Profile</p>
                    </a>
                </li>
                @endif

                @endauth

            </ul>
        </div>
    </div>
</div>