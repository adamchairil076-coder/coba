<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>{{ $title }}</title>

  {{-- Google Font --}}
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700">

  {{-- Font Awesome --}}
  <link rel="stylesheet"
        href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">

  {{-- AdminLTE --}}
  <link rel="stylesheet"
        href="{{ asset('dist/css/adminlte.min.css') }}">

  {{-- Overlay Scrollbar --}}
  <link rel="stylesheet"
        href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

  {{ $head ?? '' }}

  <style>
      body {
          overflow-x: hidden;
      }

      .main-sidebar {
          box-shadow: none !important;
      }

      .brand-link {
          text-align: center;
          font-size: 22px;
          font-weight: 600;
      }

      .nav-sidebar .nav-link {
          border-radius: 8px;
          margin-bottom: 4px;
      }

      .content-wrapper {
          background: #f4f6f9;
      }

      .content-header h1 {
          font-weight: 700;
      }

      .card {
          border-radius: 14px;
      }

      .info-box {
          border-radius: 14px;
      }

      .main-footer {
          font-size: 14px;
          text-align: center;
      }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">

<div class="wrapper">

    {{-- Topbar --}}
    <x-topbar/>

    {{-- Sidebar --}}
    <aside class="main-sidebar sidebar-dark-primary elevation-4">

        <a href="{{ route('admin.dashboard') }}" class="brand-link">
            <span class="brand-text">
                AdminPanel
            </span>
        </a>

        <div class="sidebar">

            {{-- User Panel --}}
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">

                <div class="image">
                    <img src="{{ asset(auth()->user()->avatar ? 'storage/'.auth()->user()->avatar : 'dist/img/user.png') }}"
                         class="img-circle elevation-2"
                         alt="User Image">
                </div>

                <div class="info">
                    <a href="{{ route('admin.dashboard') }}"
                       class="d-block">
                        {{ auth()->user()->name }}
                    </a>
                </div>

            </div>

            {{-- Sidebar Menu --}}
            <x-sidebar/>

        </div>
    </aside>

    {{-- Content Wrapper --}}
    <div class="content-wrapper">

        {{-- Header --}}
        <div class="content-header">
            <div class="container-fluid">

                <div class="row mb-2">

                    <div class="col-sm-6">
                        <h1 class="m-0">
                            {{ $title }}
                        </h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">

                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">
                                    Home
                                </a>
                            </li>

                            <li class="breadcrumb-item active">
                                {{ $title }}
                            </li>

                        </ol>
                    </div>

                </div>

            </div>
        </div>

        {{-- Main Content --}}
        <section class="content">
            <div class="container-fluid">

                {{ $slot }}

            </div>
        </section>

    </div>

    {{-- Footer --}}
    <footer class="main-footer">
        <strong>
            Copyright &copy; {{ date('Y') }}
            Pesantren dan Rumah Yatim Ruhama.
        </strong>

        All rights reserved.
    </footer>

</div>

{{-- jQuery --}}
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

{{-- Bootstrap --}}
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

{{-- Overlay Scrollbar --}}
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

{{-- AdminLTE --}}
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>

<script>
    $('#logout').click(function(e){
        e.preventDefault();

        if(confirm('Yakin ingin logout?')) {
            $.post('{{ route('logout') }}', {
                _token: '{{ csrf_token() }}'
            }).done(function () {
                window.location.href = "/";
            });
        }
    });
</script>

{{ $script ?? '' }}

</body>
</html>