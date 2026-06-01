<x-app-layout>
    <x-slot name="title">
        Dashboard Admin
    </x-slot>

    {{-- Statistik --}}
    <section class="row">
        <x-card-sum-v2
            text="Total Campaign"
            value="{{ $totalCampaign }}"
            icon="hand-holding-heart"
            color="primary"
            link="{{ route('admin.campaign.index') }}"
        />

        <x-card-sum-v2
            text="Total Donasi"
            value="{{ $totalDonation }}"
            icon="donate"
            color="success"
            link="{{ route('admin.donation') }}"
        />

        <x-card-sum-v2
            text="Dana Terkumpul"
            value="Rp {{ number_format($totalDana, 0, ',', '.') }}"
            icon="money-bill"
            color="warning"
            link="{{ route('admin.donation') }}"
        />

        <x-card-sum-v2
            text="Pesan Masuk"
            value="{{ $totalContact }}"
            icon="envelope"
            color="danger"
            link="{{ route('admin.contact.index') }}"
        />

        <x-card-sum-v2
            text="Campaign Aktif"
            value="{{ $campaignAktif }}"
            icon="check-circle"
            color="info"
            link="{{ route('admin.campaign.index') }}"
        />

        <x-card-sum-v2
            text="Campaign Selesai"
            value="{{ $campaignSelesai }}"
            icon="times-circle"
            color="secondary"
            link="{{ route('admin.campaign.index') }}"
        />

        <x-card-sum-v2
            text="Total Artikel"
            value="{{ $totalArticle }}"
            icon="newspaper"
            color="dark"
            link="{{ route('admin.article.index') }}"
        />
    </section>

    {{-- Donasi Terbaru --}}
    <section class="row mt-2">
        <div class="col-md-12">
            <x-card>
                <x-slot name="title">
                    Donasi Terbaru
                </x-slot>

                <x-slot name="option">
                    <a href="{{ route('admin.donation') }}" class="btn btn-primary btn-sm">
                        Lihat Semua
                    </a>
                </x-slot>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Donatur</th>
                                <th>Campaign</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($donasiTerbaru as $donasi)
                                <tr>
                                    <td>{{ $donasi->name }}</td>

                                    <td>
                                        {{ $donasi->campaign->title ?? '-' }}
                                    </td>

                                    <td>
                                        Rp {{ number_format($donasi->amount, 0, ',', '.') }}
                                    </td>

                                    <td>
                                        <span class="badge badge-info">
                                            {{ $donasi->status ?? 'Belum Ada Status' }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ $donasi->created_at ? $donasi->created_at->format('d M Y') : '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">
                                        Belum ada data donasi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-card>
        </div>
    </section>

    {{-- Campaign Terbaru --}}
    <section class="row">
        <div class="col-md-12">
            <x-card>
                <x-slot name="title">
                    Campaign Terbaru
                </x-slot>

                <x-slot name="option">
                    <a href="{{ route('admin.campaign.index') }}" class="btn btn-primary btn-sm">
                        Lihat Semua
                    </a>
                </x-slot>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Judul Campaign</th>
                                <th>Target</th>
                                <th>Terkumpul</th>
                                <th>Deadline</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($campaignTerbaru as $campaign)
                                <tr>
                                    <td>
                                        <strong>{{ $campaign->title }}</strong>
                                    </td>

                                    <td>
                                        Rp {{ number_format($campaign->goals, 0, ',', '.') }}
                                    </td>

                                    <td>
                                        Rp {{ number_format($campaign->raised, 0, ',', '.') }}
                                    </td>

                                    <td>
                                        {{ $campaign->deadline }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">
                                        Belum ada campaign.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-card>
        </div>
    </section>
</x-app-layout>