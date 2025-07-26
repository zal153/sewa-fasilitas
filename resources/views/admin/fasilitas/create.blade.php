@extends('admin.layouts.admin')

@section('title', 'Tambah Data Fasilitas')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        .step-indicator {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .step {
            flex: 1;
            text-align: center;
            padding: 10px;
            background: #f4f4f4;
            border-radius: 5px;
            margin: 0 5px;
            transition: all 0.3s ease;
        }

        .step.active {
            background: #007bff;
            color: white;
        }

        .step.completed {
            background: #28a745;
            color: white;
        }

        .drag-drop-area {
            border: 2px dashed #ccc;
            border-radius: 10px;
            padding: 40px;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .drag-drop-area:hover {
            border-color: #007bff;
            background-color: #f8f9ff;
        }

        .drag-drop-area.dragover {
            border-color: #007bff;
            background-color: #e3f2fd;
        }

        .preview-container {
            position: relative;
            display: inline-block;
            margin: 10px;
        }

        .remove-image {
            position: absolute;
            top: -10px;
            right: -10px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            font-size: 12px;
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
                        <h1><i class="fas fa-plus-circle"></i> Tambah Data Fasilitas</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i>
                                    Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('fasilitas') }}">Fasilitas</a></li>
                            <li class="breadcrumb-item active">Tambah</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <h5><i class="icon fas fa-ban"></i> Error!</h5>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-plus"></i> Form Tambah Fasilitas</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                        <i class="fas fa-expand"></i>
                                    </button>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('fasilitas.store') }}" enctype="multipart/form-data"
                                id="createFasilitasForm">
                                @csrf

                                <div class="card-body">
                                    <!-- Step Indicator -->
                                    <div class="step-indicator">
                                        <div class="step active" id="step1">
                                            <i class="fas fa-info-circle"></i><br>
                                            <small>Informasi Dasar</small>
                                        </div>
                                        <div class="step" id="step2">
                                            <i class="fas fa-cog"></i><br>
                                            <small>Detail & Biaya</small>
                                        </div>
                                        <div class="step" id="step3">
                                            <i class="fas fa-image"></i><br>
                                            <small>Gambar</small>
                                        </div>
                                    </div>

                                    <!-- Step 1: Basic Info -->
                                    <div class="step-content" id="step1-content">
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
                                                            value="{{ old('nama_fasilitas') }}" required
                                                            placeholder="Contoh: Ruang Meeting A">
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
                                                            id="lokasi" name="lokasi" value="{{ old('lokasi') }}"
                                                            required placeholder="Contoh: Lantai 2, Gedung A">
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
                                                placeholder="Jelaskan detail fasilitas, fitur yang tersedia, dll...">{{ old('deskripsi') }}</textarea>
                                            <small class="form-text text-muted">
                                                <span id="charCount">0</span> karakter
                                            </small>
                                            @error('deskripsi')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="text-right">
                                            <button type="button" class="btn btn-primary" onclick="nextStep(2)">
                                                Selanjutnya <i class="fas fa-arrow-right"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Step 2: Details & Cost -->
                                    <div class="step-content" id="step2-content" style="display: none;">
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
                                                        <option value="">-- Pilih Status --</option>
                                                        <option value="Digunakan"
                                                            {{ old('status_penggunaan') == 'Digunakan' ? 'selected' : '' }}>
                                                            Digunakan
                                                        </option>
                                                        <option value="Tidak Digunakan"
                                                            {{ old('status_penggunaan') == 'Tidak Digunakan' ? 'selected' : '' }}>
                                                            Tidak Digunakan
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
                                                            <span class="input-group-text"><i
                                                                    class="fas fa-users"></i></span>
                                                        </div>
                                                        <input type="number"
                                                            class="form-control @error('kapasitas') is-invalid @enderror"
                                                            id="kapasitas" name="kapasitas"
                                                            value="{{ old('kapasitas') }}" min="1" required
                                                            placeholder="0">
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
                                                            id="biaya" name="biaya" value="{{ old('biaya') }}"
                                                            required placeholder="0">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">/hari</span>
                                                        </div>
                                                    </div>
                                                    @error('biaya')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="callout callout-info">
                                                    <h5><i class="fas fa-info"></i> Informasi:</h5>
                                                    Pastikan data yang dimasukkan sudah benar sebelum melanjutkan ke tahap
                                                    upload gambar.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-between d-flex justify-content-between">
                                            <button type="button" class="btn btn-outline-secondary"
                                                onclick="prevStep(1)">
                                                <i class="fas fa-arrow-left"></i> Sebelumnya
                                            </button>
                                            <button type="button" class="btn btn-primary" onclick="nextStep(3)">
                                                Selanjutnya <i class="fas fa-arrow-right"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Step 3: Image Upload -->
                                    <div class="step-content" id="step3-content" style="display: none;">
                                        <div class="form-group">
                                            <label for="gambar">
                                                <i class="fas fa-image"></i> Gambar Fasilitas
                                                <small class="text-muted">(Opsional - Rekomendasi: 400x250px, Max:
                                                    2MB)</small>
                                            </label>

                                            <div class="drag-drop-area" id="dragDropArea">
                                                <div class="dz-message">
                                                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                                    <h4>Drag & Drop gambar di sini</h4>
                                                    <p class="text-muted">atau klik untuk memilih file</p>
                                                    <button type="button" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-plus"></i> Pilih Gambar
                                                    </button>
                                                </div>

                                                <input type="file" class="d-none @error('gambar') is-invalid @enderror"
                                                    id="gambar" name="gambar" accept="image/*"
                                                    onchange="handleFileSelect(event)">
                                            </div>

                                            <div id="imagePreview" class="mt-3" style="display: none;">
                                                <div class="preview-container">
                                                    <img id="preview" src="#" alt="Preview"
                                                        class="img-thumbnail" style="max-width: 300px;">
                                                    <button type="button" class="remove-image" onclick="removeImage()">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            @error('gambar')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="text-between d-flex justify-content-between">
                                            <button type="button" class="btn btn-outline-secondary"
                                                onclick="prevStep(2)">
                                                <i class="fas fa-arrow-left"></i> Sebelumnya
                                            </button>
                                            <button type="submit" class="btn btn-success btn-lg">
                                                <i class="fas fa-save"></i> Simpan Data
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer bg-light">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <small class="text-muted">
                                                <i class="fas fa-info-circle"></i>
                                                Field yang bertanda <span class="text-danger">*</span> wajib diisi
                                            </small>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <a href="{{ route('fasilitas') }}" class="btn btn-outline-danger">
                                                <i class="fas fa-times"></i> Batal
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
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
            // Character counter for description
            $('#deskripsi').on('input', function() {
                const length = $(this).val().length;
                $('#charCount').text(length);
            });

            // Format currency input
            $('#biaya').on('input', function() {
                let value = $(this).val().replace(/\D/g, '');
                $(this).val(formatNumber(value));
            });

            // Drag and drop functionality
            const dragDropArea = document.getElementById('dragDropArea');
            const fileInput = document.getElementById('gambar');

            dragDropArea.addEventListener('click', () => fileInput.click());

            dragDropArea.addEventListener('dragover', (e) => {
                e.preventDefault();
                dragDropArea.classList.add('dragover');
            });

            dragDropArea.addEventListener('dragleave', () => {
                dragDropArea.classList.remove('dragover');
            });

            dragDropArea.addEventListener('drop', (e) => {
                e.preventDefault();
                dragDropArea.classList.remove('dragover');

                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    fileInput.files = files;
                    handleFileSelect({
                        target: {
                            files: files
                        }
                    });
                }
            });

            // Form validation before step change
            window.validateStep = function(step) {
                let isValid = true;

                if (step === 1) {
                    const requiredFields = ['nama_fasilitas', 'lokasi'];
                    requiredFields.forEach(field => {
                        const input = document.getElementById(field);
                        if (!input.value.trim()) {
                            input.classList.add('is-invalid');
                            isValid = false;
                        } else {
                            input.classList.remove('is-invalid');
                        }
                    });
                } else if (step === 2) {
                    const requiredFields = ['status_penggunaan', 'kapasitas', 'biaya'];
                    requiredFields.forEach(field => {
                        const input = document.getElementById(field);
                        if (!input.value.trim()) {
                            input.classList.add('is-invalid');
                            isValid = false;
                        } else {
                            input.classList.remove('is-invalid');
                        }
                    });
                }

                return isValid;
            };

            // Form submission with loading
            $('#createFasilitasForm').on('submit', function(e) {
                if (!validateStep(2)) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Validasi Gagal!',
                        text: 'Pastikan semua field wajib sudah diisi dengan benar',
                        icon: 'error'
                    });
                    return false;
                }

                const submitBtn = $(this).find('button[type="submit"]');
                submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...').prop('disabled',
                    true);
            });
        });

        function nextStep(step) {
            const currentStep = step - 1;

            if (!validateStep(currentStep)) {
                return false;
            }

            // Hide current step
            document.getElementById(`step${currentStep}-content`).style.display = 'none';
            document.getElementById(`step${currentStep}`).classList.remove('active');
            document.getElementById(`step${currentStep}`).classList.add('completed');

            // Show next step
            document.getElementById(`step${step}-content`).style.display = 'block';
            document.getElementById(`step${step}`).classList.add('active');
        }

        function prevStep(step) {
            const currentStep = step + 1;

            // Hide current step
            document.getElementById(`step${currentStep}-content`).style.display = 'none';
            document.getElementById(`step${currentStep}`).classList.remove('active');

            // Show previous step
            document.getElementById(`step${step}-content`).style.display = 'block';
            document.getElementById(`step${step}`).classList.add('active');
            document.getElementById(`step${step}`).classList.remove('completed');
        }

        function handleFileSelect(event) {
            const file = event.target.files[0];
            if (file) {
                // Validate file size (2MB)
                if (file.size > 2 * 1024 * 1024) {
                    Swal.fire({
                        title: 'File Terlalu Besar!',
                        text: 'Ukuran file maksimal 2MB',
                        icon: 'error'
                    });
                    return;
                }

                // Validate file type
                if (!file.type.startsWith('image/')) {
                    Swal.fire({
                        title: 'File Tidak Valid!',
                        text: 'Hanya file gambar yang diperbolehkan',
                        icon: 'error'
                    });
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                    document.getElementById('imagePreview').style.display = 'block';
                    document.getElementById('dragDropArea').style.display = 'none';
                };
                reader.readAsDataURL(file);
            }
        }

        function removeImage() {
            document.getElementById('gambar').value = '';
            document.getElementById('imagePreview').style.display = 'none';
            document.getElementById('dragDropArea').style.display = 'block';
        }

        function formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Show success/error messages
        @if (session('success'))
            toastr.success('{{ session('success') }}');
        @endif

        @if (session('error'))
            toastr.error('{{ session('error') }}');
        @endif
    </script>
@endpush
