<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-green sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            @if($userLogin->role == 'admin')
            <div class="sidebar-brand-text mx-3"> ADMIN </div>
        @else
            <div class="sidebar-brand-text mx-3"> GUEST </div>
        @endif
        
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
            <a class="nav-link" href="{{ route('pesticides.dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Home</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Pestisida
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('pesticides.dashboard') }}">
                <i class="fas fa-fw fa-cog"></i>
                <span>Data Pestisida</span>
            </a>
        </li>

        {{-- <% if(currentUser){ %> --}}
            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('pesticides.home') }}">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Manage Data Pestisida</span>
                </a>
            </li>
            {{-- <% } %> --}}
                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Heading -->
                <div class="sidebar-heading">
                    Kriteria
                </div>

                <!-- Nav Item - Charts -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('criteria.index') }}">
                        <i class="fas fa-fw fa-chart-area"></i>
                        <span>Show Data Kriteria</span></a>
                </li>

                

                {{-- <% if(currentUser){ %> --}}
                    <!-- Nav Item - Pages Collapse Menu -->
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="{{ route('criteria.manage') }}">
                            <i class="fas fa-fw fa-folder"></i>
                            <span>Manage Data Kriteria</span>
                        </a>
                    </li>
                    {{-- <% } %> --}}

                    <div class="sidebar-heading">
                        Other
                    </div>

                    <li class="nav-item">
                        <a class="nav-link" href="/logout">
                            <i class="fas fa-fw fa-chart-area"></i>
                            <span>Logout</span></a>
                    </li>


                        <!-- Divider -->
                        <hr class="sidebar-divider d-none d-md-block">

                        <!-- Sidebar Toggler (Sidebar) -->
                        <div class="text-center d-none d-md-inline">
                            <button class="rounded-circle border-0" id="sidebarToggle"></button>
                        </div>

                  






    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>
                <!-- Sidebar Message -->
                <div class="sidebar-card d-none d-lg-flex">
                    {{-- <img class="sidebar-card-illustration mb-2" src="/img/logo.png" alt="..."> --}}
                </div>
                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Nav Item - Alerts -->
                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @if($userLogin->role == 'admin')
                                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ $userLogin->name }}</span>
                                @else
                                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">Guest</span>
                                @endif
                                        <img class="img-profile rounded-circle" src="/img/undraw_profile.svg">
                        </a>

                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                            aria-labelledby="userDropdown">
                            {{-- <% if(!currentUser){ %> --}}
                                <a class="dropdown-item" href="/login">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Login
                                </a>
                                <a class="dropdown-item" href="/register">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Register
                                </a>
                                {{-- <% }else{ %> --}}
                                    <a class="dropdown-item" href="/logout">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Logout
                                    </a>
                                    {{-- <% } %> --}}
                        </div>
                    </li>

                </ul>

            </nav>

            <!-- End of Topbar -->