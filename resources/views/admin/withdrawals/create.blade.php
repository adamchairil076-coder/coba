<x-app-layout>
    <x-slot name="title">Tambah Penarikan Dana</x-slot>

    @if(session()->has('success'))
        <x-alert type="success" message="{{ session()->get('success') }}" />
    @endif

    @if(session()->has('failed'))
        <x-alert type="danger" message="{{ session()->get('failed') }}" />
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Form Pengajuan Penarikan Dana</h3>
        </div>

        <form action="{{ route('admin.withdrawal.store') }}" method="POST">
            @csrf

            <div class="card-body">
                <div class="form-group">
                    <label>Campaign / Penggalangan</label>

                    <select name="campaign_id" class="form-control @error('campaign_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Campaign --</option>

                        @foreach($campaigns as $campaign)
                            <option value="{{ $campaign->id }}" {{ old('campaign_id') == $campaign->id ? 'selected' : '' }}>
                                {{ $campaign->title }} -
                                Saldo Tersedia: Rp {{ number_format($campaignBalances[$campaign->id] ?? 0, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>

                    @error('campaign_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Bank Tujuan</label>

                    <select name="bank_name" class="form-control @error('bank_name') is-invalid @enderror" required>
                        <option value="">-- Pilih Bank --</option>

                        @foreach($banks as $bank)
                            <option value="{{ $bank }}" {{ old('bank_name') == $bank ? 'selected' : '' }}>
                                {{ $bank }}
                            </option>
                        @endforeach
                    </select>

                    @error('bank_name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Nomor Rekening</label>

                    <input type="text"
                           name="account_number"
                           class="form-control @error('account_number') is-invalid @enderror"
                           placeholder="Contoh: 1234567890"
                           value="{{ old('account_number') }}"
                           maxlength="20"
                           required>

                    @error('account_number')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror

                    <small class="text-muted">
                        Nomor rekening harus angka, minimal 8 digit.
                    </small>
                </div>

                <div class="form-group">
                    <label>Nama Pemilik Rekening</label>

                    <input type="text"
                           name="account_holder_name"
                           class="form-control @error('account_holder_name') is-invalid @enderror"
                           placeholder="Contoh: Yayasan Rumah Yatim Ruhama"
                           value="{{ old('account_holder_name') }}"
                           required>

                    @error('account_holder_name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Nominal Penarikan</label>

                    <input type="number"
                           name="amount"
                           class="form-control @error('amount') is-invalid @enderror"
                           placeholder="Masukkan nominal penarikan"
                           value="{{ old('amount') }}"
                           min="10000"
                           required>

                    @error('amount')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Keterangan Penggunaan Dana</label>

                    <textarea name="description"
                              rows="5"
                              class="form-control @error('description') is-invalid @enderror"
                              placeholder="Contoh: Penarikan dana untuk kebutuhan operasional pesantren"
                              required>{{ old('description') }}</textarea>

                    @error('description')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Ajukan Penarikan
                </button>

                <a href="{{ route('admin.withdrawal.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</x-app-layout>