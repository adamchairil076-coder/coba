<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Donatur</title>

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/icofont.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/meanmenu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/theme-dark.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo.png') }}">

    <style>
        body {
            background: #f8f9fa;
        }

        .profile-page {
            padding: 110px 0 70px;
        }

        .profile-card {
            background: #fff;
            border-radius: 14px;
            padding: 25px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.06);
        }

        .stat-card {
            background: #fff;
            border-radius: 14px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 8px 25px rgba(0,0,0,0.06);
            height: 100%;
        }

        .stat-card i {
            font-size: 38px;
            color: #ff6015;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #ff6015;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .back-btn:hover {
            color: #d94b07;
        }

        .logout-btn {
            border: none;
            width: 100%;
            background: #dc3545;
            color: #fff;
            padding: 12px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
        }

        .logout-btn:hover {
            background: #c82333;
        }

        .table thead th {
            white-space: nowrap;
        }
    </style>
</head>

<body>

    <div class="navbar-area sticky-top">
        <div class="mobile-nav">
            <a href="{{ route('index') }}" class="logo">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" width="40">
            </a>
        </div>

        <div class="main-nav">
            <div class="container">
                @include('components.home.navbar', [
                    'categories' => \App\Models\Category::all()
                ])
            </div>
        </div>
    </div>

    <section class="profile-page">
        <div class="container">

            <a href="{{ route('index') }}" class="back-btn">
                <i class="icofont-arrow-left"></i>
                Kembali ke Website
            </a>

            <div class="section-title">
                <h2>Halo, {{ $user->name }}</h2>
                <p>Kelola informasi akun dan pantau riwayat donasi Anda.</p>
            </div>

            <div class="row mb-4">

                <div class="col-md-3 mb-3">
                    <div class="stat-card">
                        <i class="icofont-money-bag"></i>
                        <h6 class="mt-3">Total Donasi Berhasil</h6>
                        <h4 class="text-success">
                            Rp {{ number_format($totalDonation, 0, ',', '.') }}
                        </h4>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="stat-card">
                        <i class="icofont-list"></i>
                        <h6 class="mt-3">Total Transaksi</h6>
                        <h4>{{ $totalTransaction }}</h4>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="stat-card">
                        <i class="icofont-check-circled"></i>
                        <h6 class="mt-3">Donasi Berhasil</h6>
                        <h4>{{ $successTransaction }}</h4>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="stat-card">
                        <i class="icofont-heart-alt"></i>
                        <h6 class="mt-3">Campaign Didukung</h6>
                        <h4>{{ $campaignSupported }}</h4>
                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-lg-4 mb-4">
                    <div class="profile-card">

                        <div class="text-center">
                            <img src="{{ asset('dist/img/user.png') }}"
                                 alt="User"
                                 style="width: 95px; height: 95px; border-radius: 50%; object-fit: cover;">

                            <h4 class="mt-3 mb-1">{{ $user->name }}</h4>
                            <p class="text-muted mb-0">{{ $user->username }}</p>
                        </div>

                        <hr>

                        <p>
                            <strong>Nama:</strong><br>
                            {{ $user->name }}
                        </p>

                        <p>
                            <strong>Username:</strong><br>
                            {{ $user->username }}
                        </p>

                        <p>
                            <p>
    <strong>Status Akun:</strong><br>

    @if($successTransaction > 0)

        <span style="
            background: #28a745;
            color: white;
            padding: 6px 12px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
            display: inline-block;
        ">
            Donatur Aktif
        </span>

    @else

        <span style="
            background: #ffc107;
            color: #212529;
            padding: 6px 12px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
            display: inline-block;
        ">
            Belum Berdonasi
        </span>

    @endif

</p>
                        </p>

                        <hr>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="logout-btn">
                                <i class="icofont-logout"></i>
                                Logout
                            </button>
                        </form>

                    </div>
                </div>

                <div class="col-lg-8 mb-4">
                    <div class="profile-card">

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="mb-0">Riwayat Donasi</h4>
                            <small class="text-muted">Data donasi akun Anda</small>
                        </div>

                        <hr>

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Campaign</th>
                                        <th>Nominal</th>
                                        <th>Status</th>
                                        <th>Metode</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($donations as $donation)
                                        <tr>
                                            <td>
                                                {{ $loop->iteration + ($donations->currentPage() - 1) * $donations->perPage() }}
                                            </td>

                                            <td>
                                                {{ $donation->campaign->title ?? '-' }}
                                            </td>

                                            <td>
                                                Rp {{ number_format($donation->amount, 0, ',', '.') }}
                                            </td>

                                            <td>
                                                @if($donation->status == 'PAID')
                                                    <span class="badge badge-success">Berhasil</span>
                                                @elseif($donation->status == 'PENDING')
                                                    <span class="badge badge-warning">Pending</span>
                                                @elseif($donation->status)
                                                    <span class="badge badge-secondary">{{ $donation->status }}</span>
                                                @else
                                                    <span class="badge badge-secondary">Belum Dibayar</span>
                                                @endif
                                            </td>

                                            <td>
                                                {{ $donation->payment_method ?? '-' }}
                                            </td>

                                            <td>
                                                {{ $donation->created_at ? $donation->created_at->format('d M Y H:i') : '-' }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">
                                                Belum ada riwayat donasi.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{ $donations->links() }}

                    </div>
                </div>

            </div>

        </div>
    </section>

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.meanmenu.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>

</body>
</html>