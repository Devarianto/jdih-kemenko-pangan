<nav class="navbar navbar-expand navbar-light navbar-bg">
	<a class="sidebar-toggle js-sidebar-toggle">
        <i class="hamburger align-self-center"></i>
    </a>

    <div class="navbar-collapse collapse">
        <ul class="navbar-nav navbar-align align-items-center">
            @if(Auth::check() && Auth::user()->role === 'super_admin')
                <li class="nav-item me-2 d-none d-md-inline-block">
                    <a href="{{ route('dashboard') }}" class="btn btn-sm btn-primary" style="font-weight:600; border-radius:20px; padding: 5px 14px; background-color: #002060; border-color: #002060;">
                        <i class="fa fa-balance-scale me-1"></i> Buka e-Regulasi
                    </a>
                </li>
                <li class="nav-item me-2 d-none d-md-inline-block">
                    <a href="{{ route('partisipasi-publik') }}" target="_blank" class="btn btn-sm btn-outline-info" style="font-weight:600; border-radius:20px; padding: 5px 14px;">
                        <i class="fa fa-globe me-1"></i> Web Partisipasi Publik
                    </a>
                </li>
            @endif
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                    <span class="text-dark">{{ Auth::user()->display_name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="{{ url()->admin('profile') }}"><i class="align-middle me-1 fa fa-user"></i> Profile</a>
                    @if(Auth::check() && Auth::user()->role === 'super_admin')
                        <a class="dropdown-item" href="{{ route('dashboard') }}"><i class="align-middle me-1 fa fa-balance-scale"></i> Dashboard e-Regulasi</a>
                        <a class="dropdown-item" href="{{ route('partisipasi-publik') }}" target="_blank"><i class="align-middle me-1 fa fa-globe"></i> Partisipasi Publik</a>
                    @endif
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ url()->admin('logout') }}">Log out</a>
                </div>
            </li>
        </ul>
    </div>
</nav>