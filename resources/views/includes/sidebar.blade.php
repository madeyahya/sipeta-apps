<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-start" href="{{route('admin.dashboard') }}">
        <!-- <img src="{{ asset('assets/admin/images/logoSipeta.png') }}" alt="Logo SIPETA" height="60" class="me-2"> -->
        <span class="sidebar-brand-text">SIPETA ADMIN</span>
    </a>


    <!-- Divider -->
    <hr class="sidebar-divider my-0">


    <li class="nav-item {{ request()->is('admin/dashboard')? 'active' : ''}}">
        <a class="nav-link" href="{{route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Nav Item - Tables -->
    <li class="nav-item {{ request()->is('admin/resident*')? 'active' : ''}}">
        <a class="nav-link" href="{{route('admin.resident.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Data Tamu</span></a>
    </li>

    <li class="nav-item {{ Route::is('admin.service.*') || Route::is('admin.service-status.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{route('admin.service.index') }}">
            <i class="fas fa-hands-helping"></i>
            <span>Data Pengajuan</span></a>
    </li>

     <li class="nav-item {{ request()->is('admin/service-category') || request()->is('admin/service-category/*') ? 'active' : '' }}">
        <a class="nav-link" href="{{route('admin.service-category.index') }}">
            <i class="fas fa-fw fa-folder"></i>
            <span>Data Kategori</span></a>
    </li>

</ul>