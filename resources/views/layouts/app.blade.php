<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Sistem Pemilihan Hotel</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="/assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="/assets/modules/fontawesome/css/all.min.css">
  <link rel="stylesheet" href="/assets/css/style.css">
  <link rel="stylesheet" href="/assets/css/components.css">

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <!-- Select2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
  <link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.4.1/css/dataTables.dateTime.min.css">
</head>
<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
          </ul>
        </form>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
              <img alt="image" src="/assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
              <div class="d-sm-none d-lg-inline-block">Halo, {{ auth()->user()->name }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <a href="/ubah-password" class="dropdown-item has-icon">
                <i class="fa fa-lock"></i> Ubah Password
              </a>
              @if (auth()->user()->role === 'admin' || auth()->user()->role === 'petugas lapangan')
              <a href="/profil-pengguna" class="dropdown-item has-icon">
                <i class="fa fa-user-circle"></i> Profil
              </a>
              @endif
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="{{ route('logout') }}"
                 onclick="event.preventDefault(); Swal.fire({
                    title: 'Konfirmasi Keluar',
                    text: 'Apakah Anda yakin ingin keluar?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Keluar!'
                  }).then((result) => {
                    if (result.isConfirmed) {
                      document.getElementById('logout-form').submit();
                    }
                  });">
                <i class="fas fa-sign-out-alt"></i> Keluar
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </div>
          </li>
        </ul>
      </nav>

      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="/">SISTEM PEMILIHAN<br>HOTEL<br>DI PANGANDARAN</a>
          </div>

          <ul class="sidebar-menu">

            @if (auth()->user()->role === 'admin')
                <li class="sidebar-item">
                    <a class="nav-link {{ Request::is('/') || Request::is('dashboard') ? 'active' : '' }}" href="/dashboard">
                        <i class="fas fa-fire"></i> <span class="align-middle">Dashboard</span>
                    </a>
                </li>

                <li class="menu-header">PENGELOLAAN</li>
                <li>
                    <a class="nav-link {{ Request::is('hotels*') ? 'active' : '' }}" href="/hotels">
                        <i class="fas fa-hotel"></i><span>Kelola Data Hotel</span>
                    </a>
                </li>
                <li>
                    <a class="nav-link {{ Request::is('kriteria*') ? 'active' : '' }}" href="/kriteria">
                        <i class="fas fa-clipboard-list"></i><span>Kelola Kriteria</span>
                    </a>
                </li>
                <li>
                    <a class="nav-link {{ Request::is('bobot-kriteria*') ? 'active' : '' }}" href="/bobot-kriteria">
                        <i class="fas fa-weight-hanging"></i><span>Kelola Bobot Kriteria</span>
                    </a>
                </li>

                <li class="menu-header">DATA & PERHITUNGAN</li>
                <li>
                    <a class="nav-link {{ Request::is('penilaian*') ? 'active' : '' }}" href="/penilaian">
                        <i class="fas fa-pen"></i><span>Data Penilaian</span>
                    </a>
                </li>
                <li>
                    <a class="nav-link {{ Request::is('perhitungan*') ? 'active' : '' }}" href="/perhitungan">
                        <i class="fas fa-calculator"></i><span>Data Perhitungan</span>
                    </a>
                </li>
                <li>
                    <a class="nav-link {{ Request::is('hasil*') ? 'active' : '' }}" href="/hasil">
                        <i class="fas fa-trophy"></i><span>Hasil Akhir</span>
                    </a>
                </li>
                <li>
                    <a class="nav-link {{ Request::is('data-pengguna*') ? 'active' : '' }}" href="/data-pengguna">
                        <i class="fas fa-user"></i><span>Data User</span>
                    </a>
                </li>
            @endif

            @if (auth()->user()->role === 'user')
                <li class="sidebar-item">
                    <a class="nav-link {{ Request::is('/') || Request::is('dashboard') ? 'active' : '' }}" href="/dashboard">
                        <i class="fas fa-fire"></i> <span class="align-middle">Dashboard</span>
                    </a>
                </li>

                <li class="menu-header">PENGGUNA</li>
                <li>
                    <a class="nav-link {{ Request::is('profile') ? 'active' : '' }}" href="/profile">
                        <i class="fas fa-user"></i><span>Profil</span>
                    </a>
                </li>
                <li>
                    <a class="nav-link {{ Request::is('hasil*') ? 'active' : '' }}" href="/hasil">
                        <i class="fas fa-trophy"></i><span>Hasil Akhir</span>
                    </a>
                </li>
            @endif

        </ul>

        </aside>
      </div>

      <div class="main-content">
        <section class="section">
          @yield('content')
        </section>
      </div>

      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; {{ date('Y') }} Sistem Penentuan Pemilihan Hotel di Pangandaran
        </div>
        <div class="footer-right"></div>
      </footer>
    </div>
  </div>

  <!-- JS Scripts -->
  <script src="/assets/modules/jquery.min.js"></script>
  <script src="/assets/modules/popper.js"></script>
  <script src="/assets/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="/assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="/assets/modules/moment.min.js"></script>
  <script src="/assets/js/stisla.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>

  @include('sweetalert::alert')
  <script src="/assets/js/scripts.js"></script>
  <script src="/assets/js/custom.js"></script>
  @stack('scripts')
</body>
</html>

