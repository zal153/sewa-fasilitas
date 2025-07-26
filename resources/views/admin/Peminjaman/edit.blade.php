@extends('admin.layouts.admin')

@section('title', 'Edit Data Peminjaman')

@push('styles')
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
    <style>
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .card {
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            border: none;
        }

        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px 10px 0 0 !important;
        }

        .info-box {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .btn-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 10px 30px;
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .btn-back {
            background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
            border: none;
            color: #333;
            padding: 10px 30px;
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            color: #333;
        }

        .status-info {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .status-pending {
            background-color: #fff3cd;
            border-left: 5px solid #ffc107;
        }

        .status-approved {
            background-color: #d4edda;
            border-left: 5px solid #28a745;
        }

        .status-rejected {
            background-color: #f8d7da;
            border-left: 5px solid #dc3545;
        }

        .status-completed {
            background-color: #d1ecf1;
            border-left: 5px solid #17a2b8;
        }
    </style>
@endpush

@section('contentAdmin')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="fas fa-edit mr-2"></i>Edit Data Peminjaman</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('peminjaman') }}">Data Peminjaman</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- Info Box -->
                    <div class="col-md-4">
                        <div class="info-box">
                            <h5><i class="fas fa-info-circle mr-2"></i>Informasi Peminjaman</h5>
                            <hr style="border-color: rgba(255,255,255,0.3);">
                            <p><strong>Kode:</strong> {{ $peminjaman->kode_peminjaman }}</p>
                            <p><strong>Dibuat:</strong> {{ $peminjaman->created_at->format('d M Y H:i') }}</p>
                            <p><strong>Terakhir Update:</strong> {{ $peminjaman->updated_at->format('d M Y H:i') }}</p>
                        </div>

                        <!-- Status Info -->
                        @php
                            $status = $peminjaman->status ?? 'diajukan';
                            $statusClass = match ($status) {
                                'diajukan' => 'status-pending',
                                'disetujui' => 'status-approved',
                                'ditolak' => 'status-rejected',
                                'selesai' => 'status-completed',
                                default => 'status-pending',
                            };
                            $statusIcon = match ($status) {
                                'diajukan' => 'fas fa-clock text-warning',
                                'disetujui' => 'fas fa-check-circle text-success',
                                'ditolak' => 'fas fa-times-circle text-danger',
                                'selesai' => 'fas fa-flag-checkered text-info',
                                default => 'fas fa-clock text-warning',
                            };
                        @endphp

                        <div class="status-info {{ $statusClass }}">
                            <h6><i class="{{ $statusIcon }} mr-2"></i>Status Saat Ini</h6>
                            <h4 class="mb-0">{{ ucfirst($status) }}</h4>
                            @if ($peminjaman->approvedBy)
                                <small>Oleh: {{ $peminjaman->approvedBy->name }}</small>
                            @endif
                        </div>
                    </div>

                    <!-- Form Edit -->
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-edit mr-2"></i>
                                    Form Edit Peminjaman
                                </h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool text-white" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('peminjaman.update', $peminjaman->id) }}" id="editForm">
                                @csrf
                                @method('PUT')

                                <div class="card-body">
                                    <div class="row">
                                        <!-- Nama Peminjam -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><i class="fas fa-user mr-2 text-primary"></i>Nama Peminjam</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control"
                                                        value="{{ $peminjaman->user->name }}" disabled>
                                                </div>
                                                <small class="text-muted">Role:
                                                    {{ $peminjaman->user->role ?? 'mahasiswa' }}</small>
                                            </div>
                                        </div>

                                        <!-- Fasilitas -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><i class="fas fa-building mr-2 text-success"></i>Fasilitas</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="fas fa-building"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control"
                                                        value="{{ $peminjaman->fasilitas->nama_fasilitas }}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <!-- Tanggal Mulai -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><i class="fas fa-calendar-alt mr-2 text-info"></i>Tanggal
                                                    Mulai</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="fas fa-calendar-alt"></i></span>
                                                    </div>
                                                    <input type="datetime-local" class="form-control"
                                                        value="{{ $peminjaman->tanggal_mulai->format('Y-m-d\TH:i') }}"
                                                        disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Tanggal Selesai -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><i class="fas fa-calendar-check mr-2 text-warning"></i>Tanggal
                                                    Selesai</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="fas fa-calendar-check"></i></span>
                                                    </div>
                                                    <input type="datetime-local" class="form-control"
                                                        value="{{ $peminjaman->tanggal_selesai->format('Y-m-d\TH:i') }}"
                                                        disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Keperluan -->
                                    <div class="form-group">
                                        <label><i class="fas fa-clipboard-list mr-2 text-purple"></i>Keperluan</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-clipboard-list"></i></span>
                                            </div>
                                            <textarea class="form-control" rows="3" disabled>{{ $peminjaman->keperluan }}</textarea>
                                        </div>
                                    </div>

                                    <!-- Catatan -->
                                    <div class="form-group">
                                        <label for="catatan"><i class="fas fa-sticky-note mr-2 text-danger"></i>Catatan
                                            Admin <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-sticky-note"></i></span>
                                            </div>
                                            <textarea id="catatan" name="catatan" class="form-control @error('catatan') is-invalid @enderror" rows="4"
                                                placeholder="Berikan catatan untuk peminjaman ini..." maxlength="500">{{ old('catatan', $peminjaman->catatan) }}</textarea>
                                        </div>
                                        <div class="d-flex justify-content-between mt-1">
                                            <small class="text-muted">
                                                <i class="fas fa-info-circle mr-1"></i>
                                                Catatan wajib diisi sebelum menyetujui peminjaman
                                            </small>
                                            <small class="text-muted">
                                                <span
                                                    id="charCount">{{ strlen(old('catatan', $peminjaman->catatan ?? '')) }}</span>/500
                                                karakter
                                            </small>
                                        </div>
                                        @error('catatan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Quick Templates -->
                                    <div class="form-group">
                                        <label><i class="fas fa-magic mr-2 text-info"></i>Template Catatan Cepat</label>
                                        <div class="btn-group-toggle" data-toggle="buttons">
                                            <button type="button" class="btn btn-outline-success btn-sm template-btn"
                                                data-template="Peminjaman disetujui. Harap menjaga fasilitas dengan baik dan mengembalikan tepat waktu.">
                                                <i class="fas fa-check mr-1"></i>Setujui
                                            </button>
                                            <button type="button" class="btn btn-outline-warning btn-sm template-btn"
                                                data-template="Peminjaman perlu dilengkapi dokumen pendukung. Silakan hubungi admin untuk informasi lebih lanjut.">
                                                <i class="fas fa-exclamation-triangle mr-1"></i>Perlu Kelengkapan
                                            </button>
                                            <button type="button" class="btn btn-outline-danger btn-sm template-btn"
                                                data-template="Peminjaman ditolak karena fasilitas sudah dibooking pada waktu tersebut. Silakan pilih waktu lain.">
                                                <i class="fas fa-times mr-1"></i>Tolak
                                            </button>
                                            <button type="button" class="btn btn-outline-info btn-sm template-btn"
                                                data-template="Peminjaman dalam review. Akan ada konfirmasi lebih lanjut dalam 1x24 jam.">
                                                <i class="fas fa-clock mr-1"></i>Review
                                            </button>
                                        </div>
                                    </div>

                                    @if ($peminjaman->user->role === 'non-mahasiswa')
                                        <!-- Info Biaya untuk Non-Mahasiswa -->
                                        <div class="alert alert-info">
                                            <h6><i class="fas fa-money-bill-wave mr-2"></i>Informasi Biaya</h6>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p class="mb-1"><strong>Biaya:</strong> Rp
                                                        {{ number_format($peminjaman->biaya ?? 0, 0, ',', '.') }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="mb-1">
                                                        <strong>Status Pembayaran:</strong>
                                                        <span
                                                            class="badge {{ $peminjaman->is_bayar ? 'badge-success' : 'badge-danger' }}">
                                                            {{ $peminjaman->is_bayar ? 'Sudah Bayar' : 'Belum Bayar' }}
                                                        </span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="card-footer text-right">
                                    <button type="button" class="btn btn-back mr-2" onclick="history.back()">
                                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                                    </button>
                                    <button type="submit" class="btn btn-submit" id="submitBtn">
                                        <i class="fas fa-save mr-2"></i>Update Data
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Timeline (Optional - show history) -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-history mr-2"></i>
                                    Riwayat Peminjaman
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="timeline">
                                    <div class="time-label">
                                        <span class="bg-red">{{ $peminjaman->created_at->format('d M Y') }}</span>
                                    </div>
                                    <div>
                                        <i class="fas fa-plus bg-blue"></i>
                                        <div class="timeline-item">
                                            <span class="time">
                                                <i class="fas fa-clock"></i> {{ $peminjaman->created_at->format('H:i') }}
                                            </span>
                                            <h3 class="timeline-header">
                                                <strong>Peminjaman Dibuat</strong>
                                            </h3>
                                            <div class="timeline-body">
                                                Peminjaman dengan kode <strong>{{ $peminjaman->kode_peminjaman }}</strong>
                                                dibuat oleh {{ $peminjaman->user->name }}
                                            </div>
                                        </div>
                                    </div>

                                    @if ($peminjaman->updated_at != $peminjaman->created_at)
                                        <div>
                                            <i class="fas fa-edit bg-yellow"></i>
                                            <div class="timeline-item">
                                                <span class="time">
                                                    <i class="fas fa-clock"></i>
                                                    {{ $peminjaman->updated_at->format('H:i') }}
                                                </span>
                                                <h3 class="timeline-header">
                                                    <strong>Data Diupdate</strong>
                                                </h3>
                                                <div class="timeline-body">
                                                    Terakhir diupdate pada
                                                    {{ $peminjaman->updated_at->format('d M Y H:i') }}
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($peminjaman->status != 'diajukan')
                                        <div>
                                            <i
                                                class="fas {{ $peminjaman->status == 'disetujui' ? 'fa-check bg-green' : 'fa-times bg-red' }}"></i>
                                            <div class="timeline-item">
                                                <h3 class="timeline-header">
                                                    <strong>Status: {{ ucfirst($peminjaman->status) }}</strong>
                                                </h3>
                                                @if ($peminjaman->approvedBy)
                                                    <div class="timeline-body">
                                                        Oleh: {{ $peminjaman->approvedBy->name }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif

                                    <div>
                                        <i class="fas fa-clock bg-gray"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Character counter for catatan
            $('#catatan').on('input', function() {
                const currentLength = $(this).val().length;
                $('#charCount').text(currentLength);

                if (currentLength > 450) {
                    $('#charCount').addClass('text-danger');
                } else {
                    $('#charCount').removeClass('text-danger');
                }
            });

            // Template buttons
            $('.template-btn').click(function() {
                const template = $(this).data('template');
                const currentText = $('#catatan').val();

                if (currentText) {
                    Swal.fire({
                        title: 'Ganti Template?',
                        text: 'Teks yang sudah ada akan diganti dengan template ini',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Ganti',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#catatan').val(template).trigger('input');
                            $(this).addClass('active').siblings().removeClass('active');
                        }
                    });
                } else {
                    $('#catatan').val(template).trigger('input');
                    $(this).addClass('active').siblings().removeClass('active');
                }
            });

            // Form validation
            $('#editForm').submit(function(e) {
                const catatan = $('#catatan').val().trim();

                if (!catatan) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Catatan Diperlukan!',
                        text: 'Silakan isi catatan sebelum menyimpan data',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    $('#catatan').focus();
                    return false;
                }

                // Show loading
                $('#submitBtn').prop('disabled', true).html(
                    '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...');

                return true;
            });

            // Auto-save draft (optional)
            let autoSaveTimeout;
            $('#catatan').on('input', function() {
                clearTimeout(autoSaveTimeout);
                autoSaveTimeout = setTimeout(function() {
                    const catatan = $('#catatan').val();
                    localStorage.setItem('catatan_draft_{{ $peminjaman->id }}', catatan);
                }, 1000);
            });

            // Load draft on page load
            const savedDraft = localStorage.getItem('catatan_draft_{{ $peminjaman->id }}');
            if (savedDraft && !$('#catatan').val()) {
                $('#catatan').val(savedDraft).trigger('input');

                // Show notification about loaded draft
                const toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });

                toast.fire({
                    icon: 'info',
                    title: 'Draft otomatis dimuat'
                });
            }

            // Clear draft on successful submit
            $('#editForm').on('submit', function() {
                localStorage.removeItem('catatan_draft_{{ $peminjaman->id }}');
            });

            // Success message (if any)
            @if (session('success'))
                Swal.fire({
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                });
            @endif

            // Error message (if any)
            @if (session('error'))
                Swal.fire({
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    icon: 'error'
                });
            @endif

            // Keyboard shortcuts
            $(document).keydown(function(e) {
                // Ctrl + S to save
                if (e.ctrlKey && e.keyCode === 83) {
                    e.preventDefault();
                    $('#editForm').submit();
                }
                // Escape to go back
                if (e.keyCode === 27) {
                    history.back();
                }
            });
        });
    </script>
@endpush
