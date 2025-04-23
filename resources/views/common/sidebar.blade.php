<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard')}}">
    <!-- <img class="img-profile rounded-circle" src="http://localhost/diagnostics/public/images/logo.jpeg"> -->
    <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-car-battery"></i>
    </div>
    <div class="sidebar-brand-text mx-3">DIAGNOSTICS</div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">



<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    {{ __('common.menu_basic') }}
</div>

<!-- Nav Item - Dashboard -->
<li class="nav-item active">
    <a class="nav-link" href="{{ route('dashboard')}}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>{{ __('common.dashboard') }}</span></a>
</li>

<!-- Nav Item - Pages Notification Menu -->
<li class="nav-item">
    <a class="nav-link" href="{{ route('notification-list')}}">
        <i class="fas fa-fw fa-bell"></i>
        <span>{{ __('common.menu_notification_history') }}</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
{{ __('common.memu_management') }}
</div>

@if (auth()->user()->hasPermission('user-read'))
<!-- Nav Item - Pages Users Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsers"
        aria-expanded="true" aria-controls="collapseUsers">
        <i class="fas fa-fw fa-user"></i>
        <span>{{ __('common.menu_users') }}</span>
    </a>
    <div id="collapseUsers" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">{{ __('common.menu_users') }}:</h6>
            <a class="collapse-item" href="{{ route('user-list')}}">{{ __('common.menu_list') }}</a>
            @if (auth()->user()->hasPermission('user-create'))
            <a class="collapse-item" href="{{ route('user-form')}}">{{ __('common.menu_create') }}</a>
            @endif
        </div>
    </div>
</li>
@endif

<!-- Nav Item - Pages Cars Menu -->
@if (auth()->user()->hasPermission('car-read'))
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCars"
        aria-expanded="true" aria-controls="collapseCars">
        <i class="fas fa-fw fa-car"></i>
        <span>{{ __('common.menu_cars') }}</span>
    </a>
    <div id="collapseCars" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">{{ __('common.menu_cars') }}:</h6>
            <a class="collapse-item" href="{{ route('car-list')}}">{{ __('common.menu_list') }}</a>
            @if (auth()->user()->hasPermission('car-create'))
            <a class="collapse-item" href="{{ route('car-form')}}">{{ __('common.menu_create') }}</a>
            @endif
        </div>
    </div>
</li>
@endif

<!-- Nav Item - Utilities Trucks Menu -->
@if (auth()->user()->hasPermission('truck-read'))
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTrucks"
        aria-expanded="true" aria-controls="collapseTrucks">
        <i class="fas fa-fw fa-truck"></i>
        <span>{{ __('common.menu_trucks') }}</span>
    </a>
    <div id="collapseTrucks" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">{{ __('common.menu_trucks') }}:</h6>
            <a class="collapse-item" href="utilities-color.html">{{ __('common.menu_list') }}</a>
            @if (auth()->user()->hasPermission('truck-create'))
            <a class="collapse-item" href="utilities-border.html">{{ __('common.menu_create') }}</a>
            @endif
        </div>
    </div>
</li>
@endif

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>
<!-- End of Sidebar -->