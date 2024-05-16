<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/vendors/simple-datatables/style.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendors/chartjs/Chart.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</head>

<body>
    <div id="app">
        <div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header text-center">
                    Absensi
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Main Menu</li>


                        <li class="sidebar-item {{ Request::route()->getName() == 'home' ? 'active' : '' }}">
                            <a href="{{ route('home') }}" class="sidebar-link">
                                <i data-feather="home" width="20"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        @if (Auth::user()->role == 'guru')
                            <li class="sidebar-item {{ Request::route()->getName() == 'absensi' ? 'active' : '' }}">
                                <a href="{{ route('absensi') }}" class="sidebar-link">
                                    <i data-feather="file-text" width="20"></i>
                                    <span>Absensi</span>
                                </a>
                            </li>
                        @elseif(Auth::user()->role == 'admin')
                            <li class="sidebar-item {{ Request::route()->getName() == 'laporan' ? 'active' : '' }}">
                                <a href="{{ route('laporan') }}" class="sidebar-link">
                                    <i data-feather="book" width="20"></i>
                                    <span>Laporan</span>
                                </a>
                            </li>
                            <li class="sidebar-item {{ Request::route()->getName() == 'kelas' ? 'active' : '' }}">
                                <a href="{{ route('kelas') }}" class="sidebar-link">
                                    <i data-feather="home" width="20"></i>
                                    <span>Kelas</span>
                                </a>
                            </li>
                            <li
                                class="sidebar-item has-sub {{ Request::route()->getName() == 'administrasi' || Request::route()->getName() == 'guru' || Request::route()->getName() == 'siswa' ? 'active' : '' }}">
                                <a href="#" class="sidebar-link">
                                    <i data-feather="user" width="20"></i>
                                    <span>Users</span>
                                </a>

                                <ul
                                    class="submenu {{ Request::route()->getName() == 'administrasi' || Request::route()->getName() == 'guru' || Request::route()->getName() == 'siswa' ? 'active' : '' }}">
                                    <li>
                                        <a class="{{ Request::route()->getName() == 'administrasi' ? 'fw-bold' : '' }}"
                                            href="{{ route('administrasi') }}">Administrasi</a>
                                    </li>

                                    <li>
                                        <a class="{{ Request::route()->getName() == 'guru' ? 'fw-bold' : '' }}"
                                            href="{{ route('guru') }}">Guru</a>
                                    </li>

                                    <li>
                                        <a class="{{ Request::route()->getName() == 'siswa' ? 'fw-bold' : '' }}"
                                            href="{{ route('siswa') }}">Siswa</a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>

                </div>
                <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
            </div>
        </div>
        <div id="main">
            <nav class="navbar navbar-header navbar-expand navbar-light bg-primary">
                <a class="sidebar-toggler" href="#"><span class="navbar-toggler-icon"></span></a>
                <button class="btn navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav d-flex align-items-center navbar-light ms-auto">
                        <li class="dropdown">
                            <a href="#" data-bs-toggle="dropdown"
                                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                                <div class="avatar me-1">
                                    <img src="{{ asset('foto/' . Auth::user()->foto) }}" alt=""
                                        srcset="" />
                                </div>
                                <div class="d-none d-md-block d-lg-inline-block text-white">Hi,
                                    {{ Auth::user()->name }}
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="{{ route('user.profile') }}"><i
                                        data-feather="user"></i>Profile</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                              document.getElementById('logout-form').submit();"><i
                                        data-feather="log-out"></i> Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="main-content container-fluid">
                @yield('content')
            </div>
            <footer>
                {{-- <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2022 &copy;</p>
                    </div>
                </div> --}}
            </footer>
        </div>
    </div>
    <script src="{{ asset('assets/js/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <script src="{{ asset('assets/vendors/chartjs/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>

    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/vendors/simple-datatables/simple-datatables.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @yield('script')
    <script>
        $(document).ready(function() {
            let table1 = document.querySelector('.dttb');
            let dataTable = new simpleDatatables.DataTable(table1);
        });

        function confirmAlert(link, title) {
            Swal.fire({
                title: title,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = link;
                }
            });
        }
    </script>
    @if (session()->has('message'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Sukses!',
                text: '{{ session('message') }}',
                showConfirmButton: false,
                timer: 1500
            });
        </script>
    @endif

    @if (session()->has('message_gagal'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagals!',
                text: '{{ session('message_gagal') }}',
                showConfirmButton: false,
                timer: 1500
            });
        </script>
    @endif
</body>

</html>
