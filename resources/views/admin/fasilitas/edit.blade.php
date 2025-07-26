@extends('admin.layouts.admin')

@section('title', 'Edit Data Fasilitas')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        .image-preview-container {
            position: relative;
            display: inline-block;
        }

        .image-preview-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            border-radius: 0.25rem;
        }

        .image-preview-container:hover .image-preview-overlay {
            opacity: 1;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
        }

        .card {
            box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
            transition: box-shadow 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 6px rgba(0, 0, 0, .3);
        }

        .btn {
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }
    </style>
@endpush

@section('contentAdmin')
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="fas fa-edit"></i> Edit Data Fasilitas</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i>
                                    Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('fasilitas') }}">Fasilitas</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <!-- Form Card -->
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-pen"></i> Form Edit Fasilitas</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                        <i class="fas fa-expand"></i>
                                    </button>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('fasilitas.update', $fasilitas->id) }}"
                                enctype="multipart/form-data" id="editFasilitasForm">
                                @csrf
                                @method('PUT')

                                <div class="card-body">
                                    <!-- Progress Bar -->
                                    <div class="progress mb-3" style="height: 3px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 0%"></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nama_fasilitas">
                                                    <i class="fas fa-building"></i> Nama Fasilitas
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="fas fa-building"></i></span>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control @error('nama_fasilitas') is-invalid @enderror"
                                                        id="nama_fasilitas" name="nama_fasilitas"
                                                        value="{{ old('nama_fasilitas', $fasilitas->nama_fasilitas) }}"
                                                        required data-toggle="tooltip" title="Masukkan nama fasilitas">
                                                </div>
                                                @error('nama_fasilitas')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="lokasi">
                                                    <i class="fas fa-map-marker-alt"></i> Lokasi
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="fas fa-map-marker-alt"></i></span>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control @error('lokasi') is-invalid @enderror"
                                                        id="lokasi" name="lokasi"
                                                        value="{{ old('lokasi', $fasilitas->lokasi) }}" required>
                                                </div>
                                                @error('lokasi')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="deskripsi">
                                            <i class="fas fa-align-left"></i> Deskripsi
                                        </label>
                                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="4"
                                            placeholder="Masukkan deskripsi fasilitas...">{{ old('deskripsi', $fasilitas->deskripsi) }}</textarea>
                                        <small class="form-text text-muted">
                                            <span id="charCount">0</span> karakter
                                        </small>
                                        @error('deskripsi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="status_penggunaan">
                                                    <i class="fas fa-toggle-on"></i> Status
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <select
                                                    class="form-control @error('status_penggunaan') is-invalid @enderror"
                                                    id="status_penggunaan" name="status_penggunaan" required>
                                                    <option value="digunakan"
                                                        {{ old('status_penggunaan', $fasilitas->status_penggunaan) == 'digunakan' ? 'selected' : '' }}>
                                                        <i class="fas fa-check"></i> Digunakan
                                                    </option>
                                                    <option value="tidak_digunakan"
                                                        {{ old('status_penggunaan', $fasilitas->status_penggunaan) == 'tidak_digunakan' ? 'selected' : '' }}>
                                                        <i class="fas fa-times"></i> Tidak Digunakan
                                                    </option>
                                                </select>
                                                @error('status_penggunaan')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="kapasitas">
                                                    <i class="fas fa-users"></i> Kapasitas
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-users"></i></span>
                                                    </div>
                                                    <input type="number"
                                                        class="form-control @error('kapasitas') is-invalid @enderror"
                                                        id="kapasitas" name="kapasitas"
                                                        value="{{ old('kapasitas', $fasilitas->kapasitas) }}"
                                                        min="1" required>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">orang</span>
                                                    </div>
                                                </div>
                                                @error('kapasitas')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="biaya">
                                                    <i class="fas fa-money-bill-wave"></i> Biaya
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Rp</span>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control @error('biaya') is-invalid @enderror"
                                                        id="biaya" name="biaya"
                                                        value="{{ old('biaya', number_format($fasilitas->biaya, 0, ',', '.')) }}"
                                                        required>
                                                </div>
                                                @error('biaya')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="gambar">
                                            <i class="fas fa-image"></i> Gambar Fasilitas
                                            <small class="text-muted">(Rekomendasi: 400x250px, Max: 2MB)</small>
                                        </label>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="image-preview-container">
                                                    @if ($fasilitas->gambar)
                                                        <img id="preview-img"
                                                            src="{{ asset('storage/' . $fasilitas->gambar) }}"
                                                            alt="Preview" class="img-thumbnail"
                                                            style="width: 100%; max-width: 300px; height: 200px; object-fit: cover;">
                                                        <div class="image-preview-overlay">
                                                            <button type="button" class="btn btn-light btn-sm"
                                                                onclick="document.getElementById('gambar').click()">
                                                                <i class="fas fa-edit"></i> Ganti
                                                            </button>
                                                        </div>
                                                    @else
                                                        <div class="d-flex align-items-center justify-content-center border rounded"
                                                            style="height: 200px; background-color: #f8f9fa;">
                                                            <div class="text-center text-muted">
                                                                <i class="fas fa-image fa-3x mb-2"></i>
                                                                <p>Belum ada gambar</p>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="custom-file">
                                                    <input type="file"
                                                        class="custom-file-input @error('gambar') is-invalid @enderror"
                                                        id="gambar" name="gambar" accept="image/*"
                                                        onchange="previewImage(event)">
                                                    <label class="custom-file-label" for="gambar">Pilih
                                                        gambar...</label>
                                                </div>

                                                <div class="mt-2">
                                                    <small class="text-muted">
                                                        <i class="fas fa-info-circle"></i>
                                                        Format yang didukung: JPG, PNG, GIF (Max: 2MB)
                                                    </small>
                                                </div>

                                                @error('gambar')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer bg-light">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-primary btn-lg">
                                                <i class="fas fa-save"></i> Update Data
                                            </button>
                                            <button type="button" class="btn btn-secondary btn-lg ml-2"
                                                onclick="resetForm()">
                                                <i class="fas fa-undo"></i> Reset
                                            </button>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <a href="{{ route('fasilitas') }}" class="btn btn-outline-danger btn-lg">
                                                <i class="fas fa-arrow-left"></i> Kembali
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Info Card -->
                    <div class="col-md-4">
                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-info-circle"></i> Informasi</h3>
                            </div>
                            <div class="card-body">
                                <div class="info-box bg-light">
                                    <span class="info-box-icon bg-info"><i class="fas fa-calendar"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Dibuat</span>
                                        <span
                                            class="info-box-number">{{ $fasilitas->created_at ? $fasilitas->created_at->format('d M Y') : '-' }}</span>
                                    </div>
                                </div>

                                <div class="info-box bg-light">
                                    <span class="info-box-icon bg-warning"><i class="fas fa-edit"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Terakhir Update</span>
                                        <span
                                            class="info-box-number">{{ $fasilitas->updated_at ? $fasilitas->updated_at->format('d M Y') : '-' }}</span>
                                    </div>
                                </div>

                                <hr>

                                <h6><i class="fas fa-lightbulb"></i> Tips:</h6>
                                <ul class="list-unstyled">
                                    <li><small><i class="fas fa-check text-success"></i> Gunakan gambar berkualitas
                                            tinggi</small></li>
                                    <li><small><i class="fas fa-check text-success"></i> Deskripsi yang jelas akan membantu
                                            user</small></li>
                                    <li><small><i class="fas fa-check text-success"></i> Pastikan lokasi mudah
                                            dipahami</small></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();

            // Character counter for description
            $('#deskripsi').on('input', function() {
                const length = $(this).val().length;
                $('#charCount').text(length);
            });

            // Update progress bar based on form completion
            function updateProgressBar() {
                const requiredFields = $('input[required], select[required]');
                const filledFields = requiredFields.filter(function() {
                    return $(this).val() !== '';
                });

                const progress = (filledFields.length / requiredFields.length) * 100;
                $('.progress-bar').css('width', progress + '%');
            }

            $('input[required], select[required]').on('input change', updateProgressBar);
            updateProgressBar(); // Initial check

            // Format currency input
            $('#biaya').on('input', function() {
                let value = $(this).val().replace(/\D/g, '');
                $(this).val(formatNumber(value));
            });

            // Form submission with loading
            $('#editFasilitasForm').on('submit', function() {
                const submitBtn = $(this).find('button[type="submit"]');
                submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...').prop('disabled',
                true);
            });
        });

        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('preview-img');
                output.src = reader.result;
                output.style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);

            // Update file label
            const fileName = event.target.files[0].name;
            $(event.target).next('.custom-file-label').text(fileName);
        }

        function resetForm() {
            Swal.fire({
                title: 'Reset Form?',
                text: 'Semua perubahan akan dikembalikan ke data asli',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Reset!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.reload();
                }
            });
        }

        function formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Show success message if exists
        @if (session('success'))
            toastr.success('{{ session('success') }}');
        @endif

        @if (session('error'))
            toastr.error('{{ session('error') }}');
        @endif
    </script>
@endpush
