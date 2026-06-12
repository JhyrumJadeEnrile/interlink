<div class="sidebar" data-background-color="dark">
  <div class="sidebar-logo">
    <div class="logo-header" data-background-color="dark">
      <a href="{{ url('/dashboard') }}" class="logo">
        <img src="{{ asset('assets/img/kaiadmin/logo_light.svg') }}" alt="navbar brand" class="navbar-brand" height="20" />
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
        <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
          <a href="{{ url('/dashboard') }}">
            <i class="fas fa-home"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <li class="nav-section">
          <span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span>
          <h4 class="text-section">Components</h4>
        </li>
        <li class="nav-item {{ request()->routeIs('admin.charts') ? 'active' : '' }}">
          <a href="{{ route('admin.charts') }}">
            <i class="far fa-chart-bar"></i>
            <p>Charts</p>
          </a>
        </li>
        <li class="nav-item {{ request()->routeIs('admin.widgets') ? 'active' : '' }}">
          <a href="{{ route('admin.widgets') }}">
            <i class="fas fa-desktop"></i>
            <p>Widgets</p>
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>