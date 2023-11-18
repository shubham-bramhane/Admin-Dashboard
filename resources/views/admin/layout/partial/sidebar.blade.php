<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        @can('dashboard-view')
            <li class="nav-item">
                <a class="nav-link @if (Route::is('admin.dashboard.index')) @else collapsed @endif" href="{{ route('admin.dashboard.index') }}">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->
        @endcan
       
        @can('roles-view')

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#role-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-menu-button-wide"></i><span>Role</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="role-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    @can('roles-create')
                        <li>
                            <a href="{{ route('admin.roles.create') }}" @if (Route::is('admin.roles.create')) class="active" @endif>
                                <i class="bi bi-circle"></i><span>Create Role</span>
                            </a>
                        </li>
                    @endcan
                    <li>
                        <a href="{{ route('admin.roles.index') }}" @if (Route::is('admin.roles.index')) class="active" @endif>
                            <i class="bi bi-circle"></i><span>Role List</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End User Nav -->

        @endcan




        <li class="nav-heading">Pages</li>


        {{-- <li class="nav-item">
        <a class="nav-link collapsed" href="pages-login.html">
          <i class="bi bi-box-arrow-in-right"></i>
          <span>Login</span>
        </a>
      </li><!-- End Login Page Nav --> --}}

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('logout') }}"onclick="event.preventDefault();
        document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-in-right"></i>
                <span>Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li><!-- End Login Page Nav -->

    </ul>

</aside><!-- End Sidebar-->
