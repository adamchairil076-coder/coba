<x-app-layout>
    <x-slot name="title">
        Laporan Donasi
    </x-slot>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Filter Laporan Donasi</h3>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.report.index') }}" method="GET">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label>Program Donasi</label>
                                <select name="campaign_id" class="form-control">
                                    <option value="">Semua Program</option>

                                    @foreach($campaigns as $campaign)
                                        <option value="{{ $campaign->id }}"
                                            {{ request('campaign_id') == $campaign->id ? 'selected' : '' }}>
                                            {{ $campaign->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2 mb-3">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="">Semua Status</option>

                                    @foreach($statuses as $status)
                                        <option value="{{ $status }}"
                                            {{ request('status') == $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2 mb-3">
                                <label>Tanggal Awal</label>
                                <input type="date"
                                       name="start_date"
                                       class="form-control"
                                       value="{{ request('start_date') }}">
                            </div>

                            <div class="col-md-2 mb-3">
                                <label>Tanggal Akhir</label>
                                <input type="date"
                                       name="end_date"
                                       class="form-control"
                                       value="{{ request('end_date') }}">
                            </div>

                            <div class="col-md-2 mb-3">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-search"></i>
                                    Cek
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $totalTransaction }}</h3>
                    <p>Total Transaksi</p>
                </div>

                <div class="icon">
                    <i class="fas fa-receipt"></i>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3 style="font-size: 28px;">
                        Rp {{ number_format($totalDonation, 0, ',', '.') }}
                    </h3>
                    <p>Total Dana</p>
                </div>

                <div class="icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Hasil Laporan Donasi</h3>

                    <div class="card-tools">
                        <a href="{{ route('admin.report.download', request()->query()) }}"
                           target="_blank"
                           class="btn btn-danger btn-sm">
                            <i class="fas fa-file-pdf"></i>
                            Unduh PDF
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if($selectedCampaign)
                        <div class="alert alert-info">
                            Menampilkan laporan program:
                            <strong>{{ $selectedCampaign->title }}</strong>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Nama Donatur</th>
                                    <th>Program Donasi</th>
                                    <th>Metode</th>
                                    <th>Status</th>
                                    <th>Jumlah</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($donations as $donation)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration + ($donations->currentPage() - 1) * $donations->perPage() }}
                                        </td>

                                        <td>{{ $donation->name }}</td>

                                        <td>{{ $donation->campaign->title ?? '-' }}</td>

                                        <td>{{ $donation->payment_method ?? '-' }}</td>

                                        <td>
                                            @if($donation->status == 'success' || $donation->status == 'paid')
                                                <span class="badge badge-success">
                                                    {{ ucfirst($donation->status) }}
                                                </span>
                                            @elseif($donation->status == 'pending')
                                                <span class="badge badge-warning">
                                                    {{ ucfirst($donation->status) }}
                                                </span>
                                            @elseif($donation->status)
                                                <span class="badge badge-danger">
                                                    {{ ucfirst($donation->status) }}
                                                </span>
                                            @else
                                                <span class="badge badge-secondary">
                                                    -
                                                </span>
                                            @endif
                                        </td>

                                        <td>
                                            Rp {{ number_format($donation->amount, 0, ',', '.') }}
                                        </td>

                                        <td>
                                            {{ $donation->created_at ? $donation->created_at->format('d M Y H:i') : '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            Belum ada data laporan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $donations->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>