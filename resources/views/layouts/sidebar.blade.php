<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-green sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('pesticides.dashboard') }}">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fa-solid fa-pepper-hot"></i>
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
                <i class="fa-solid fa-house"></i>
                <span>Home</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">


        @if($userLogin->role == 'admin')

        <div class="sidebar-heading">
            Hasil Kalkulasi
        </div>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('history') }}">
                <i class="fas fa-fw fa-history"></i>
                <span>Riwayat Perankingan User</span>
            </a>
        </li>

        <!-- Heading -->
        <div class="sidebar-heading">
            Pestisida
        </div>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('pesticides.dashboard') }}">
                <i class="fa-solid fa-database"></i>
                <span>Data Pestisida</span>
            </a>
        </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('pesticides.home') }}">
                    <i class="fa-solid fa-list-check"></i>
                    <span>Kelola Data Pestisida</span>
                </a>
            </li>
                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Heading -->
                <div class="sidebar-heading">
                    Kriteria
                </div>

                <!-- Nav Item - Charts -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('criteria.index') }}">
                        <i class="fa-solid fa-database"></i>
                        <span>Data Kriteria</span></a>
                </li>

                    <!-- Nav Item - Pages Collapse Menu -->
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="{{ route('criteria.manage') }}">
                            <i class="fa-solid fa-list-check"></i>
                            <span>Kelola Data Kriteria</span>
                        </a>
                    </li>
                @endif

                @if($userLogin->role == 'admin')
                    <div class="sidebar-heading">
                        Lainnya
                    </div>
                @else
                    <div class="sidebar-heading">
                        Kalkulasi
                    </div>
                    <li class="nav-item">
                        <a class="nav-link" href={{ route('compare.criteria') }}>
                            <i class="fas fa-fw fa-calculator"></i>
                            <span>Kalkulasi Kriteria</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/user/compare/alternatives/0">
                            <i class="fas fa-fw fa-calculator"></i>
                            <span>Kalkulasi Alternatif</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href={{ route('history.latest') }} >
                            <i class="fa-solid fa-ranking-star"></i>
                            <span>Ranking</span>
                        </a>
                    </li>
                @endif

                @if($userLogin->role == 'user')
                <div class="sidebar-heading">
                    Lainnya
                </div>
                @endif
                    <li class="nav-item">
                        <a class="nav-link" href="/logout">
                            <i class="fa-solid fa-right-from-bracket"></i>
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
            <nav class="navbar navbar-expand navbar-light bg-white topbar static-top shadow">

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
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ ucfirst($userLogin->name) }}</span>
                                @else
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ ucfirst($userLogin->name) }}</span>

                                @endif
                                        <img class="img-profile rounded-circle " src="/img/undraw_profile.svg">
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
