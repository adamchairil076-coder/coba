<x-app-layout>
	<x-slot name="head">
		<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
	</x-slot>

	<x-slot name="title">Daftar Donasi Per Campaign</x-slot>

	@if(session()->has('success'))
		<x-alert type="success" message="{{ session()->get('success') }}" />
	@endif

	<div class="row mb-3">
		<div class="col-md-6">
			<div class="card shadow-sm border-left-primary">
				<div class="card-body">
					<h6 class="text-muted mb-1">Total Dana Terkumpul</h6>
					<h4 class="font-weight-bold mb-0">
						Rp {{ number_format($grandTotal, 0, ',', '.') }}
					</h4>
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="card shadow-sm border-left-success">
				<div class="card-body">
					<h6 class="text-muted mb-1">Total Transaksi Berhasil</h6>
					<h4 class="font-weight-bold mb-0">
						{{ $totalTransaction }} Transaksi
					</h4>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12 mb-3">
			@forelse($campaigns as $campaign)
				<x-card>
					<x-slot name="title">
						{{ $campaign->title }}
					</x-slot>

					<x-slot name="option">
						<span class="badge badge-success p-2">
							Total Dana Terkumpul: Rp {{ number_format($campaign->donations->sum('amount'), 0, ',', '.') }}
						</span>
					</x-slot>

					<div class="mb-3">
						<strong>Jumlah Donatur:</strong>
						{{ $campaign->donations->count() }} orang
					</div>

					<div class="table-responsive">
						<table class="table table-hover border">
							<thead>
								<tr>
									<th>No</th>
									<th>Nama Donatur</th>
									<th>Nominal</th>
									<th>Pembayaran</th>
									<th>Status</th>
									<th>Tanggal</th>
								</tr>
							</thead>

							<tbody>
								@forelse($campaign->donations as $donation)
									<tr>
										<td>{{ $loop->iteration }}</td>
										<td>{{ $donation->name }}</td>
										<td>Rp {{ number_format($donation->amount, 0, ',', '.') }}</td>
										<td>
											<span class="text-primary">
												{{ $donation->payment_method ?? '-' }}
											</span>
										</td>
										<td>
											<span class="badge badge-success">
												{{ $donation->status }}
											</span>
										</td>
										<td>{{ $donation->created_at->format('d-M-Y') }}</td>
									</tr>
								@empty
									<tr>
										<td colspan="6" class="text-center">
											Belum ada donasi pada campaign ini.
										</td>
									</tr>
								@endforelse
							</tbody>

							<tfoot>
								<tr>
									<th colspan="2" class="text-right">Total Dana Terkumpul</th>
									<th colspan="4">
										Rp {{ number_format($campaign->donations->sum('amount'), 0, ',', '.') }}
									</th>
								</tr>
							</tfoot>
						</table>
					</div>
				</x-card>
			@empty
				<x-card>
					<div class="text-center py-4">
						Belum ada data donasi yang berhasil dibayar.
					</div>
				</x-card>
			@endforelse
		</div>
	</div>
</x-app-layout>