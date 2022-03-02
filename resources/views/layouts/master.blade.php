<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Absensi - {{ $title }}</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="{{ asset('/') }}img/icon.ico" type="image/x-icon" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fonts and icons -->
    <script src="{{ asset('/') }}js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Lato:300,400,700,900"]
            },
            custom: {
                "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"],
                urls: ['{{ asset("/") }}css/fonts.min.css']
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('/') }}css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('/') }}css/atlantis.min.css">
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="{{ asset('/') }}css/demo.css">

    <style>
        .menu-icon {
            color: #575962 !important;
        }
    </style>
    @stack('style')
</head>

<body>
    <div class="wrapper">
        <div class="main-header">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="red">

                <a href="/dashboard" class="logo">
                    <img src="{{ asset('/') }}img/westinlogo.png" alt="navbar brand" class="navbar-brand" width="100">
                </a>
                <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                        <i class="icon-menu"></i>
                    </span>
                </button>
                <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
                <div class="nav-toggle">
                    <button class="btn btn-toggle toggle-sidebar">
                        <i class="icon-menu"></i>
                    </button>
                </div>
            </div>
            <!-- End Logo Header -->

            <!-- Navbar Header -->
            <nav class="navbar navbar-header navbar-expand-lg" data-background-color="red2">

                <div class="container-fluid">
                    <div class="collapse" id="search-nav">
                        <form class="navbar-left navbar-form nav-search mr-md-3">

                        </form>
                    </div>

                    <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                        <li class="nav-item dropdown hidden-caret">
                            <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                                <div class="avatar-sm">
                                    <img src="{{ asset('/storage/'. auth()->user()->foto) }}" alt="..." class="avatar-img rounded-circle">
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-user animated fadeIn">
                                <div class="dropdown-user-scroll scrollbar-outer">
                                    <li>
                                        <div class="user-box">
                                            <div class="avatar-lg"><img src="{{ asset('/storage/'. auth()->user()->foto) }}" alt="image profile" class="avatar-img rounded"></div>
                                            <div class="u-text">
                                                <h4>{{ auth()->user()->nama }}</h4>
                                                <a href="javascript:void()" class="btn btn-xs btn-secondary btn-sm">{{ auth()->user()->getRoleNames()[0] }}</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="{{ route('profile') }}">My Profile</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </div>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- End Navbar -->
        </div>
        <!-- Sidebar -->
        <div class="sidebar sidebar-style-2">

            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <div class="user">
                        <div class="avatar-sm float-left mr-2">
                            <img src="{{ asset('/storage/'. auth()->user()->foto) }}" alt="..." class="avatar-img rounded-circle">
                        </div>
                        <div class="info">
                            <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                                <span>
                                    {{ auth()->user()->nama }}
                                    <span class="user-level">{{ auth()->user()->getRoleNames()[0] }}</span>
                                    <span class="caret"></span>
                                </span>
                            </a>
                            <div class="clearfix"></div>

                            <div class="collapse in" id="collapseExample">
                                <ul class="nav">
                                    <li>
                                        <a href="{{ route('profile') }}">
                                            <span class="link-collapse">My Profile</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <ul class="nav nav-danger">
                        <li class="nav-item {{ request()->is('dashboard*') ? 'active' : '' }}">
                            <a href="/dashboard">
                                <i class="fas fa-home"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <li class="nav-item {{ request()->is('user*') || request()->is('kelas*') || request()->is('siswa*') || request()->is('jadwal*') || request()->is('holiday*') ? 'active submenu' : '' }}">
                            <a data-toggle="collapse" href="#master">
                                <i class="fas fa-th"></i>
                                <p>Data Master</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse {{ request()->is('user*') || request()->is('kelas*') || request()->is('siswa*') || request()->is('jadwal*') || request()->is('holiday*') ? 'show' : '' }}" id="master">
                                <ul class="nav nav-collapse">
                                    <li class="{{ request()->is('user*') ? 'active' : '' }}">
                                        <a href="{{ route('user.index') }}">
                                            <span class="sub-item"><i style="color: {{ request()->is('user*') ? '' : '#575962' }} !important;" class="menu-icon fas fa-users"></i> Master User</span>
                                        </a>
                                    </li>
                                    <li class="{{ request()->is('kelas*') ? 'active' : '' }}">
                                        <a href="{{ route('kelas.index') }}">
                                            <span class="sub-item"><i style="color: {{ request()->is('kelas*') ? '' : '#575962' }} !important;" class="menu-icon fas fa-door-open"></i> Master Kelas</span>
                                        </a>
                                    </li>
                                    <li class="{{ request()->is('siswa*') ? 'active' : '' }}">
                                        <a href="{{ route('siswa.index') }}">
                                            <span class="sub-item"><i style="color: {{ request()->is('siswa*') ? '' : '#575962' }} !important;" class="menu-icon fas fa-user-check"></i> Master Siswa</span>
                                        </a>
                                    </li>
                                    <li class="{{ request()->is('jadwal*') ? 'active' : '' }}">
                                        <a href="{{ route('jadwal.index') }}">
                                            <span class="sub-item"><i style="color: {{ request()->is('jadwal*') ? '' : '#575962' }} !important;" class="menu-icon fas fa-calendar-check"></i> Master Jadwal</span>
                                        </a>
                                    </li>
                                    <li class="{{ request()->is('holiday*') ? 'active' : '' }}">
                                        <a href="{{ route('holiday.index') }}">
                                            <span class="sub-item"><i style="color: {{ request()->is('holiday*') ? '' : '#575962' }} !important;" class="menu-icon fas fa-calendar-times"></i> Master Holiday</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item {{ request()->is('device*') || request()->is('rfid*') || request()->is('history*') ? 'active submenu' : '' }}">
                            <a data-toggle="collapse" href="#alat">
                                <i class="fas fa-cogs"></i>
                                <p>Data Alat</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse {{ request()->is('device*') || request()->is('rfid*') || request()->is('history*') ? 'show' : '' }}" id="alat">
                                <ul class="nav nav-collapse">
                                    <li class="{{ request()->is('device*') ? 'active' : '' }}">
                                        <a href="{{ route('device.index') }}">
                                            <span class="sub-item"><i style="color: {{ request()->is('device*') ? '' : '#575962' }} !important;" class="menu-icon fas fa-suitcase"></i> Device</span>
                                        </a>
                                    </li>
                                    <li class="{{ request()->is('rfid*') ? 'active' : '' }}">
                                        <a href="{{ route('rfid.index') }}">
                                            <span class="sub-item"><i style="color: {{ request()->is('rfid*') ? '' : '#575962' }} !important;" class="menu-icon fas fa-id-card"></i> Rfid</span>
                                        </a>
                                    </li>
                                    <li class="{{ request()->is('history*') ? 'active' : '' }}">
                                        <a href="{{ route('history.index') }}">
                                            <span class="sub-item"><i style="color: {{ request()->is('history*') ? '' : '#575962' }} !important;" class="menu-icon fas fa-history"></i> History</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item {{ request()->is('absensi*') || request()->is('absensi-staff*') ? 'submenu active' : '' }}">
                            <a data-toggle="collapse" href="#absensi">
                                <i class="fas fa-calendar-alt"></i>
                                <p>Absensi</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse {{ request()->is('absensi*') || request()->is('absensi-staff*') ? 'show' : '' }}" id="absensi">
                                <ul class="nav nav-collapse">
                                    <li class="{{ request()->is('absensi*') ? 'active' : '' }}">
                                        <a href="{{ route('absensi.index') }}">
                                            <span class="sub-item"><i style="color: {{ request()->is('absensi*') ? '' : '#575962' }} !important;" class="menu-icon fas fa-id-badge"></i> Absensi Siswa</span>
                                        </a>
                                    </li>
                                    <li class="{{ request()->is('absensi-staff*') ? 'active' : '' }}">
                                        <a href="{{ route('absensi-staff.index') }}">
                                            <span class="sub-item"><i style="color: {{ request()->is('absensi-staff*') ? '' : '#575962' }} !important;" class="menu-icon fas fa-clipboard-list"></i> Absensi Staff</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item {{ request()->is('role*') || request()->is('permission*') ? 'active submenu'  : '' }}">
                            <a data-toggle="collapse" href="#access">
                                <i class="fas fa-universal-access"></i>
                                <p>Access User</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse {{ request()->is('role*') || request()->is('permission*')  ? 'show'  : '' }}" id="access">
                                <ul class="nav nav-collapse">
                                    <li class="{{ request()->is('permission*') ? 'active' : '' }}">
                                        <a href="{{ route('permission.index') }}">
                                            <span class="sub-item"><i style="color: {{ request()->is('permission*') ? '' : '#575962' }} !important;" class="fas fa-exclamation-circle menu-icon"></i> Data Permission</span>
                                        </a>
                                    </li>
                                    <li class="{{ request()->is('role*') ? 'active' : '' }}">
                                        <a href="{{ route('role.index') }}">
                                            <span class="sub-item"><i style="color: {{ request()->is('role*') ? '' : '#575962' }} !important;" class=" menu-icon fas fa-user-cog"></i> Data Role</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item {{ request()->is('setting*') ? 'active' : '' }}">
                            <a href="/setting">
                                <i class="fas fa-cog"></i>
                                <p>Setting</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="main-panel">
            <div class="content">
                <div class="page-inner">
                    <div class="page-header">
                        <h4 class="page-title">{{ $title }}</h4>
                    </div>

                    @yield('content')
                </div>
            </div>
            <footer class="footer">
                <div class="container-fluid">
                    <div class="copyright ml-auto">
                        2022, made with <i class="fa fa-heart heart text-danger"></i> by <a href="https://www.tazaka.co.id">Tazaka</a>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!--   Core JS Files   -->
    <script src="{{ asset('/') }}js/core/jquery.3.2.1.min.js"></script>
    <script src="{{ asset('/') }}js/core/popper.min.js"></script>
    <script src="{{ asset('/') }}js/core/bootstrap.min.js"></script>

    <!-- jQuery UI -->
    <script src="{{ asset('/') }}js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <script src="{{ asset('/') }}js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('/') }}js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>


    <!-- Chart JS -->
    <script src="{{ asset('/') }}js/plugin/chart.js/chart.min.js"></script>

    <!-- jQuery Sparkline -->
    <script src="{{ asset('/') }}js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

    <!-- Chart Circle -->
    <script src="{{ asset('/') }}js/plugin/chart-circle/circles.min.js"></script>

    <!-- Datatables -->
    <script src="{{ asset('/') }}js/plugin/datatables/datatables.min.js"></script>

    <!-- jQuery Vector Maps -->
    <script src="{{ asset('/') }}js/plugin/jqvmap/jquery.vmap.min.js"></script>
    <script src="{{ asset('/') }}js/plugin/jqvmap/maps/jquery.vmap.world.js"></script>

    <!-- Sweet Alert -->
    <script src="{{ asset('/') }}js/plugin/sweetalert/sweetalert.min.js"></script>

    <!-- Atlantis JS -->
    <script src="{{ asset('/') }}js/atlantis.min.js"></script>

    <!-- Atlantis DEMO methods, don't include it in your project! -->
    <script src="{{ asset('/') }}js/setting-demo.js"></script>
    <script src="{{ asset('/') }}js/demo.js"></script>

    @if(session('success'))
    <script>
        swal("Selamat!", "{{ session('success') }}", {
            icon: "success",
            buttons: {
                confirm: {
                    className: 'btn btn-success'
                }
            },
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        swal("Error!", "{{ session('error') }}", {
            icon: "error",
            buttons: {
                confirm: {
                    className: 'btn btn-danger'
                }
            },
        });
    </script>
    @endif

    <script>
        $('.btn-delete').click(function(e) {
            e.preventDefault();
            swal({
                title: 'Hapus data?',
                text: "Data yang dihapus bersifat permanen!",
                type: 'warning',
                buttons: {
                    confirm: {
                        text: 'Ya, Hapus!',
                        className: 'btn btn-success'
                    },
                    cancel: {
                        text: 'Batal',
                        visible: true,
                        className: 'btn btn-danger'
                    }
                }
            }).then((response) => {
                if (response) {
                    $(".form-delete").submit()
                } else {
                    swal.close();
                }
            });
        });
    </script>

    @stack('script')

</body>

</html>