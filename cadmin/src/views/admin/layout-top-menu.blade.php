<nav class="navbar navbar-expand navbar-light navbar-bg">
    @if(Auth::check() && in_array(Auth::user()->role, ['admin_operator', 'operator_eregulasi']))
        <a class="sidebar-toggle js-ereg-drawer-toggle d-inline-flex d-md-none me-2" role="button" tabindex="0" aria-label="Buka Menu Navigasi e-Regulasi" style="cursor: pointer;">
            <i class="hamburger align-self-center"></i>
        </a>
        <a href="{{ route('dashboard') }}" class="d-inline-flex align-items-center text-decoration-none fw-bold ms-1" style="color: #002060; font-size: 14px; gap: 8px;">
            <span style="width: 32px; height: 32px; border-radius: 8px; background: linear-gradient(135deg, #002060, #1d4ed8); color: #fff; display: inline-flex; align-items: center; justify-content: center; font-size: 13px; flex-shrink: 0;">
                <i class="fa fa-balance-scale"></i>
            </span>
            <span style="line-height: 1.2;">
                e-Regulasi
                <small class="d-block text-muted fw-normal" style="font-size: 11px;">JDIH Kemenko Pangan</small>
            </span>
        </a>
    @else
        <a class="sidebar-toggle js-sidebar-toggle">
            <i class="hamburger align-self-center"></i>
        </a>
    @endif

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
                <a class="nav-link dropdown-toggle d-inline-flex align-items-center gap-1" href="#" data-bs-toggle="dropdown" style="max-width: 220px;">
                    <i class="fa fa-user-circle text-secondary d-sm-none" style="font-size: 18px;"></i>
                    <span class="text-dark text-truncate" style="font-size: 13px; font-weight: 500;">{{ Auth::user()->display_name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end shadow-sm">
                    <a class="dropdown-item" href="{{ url()->admin('profile') }}"><i class="align-middle me-1 fa fa-user"></i> Profile</a>
                    @if(Auth::check() && Auth::user()->role === 'super_admin')
                        <a class="dropdown-item" href="{{ route('dashboard') }}"><i class="align-middle me-1 fa fa-balance-scale"></i> Dashboard e-Regulasi</a>
                        <a class="dropdown-item" href="{{ route('partisipasi-publik') }}" target="_blank"><i class="align-middle me-1 fa fa-globe"></i> Partisipasi Publik</a>
                    @endif
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="{{ url()->admin('logout') }}"><i class="align-middle me-1 fa fa-sign-out-alt"></i> Log out</a>
                </div>
            </li>
        </ul>
    </div>
</nav>