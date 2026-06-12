<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <div class="logo-header" data-background-color="dark">
            <a href="{{ url('/dashboard') }}" class="logo">
                <img src="{{ asset('assets/img/kaiadmin/logo_light.svg') }}" alt="navbar brand" class="navbar-brand" height="20">
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item {{ Request::is('dashboard') || Request::is('/') ? 'active' : '' }}">
                    <a href="{{ url('/dashboard') }}">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Components</h4>
                </li>

                <li class="nav-item {{ Request::is('buttons', 'gridsystem', 'panels', 'notifications', 'typography', 'sweetalert') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#baseMenu" aria-expanded="{{ Request::is('buttons', 'gridsystem', 'panels', 'notifications', 'typography', 'sweetalert') ? 'true' : 'false' }}">
                        <i class="fas fa-layer-group"></i>
                        <p>Base Components</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ Request::is('buttons', 'gridsystem', 'panels', 'notifications', 'typography', 'sweetalert') ? 'show' : '' }}" id="baseMenu">
                        <ul class="nav nav-collapse">
                            <li class="{{ Request::is('buttons') ? 'active' : '' }}">
                                <a href="{{ url('/buttons') }}"><span class="sub-item">Buttons</span></a>
                            </li>
                            <li class="{{ Request::is('gridsystem') ? 'active' : '' }}">
                                <a href="{{ url('/gridsystem') }}"><span class="sub-item">Grid System</span></a>
                            </li>
                            <li class="{{ Request::is('panels') ? 'active' : '' }}">
                                <a href="{{ url('/panels') }}"><span class="sub-item">Panels</span></a>
                            </li>
                            <li class="{{ Request::is('notifications') ? 'active' : '' }}">
                                <a href="{{ url('/notifications') }}"><span class="sub-item">Notifications</span></a>
                            </li>
                            <li class="{{ Request::is('typography') ? 'active' : '' }}">
                                <a href="{{ url('/typography') }}"><span class="sub-item">Typography</span></a>
                            </li>
                            <li class="{{ Request::is('sweetalert') ? 'active' : '' }}">
                                <a href="{{ url('/sweetalert') }}"><span class="sub-item">Sweet Alert</span></a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item {{ Request::is('font-awesome', 'simple-line') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#sidebarIcons" aria-expanded="{{ Request::is('font-awesome', 'simple-line') ? 'true' : 'false' }}">
                        <i class="fas fa-pen-square"></i>
                        <p>Icons</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ Request::is('font-awesome', 'simple-line') ? 'show' : '' }}" id="sidebarIcons">
                        <ul class="nav nav-collapse">
                            <li class="{{ Request::is('font-awesome') ? 'active' : '' }}">
                                <a href="{{ url('/font-awesome') }}"><span class="sub-item">Font Awesome Icons</span></a>
                            </li>
                            <li class="{{ Request::is('simple-line') ? 'active' : '' }}">
                                <a href="{{ url('/simple-line') }}"><span class="sub-item">Simple Line Icons</span></a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item {{ Request::is('avatars') ? 'active' : '' }}">
                    <a href="{{ url('/avatars') }}">
                        <i class="fas fa-user-circle"></i>
                        <p>Avatars</p>
                    </a>
                </li>

                <li class="nav-item {{ Request::is('forms') ? 'active' : '' }}">
                    <a href="{{ url('/forms') }}">
                        <i class="fas fa-pen-alt"></i>
                        <p>Forms</p>
                    </a>
                </li>

                <li class="nav-item {{ Request::is('tables', 'datatables') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#sidebarTables" aria-expanded="{{ Request::is('tables', 'datatables') ? 'true' : 'false' }}">
                        <i class="fas fa-table"></i>
                        <p>Tables</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ Request::is('tables', 'datatables') ? 'show' : '' }}" id="sidebarTables">
                        <ul class="nav nav-collapse">
                            <li class="{{ Request::is('tables') ? 'active' : '' }}">
                                <a href="{{ url('/tables') }}"><span class="sub-item">Basic Tables</span></a>
                            </li>
                            <li class="{{ Request::is('datatables') ? 'active' : '' }}">
                                <a href="{{ url('/datatables') }}"><span class="sub-item">DataTables</span></a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item {{ Request::is('googlemaps', 'jsvectormap') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#sidebarMaps" aria-expanded="{{ Request::is('googlemaps', 'jsvectormap') ? 'true' : 'false' }}">
                        <i class="fas fa-map-marker-alt"></i>
                        <p>Maps</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ Request::is('googlemaps', 'jsvectormap') ? 'show' : '' }}" id="sidebarMaps">
                        <ul class="nav nav-collapse">
                            <li class="{{ Request::is('googlemaps') ? 'active' : '' }}">
                                <a href="{{ url('/googlemaps') }}"><span class="sub-item">Google Maps</span></a>
                            </li>
                            <li class="{{ Request::is('jsvectormap') ? 'active' : '' }}">
                                <a href="{{ url('/jsvectormap') }}"><span class="sub-item">JSVectorMap</span></a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item {{ Request::is('charts', 'sparkline', 'widgets') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#sidebarCharts" aria-expanded="{{ Request::is('charts', 'sparkline', 'widgets') ? 'true' : 'false' }}">
                        <i class="far fa-chart-bar"></i>
                        <p>Charts</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ Request::is('charts', 'sparkline', 'widgets') ? 'show' : '' }}" id="sidebarCharts">
                        <ul class="nav nav-collapse">
                            <li class="{{ Request::is('charts') ? 'active' : '' }}">
                                <a href="{{ url('/charts') }}"><span class="sub-item">Chart.js</span></a>
                            </li>
                            <li class="{{ Request::is('sparkline') ? 'active' : '' }}">
                                <a href="{{ url('/sparkline') }}"><span class="sub-item">Sparkline</span></a>
                            </li>
                            <li class="{{ Request::is('widgets') ? 'active' : '' }}">
                                <a href="{{ url('/widgets') }}"><span class="sub-item">Widgets</span></a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Pages</h4>
                </li>
                <li class="nav-item {{ Request::is('welcome') ? 'active' : '' }}">
                    <a href="{{ url('/welcome') }}">
                        <i class="fas fa-star"></i>
                        <p>Welcome</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
