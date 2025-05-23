<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

<!-- Sidebar Toggle (Topbar) -->
<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
    <i class="fa fa-bars"></i>
</button>

<!-- Topbar Navbar -->
<ul class="navbar-nav ml-auto">

    <!-- Nav Item - Alerts -->
    <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bell fa-fw"></i>
            <!-- Counter - Alerts -->
            <span class="badge badge-danger badge-counter"></span>
        </a>
        <!-- Dropdown - Alerts -->
        <div class="alert-dropdown dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
            aria-labelledby="alertsDropdown">
            <h6 class="dropdown-header">
                {{ __('common.alert_center') }}
            </h6>
        </div>
    </li>

    <!-- Nav Item - Language Switcher -->
    <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="langDropdown" role="button"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-globe fa-fw"></i>
            <span class="ml-1">{{ strtoupper(app()->getLocale()) }}</span>
        </a>
        <!-- Dropdown - Language Options -->
        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
            aria-labelledby="langDropdown">
            <a class="dropdown-item {{ app()->getLocale() == 'en' ? 'active' : '' }}"
            href="{{ route('lang-switch', 'en') }}">
                🇬🇧 English
            </a>
            <a class="dropdown-item {{ app()->getLocale() == 'ro' ? 'active' : '' }}"
            href="{{ route('lang-switch', 'ro') }}">
                🇷🇴 Română
            </a>
        </div>
    </li>

    <div class="topbar-divider d-none d-sm-block"></div>

    <!-- Nav Item - User Information -->
    <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
            <img class="img-profile rounded-circle"
                src="{{ asset('images/undraw_profile.svg') }}">
        </a>
        <!-- Dropdown - User Information -->
        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
            aria-labelledby="userDropdown">
            <a class="dropdown-item" href="#">
                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                {{ __('common.profile') }}
            </a>
            <a class="dropdown-item" href="#">
                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                {{ __('common.settings') }}
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('logout')}}">
                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                {{ __('common.logout') }}
            </a>
        </div>
    </li>

</ul>

</nav>
<!-- End of Topbar -->