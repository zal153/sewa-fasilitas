@extends('user.layouts.template')
@section('title', 'Upload Bukti Pembayaran')

@section('contentUser')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Upload Bukti Pembayaran</h5>
                    </div>
                    <div class="card-body">
                        <!-- Detail Peminjaman -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6 class="fw-bold">Detail Peminjaman:</h6>
                                <table class="table table-sm">
                                    <tr>
                                        <td>Kode Peminjaman</td>
                                        <td>: {{ $peminjaman->kode_peminjaman }}</td>
                                    </tr>
                                    <tr>
                                        <td>Fasilitas</td>
                                        <td>: {{ $peminjaman->fasilitas->nama_fasilitas ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Mulai</td>
                                        <td>:
                                            {{ $peminjaman->tanggal_mulai ? \Carbon\Carbon::parse($peminjaman->tanggal_mulai)->format('d/m/Y H:i') : '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Selesai</td>
                                        <td>:
                                            {{ $peminjaman->tanggal_selesai ? \Carbon\Carbon::parse($peminjaman->tanggal_selesai)->format('d/m/Y H:i') : '-' }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <div class="alert alert-info">
                                    <h6 class="fw-bold">Total Pembayaran:</h6>
                                    <h3 class="text-primary">Rp {{ number_format($peminjaman->biaya, 0, ',', '.') }}</h3>
                                </div>
                            </div>
                        </div>

                        <!-- Info Rekening -->
                        <div class="alert alert-warning mb-4">
                            <h6 class="fw-bold">Informasi Rekening:</h6>
                            <p class="mb-1"><strong>Bank BRI:</strong> 1234567890 a.n. Universitas XYZ</p>
                            <p class="mb-1"><strong>Bank BCA:</strong> 0987654321 a.n. Universitas XYZ</p>
                            <p class="mb-0"><small>Silakan transfer sesuai dengan nominal yang tertera dan upload bukti
                                    pembayaran di bawah ini.</small></p>
                        </div>

                        <!-- Status Pembayaran -->
                        @if ($pembayaran->status)
                            <div
                                class="alert alert-{{ $pembayaran->status == 'berhasil' ? 'success' : ($pembayaran->status == 'ditolak' ? 'danger' : 'info') }}">
                                <h6 class="fw-bold">Status Pembayaran:
                                    {{ ucfirst(str_replace('_', ' ', $pembayaran->status)) }}</h6>
                                @if ($pembayaran->catatan_admin)
                                    <p class="mb-0"><strong>Catatan Admin:</strong> {{ $pembayaran->catatan_admin }}</p>
                                @endif
                            </div>
                        @endif

                        <!-- QR Code (jika sudah approved) -->
                        @if ($pembayaran->status == 'berhasil' && $pembayaran->qr_code)
                            <div class="alert alert-success">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h6 class="fw-bold">Pembayaran Berhasil!</h6>
                                        <p class="mb-0">QR Code untuk verifikasi telah dibuat. Silakan download dan
                                            tunjukkan saat menggunakan fasilitas.</p>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <img src="{{ asset('storage/' . $pembayaran->qr_code) }}" alt="QR Code"
                                            class="img-fluid" style="max-width: 150px;">
                                        <br>
                                        <a href="{{ route('bayar.download-qr', $pembayaran->id) }}"
                                            class="btn btn-success btn-sm mt-2">
                                            <i class="bx bx-download me-1"></i> Download QR
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Form Upload Bukti (jika belum berhasil) -->
                        @if ($pembayaran->status != 'berhasil')
                            <form action="{{ route('bayar.upload-bukti', $pembayaran->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="row mb-3">
                                    <label for="metode" class="col-sm-3 col-form-label">Metode Pembayaran</label>
                                    <div class="col-sm-9">
                                        <select name="metode" id="metode"
                                            class="form-select @error('metode') is-invalid @enderror" required>
                                            <option value="">Pilih Metode Pembayaran</option>
                                            <option value="transfer_bank"
                                                {{ old('metode', $pembayaran->metode) == 'transfer_bank' ? 'selected' : '' }}>
                                                Transfer Bank</option>
                                            <option value="gopay"
                                                {{ old('metode', $pembayaran->metode) == 'gopay' ? 'selected' : '' }}>GoPay
                                            </option>
                                            <option value="qris"
                                                {{ old('metode', $pembayaran->metode) == 'qris' ? 'selected' : '' }}>QRIS
                                            </option>
                                            <option value="kartu_kredit"
                                                {{ old('metode', $pembayaran->metode) == 'kartu_kredit' ? 'selected' : '' }}>
                                                Kartu Kredit</option>
                                        </select>
                                        @error('metode')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="bukti_pembayaran" class="col-sm-3 col-form-label">Bukti Pembayaran</label>
                                    <div class="col-sm-9">
                                        <input type="file" name="bukti_pembayaran" id="bukti_pembayaran"
                                            class="form-control @error('bukti_pembayaran') is-invalid @enderror"
                                            accept="image/*" required>
                                        <small class="form-text text-muted">Format: JPG, PNG, JPEG. Maksimal 2MB.</small>
                                        @error('bukti_pembayaran')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                @if ($pembayaran->bukti_pembayaran)
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Bukti Saat Ini</label>
                                        <div class="col-sm-9">
                                            <img src="{{ asset('storage/' . $pembayaran->bukti_pembayaran) }}"
                                                alt="Bukti Pembayaran" class="img-thumbnail" style="max-width: 200px;">
                                        </div>
                                    </div>
                                @endif

                                <div class="row justify-content-end">
                                    <div class="col-sm-9">
                                        <button type="submit" class="btn btn-primary me-2">
                                            <i class="bx bx-upload me-1"></i> Upload Bukti
                                        </button>
                                        <a href="{{ route('non_mahasiswa.pembayaran') }}"
                                            class="btn btn-outline-secondary">
                                            <i class="bx bx-arrow-back me-1"></i> Kembali
                                        </a>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
