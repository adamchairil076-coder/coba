<x-app-layout>
    <x-slot name="title">Penarikan Dana</x-slot>

    @if(session()->has('success'))
        <x-alert type="success" message="{{ session()->get('success') }}" />
    @endif

    @if(session()->has('failed'))
        <x-alert type="danger" message="{{ session()->get('failed') }}" />
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Riwayat Penarikan Dana</h3>

            <div class="card-tools">
                <a href="{{ route('admin.withdrawal.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i>
                    Tambah Penarikan
                </a>
            </div>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Campaign</th>
                        <th>Admin</th>
                        <th>Bank</th>
                        <th>No Rekening</th>
                        <th>Atas Nama</th>
                        <th>Nominal</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($withdrawals as $withdrawal)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $withdrawal->campaign->title ?? '-' }}</td>
                            <td>{{ $withdrawal->user->name ?? '-' }}</td>
                            <td>{{ $withdrawal->bank_name ?? '-' }}</td>
                            <td>{{ $withdrawal->account_number ?? '-' }}</td>
                            <td>{{ $withdrawal->account_holder_name ?? '-' }}</td>
                            <td>Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}</td>

                            <td>
                                @if($withdrawal->status == 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @elseif($withdrawal->status == 'success')
                                    <span class="badge badge-success">Success</span>
                                @else
                                    <span class="badge badge-danger">Failed</span>
                                @endif
                            </td>

                            <td>{{ $withdrawal->description }}</td>
                            <td>{{ $withdrawal->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center">
                                Belum ada data penarikan dana.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>