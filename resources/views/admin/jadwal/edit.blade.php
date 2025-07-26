@extends('admin.layouts.admin')
@section('title', 'Edit Jadwal')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.3.0/dist/select2-bootstrap4.min.css">
    <style>
        .form-section {
            background: #f8f9fa;
            border-left: 4px solid #ffc107;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .current-info {
            background: #e7f3ff;
            border: 1px solid #b3d9ff;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .datetime-preview {
            background: #e9ecef;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
        }

        .comparison-table {
            background: white;
            border-radius: 5px;
            overflow: hidden;
        }
    </style>
@endpush

@section('contentAdmin')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="fas fa-edit"></i> Edit Jadwal</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('jadwal') }}">Jadwal</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- Current Schedule Info -->
                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-info-circle"></i> Informasi Jadwal Saat Ini
                                </h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <strong><i class="fas fa-building"></i> Fasilitas:</strong><br>
                                        <span class="text-primary">{{ $jadwal->fasilitas->nama_fasilitas ?? 'N/A' }}</span>
                                    </div>
                                    <div class="col-md-3">
                                        <strong><i class="fas fa-calendar-alt"></i> Tanggal Mulai:</strong><br>
                                        {{ $jadwal->waktu_mulai->format('d M Y') }}
                                    </div>
                                    <div class="col-md-3">
                                        <strong><i class="fas fa-clock"></i> Waktu:</strong><br>
                                        {{ $jadwal->waktu_mulai->format('H:i') }} -
                                        {{ $jadwal->waktu_selesai->format('H:i') }}
                                    </div>
                                    <div class="col-md-3">
                                        <strong><i class="fas fa-hourglass-half"></i> Durasi:</strong><br>
                                        {{ $jadwal->waktu_mulai->diffInHours($jadwal->waktu_selesai) }} jam
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Form -->
                        <div class="card card-warning card-outline">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-edit"></i> Form Edit Jadwal
                                </h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('jadwal.update', $jadwal->id) }}" id="editJadwalForm">
                                @csrf
                                @method('PUT')

                                <div class="card-body">
                                    <!-- Fasilitas Section -->
                                    <div class="form-section">
                                        <h5><i class="fas fa-building"></i> Informasi Fasilitas</h5>
                                        <div class="form-group">
                                            <label for="fasilitas_id">Pilih Fasilitas <span
                                                    class="text-danger">*</span></label>
                                            <select name="fasilitas_id" id="fasilitas_id" class="form-control select2"
                                                required>
                                                <option value="">-- Pilih Fasilitas --</option>
                                                @foreach ($fasilitas as $f)
                                                    <option value="{{ $f->id }}"
                                                        data-lokasi="{{ $f->lokasi ?? 'N/A' }}"
                                                        data-kapasitas="{{ $f->kapasitas ?? 'N/A' }}"
                                                        {{ old('fasilitas_id', $jadwal->fasilitas_id) == $f->id ? 'selected' : '' }}>
                                                        {{ $f->nama_fasilitas }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('fasilitas_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            <div id="fasilitasInfo" class="mt-2" style="display: none;">
                                                <div class="alert alert-info">
                                                    <strong>Detail Fasilitas:</strong>
                                                    <br><i class="fas fa-map-marker-alt"></i> Lokasi: <span
                                                        id="lokasiInfo"></span>
                                                    <br><i class="fas fa-users"></i> Kapasitas: <span
                                                        id="kapasitasInfo"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Waktu Section -->
                                    <div class="form-section">
                                        <h5><i class="fas fa-clock"></i> Pengaturan Waktu</h5>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="tanggal_mulai">Tanggal Mulai <span
                                                            class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <input type="date" name="tanggal_mulai" class="form-control"
                                                            value="{{ old('tanggal_mulai', $jadwal->waktu_mulai->format('Y-m-d')) }}"
                                                            required>
                                                        <div class="input-group-append">
                                                            <div class="input-group-text"><i class="fa fa-calendar-alt"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @error('tanggal_mulai')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="jam_mulai">Jam Mulai <span
                                                            class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <input type="time" name="jam_mulai" class="form-control"
                                                            value="{{ old('jam_mulai', $jadwal->waktu_mulai->format('H:i')) }}"
                                                            required>
                                                        <div class="input-group-append">
                                                            <div class="input-group-text"><i class="fas fa-clock"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @error('jam_mulai')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="tanggal_selesai">Tanggal Selesai <span
                                                            class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <input type="date" name="tanggal_selesai" class="form-control"
                                                            value="{{ old('tanggal_selesai', $jadwal->waktu_selesai->format('Y-m-d')) }}"
                                                            required>
                                                        <div class="input-group-append">
                                                            <div class="input-group-text"><i
                                                                    class="fa fa-calendar-alt"></i></div>
                                                        </div>
                                                    </div>
                                                    @error('tanggal_selesai')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="jam_selesai">Jam Selesai <span
                                                            class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <input type="time" name="jam_selesai" class="form-control"
                                                            value="{{ old('jam_selesai', $jadwal->waktu_selesai->format('H:i')) }}"
                                                            required>
                                                        <div class="input-group-append">
                                                            <div class="input-group-text"><i class="fas fa-clock"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @error('jam_selesai')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Quick Time Buttons -->
                                        <div class="form-group">
                                            <label>Preset Waktu:</label>
                                            <div class="btn-group-toggle" data-toggle="buttons">
                                                <button type="button" class="btn btn-outline-primary btn-sm preset-time"
                                                    data-start="08:00" data-end="12:00">Pagi (08:00-12:00)</button>
                                                <button type="button" class="btn btn-outline-success btn-sm preset-time"
                                                    data-start="13:00" data-end="17:00">Siang (13:00-17:00)</button>
                                                <button type="button" class="btn btn-outline-warning btn-sm preset-time"
                                                    data-start="18:00" data-end="22:00">Malam (18:00-22:00)</button>
                                                <button type="button" class="btn btn-outline-info btn-sm preset-time"
                                                    data-start="08:00" data-end="17:00">Full Day (08:00-17:00)</button>
                                            </div>
                                        </div>

                                        <!-- Comparison Table -->
                                        <div class="comparison-table" id="comparisonTable" style="display: none;">
                                            <div class="card">
                                                <div class="card-header bg-light">
                                                    <h6 class="mb-0"><i class="fas fa-exchange-alt"></i> Perbandingan
                                                        Perubahan</h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-sm">
                                                            <thead>
                                                                <tr>
                                                                    <th>Keterangan</th>
                                                                    <th class="text-info">Sebelum</th>
                                                                    <th class="text-warning">Sesudah</th>
                                                                    <th class="text-center">Status</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="comparisonContent">
                                                                <!-- Content will be filled by JavaScript -->
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-warning btn-lg" id="updateBtn">
                                        <i class="fas fa-save"></i> Update Jadwal
                                    </button>
                                    <a href="{{ route('jadwal') }}" class="btn btn-secondary btn-lg">
                                        <i class="fas fa-arrow-left"></i> Kembali
                                    </a>
                                    <button type="button" class="btn btn-info btn-lg" id="resetBtn">
                                        <i class="fas fa-undo"></i> Reset ke Asal
                                    </button>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>

    <script>
        $(document).ready(function() {
            // Original values for comparison
            const originalData = {
                fasilitas_id: '{{ $jadwal->fasilitas_id }}',
                tanggal_mulai: '{{ $jadwal->waktu_mulai->format('Y-m-d') }}',
                jam_mulai: '{{ $jadwal->waktu_mulai->format('H:i') }}',
                tanggal_selesai: '{{ $jadwal->waktu_selesai->format('Y-m-d') }}',
                jam_selesai: '{{ $jadwal->waktu_selesai->format('H:i') }}',
                fasilitas_nama: '{{ $jadwal->fasilitas->nama_fasilitas ?? 'N/A' }}'
            };

            // Initialize Select2
            $('.select2').select2({
                theme: 'bootstrap4',
                placeholder: '-- Pilih Fasilitas --'
            });

            // Show facility info when selected
            $('#fasilitas_id').change(function() {
                const selectedOption = $(this).find('option:selected');
                if (selectedOption.val()) {
                    const lokasi = selectedOption.data('lokasi');
                    const kapasitas = selectedOption.data('kapasitas');

                    $('#lokasiInfo').text(lokasi);
                    $('#kapasitasInfo').text(kapasitas);
                    $('#fasilitasInfo').fadeIn();
                } else {
                    $('#fasilitasInfo').fadeOut();
                }
                updateComparison();
            });

            // Preset time buttons
            $('.preset-time').click(function() {
                const startTime = $(this).data('start');
                const endTime = $(this).data('end');

                $('input[name="jam_mulai"]').val(startTime);
                $('input[name="jam_selesai"]').val(endTime);

                // Remove active class from all buttons and add to clicked button
                $('.preset-time').removeClass('active btn-primary').addClass('btn-outline-primary');
                $(this).removeClass('btn-outline-primary').addClass('btn-primary active');

                updateComparison();
            });

            // Update comparison when any field changes
            $('select[name="fasilitas_id"], input[name="tanggal_mulai"], input[name="jam_mulai"], input[name="tanggal_selesai"], input[name="jam_selesai"]')
                .change(function() {
                    updateComparison();
                });

            // Reset to original values
            $('#resetBtn').click(function() {
                $('select[name="fasilitas_id"]').val(originalData.fasilitas_id).trigger('change');
                $('input[name="tanggal_mulai"]').val(originalData.tanggal_mulai);
                $('input[name="jam_mulai"]').val(originalData.jam_mulai);
                $('input[name="tanggal_selesai"]').val(originalData.tanggal_selesai);
                $('input[name="jam_selesai"]').val(originalData.jam_selesai);

                $('#comparisonTable').hide();

                // Show confirmation
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
                Toast.fire({
                    icon: 'info',
                    title: 'Form direset ke nilai awal'
                });
            });

            // Update comparison function
            function updateComparison() {
                const currentData = {
                    fasilitas_id: $('select[name="fasilitas_id"]').val(),
                    tanggal_mulai: $('input[name="tanggal_mulai"]').val(),
                    jam_mulai: $('input[name="jam_mulai"]').val(),
                    tanggal_selesai: $('input[name="tanggal_selesai"]').val(),
                    jam_selesai: $('input[name="jam_selesai"]').val(),
                    fasilitas_nama: $('select[name="fasilitas_id"] option:selected').text()
                };

                let hasChanges = false;
                let comparisonHtml = '';

                // Compare each field
                if (currentData.fasilitas_id !== originalData.fasilitas_id) {
                    hasChanges = true;
                    comparisonHtml += `
                <tr>
                    <td><strong>Fasilitas</strong></td>
                    <td class="text-info">${originalData.fasilitas_nama}</td>
                    <td class="text-warning">${currentData.fasilitas_nama}</td>
                    <td class="text-center"><i class="fas fa-arrow-right text-warning"></i></td>
                </tr>
            `;
                }

                if (currentData.tanggal_mulai !== originalData.tanggal_mulai) {
                    hasChanges = true;
                    comparisonHtml += `
                <tr>
                    <td><strong>Tanggal Mulai</strong></td>
                    <td class="text-info">${moment(originalData.tanggal_mulai).format('DD MMM YYYY')}</td>
                    <td class="text-warning">${moment(currentData.tanggal_mulai).format('DD MMM YYYY')}</td>
                    <td class="text-center"><i class="fas fa-arrow-right text-warning"></i></td>
                </tr>
            `;
                }

                if (currentData.jam_mulai !== originalData.jam_mulai) {
                    hasChanges = true;
                    comparisonHtml += `
                <tr>
                    <td><strong>Jam Mulai</strong></td>
                    <td class="text-info">${originalData.jam_mulai}</td>
                    <td class="text-warning">${currentData.jam_mulai}</td>
                    <td class="text-center"><i class="fas fa-arrow-right text-warning"></i></td>
                </tr>
            `;
                }

                if (currentData.tanggal_selesai !== originalData.tanggal_selesai) {
                    hasChanges = true;
                    comparisonHtml += `
                <tr>
                    <td><strong>Tanggal Selesai</strong></td>
                    <td class="text-info">${moment(originalData.tanggal_selesai).format('DD MMM YYYY')}</td>
                    <td class="text-warning">${moment(currentData.tanggal_selesai).format('DD MMM YYYY')}</td>
                    <td class="text-center"><i class="fas fa-arrow-right text-warning"></i></td>
                </tr>
            `;
                }

                if (currentData.jam_selesai !== originalData.jam_selesai) {
                    hasChanges = true;
                    comparisonHtml += `
                <tr>
                    <td><strong>Jam Selesai</strong></td>
                    <td class="text-info">${originalData.jam_selesai}</td>
                    <td class="text-warning">${currentData.jam_selesai}</td>
                    <td class="text-center"><i class="fas fa-arrow-right text-warning"></i></td>
                </tr>
            `;
                }

                if (hasChanges) {
                    $('#comparisonContent').html(comparisonHtml);
                    $('#comparisonTable').show();
                } else {
                    $('#comparisonTable').hide();
                }
            }

            // Form validation
            $('#editJadwalForm').submit(function(e) {
                const startDate = $('input[name="tanggal_mulai"]').val();
                const startTime = $('input[name="jam_mulai"]').val();
                const endDate = $('input[name="tanggal_selesai"]').val();
                const endTime = $('input[name="jam_selesai"]').val();

                if (startDate && startTime && endDate && endTime) {
                    const start = moment(`${startDate} ${startTime}`);
                    const end = moment(`${endDate} ${endTime}`);

                    if (end.isBefore(start)) {
                        e.preventDefault();
                        alert('Waktu selesai tidak boleh lebih awal dari waktu mulai!');
                        return false;
                    }
                }

                // Show loading state
                $('#updateBtn').prop('disabled', true).html(
                    '<i class="fas fa-spinner fa-spin"></i> Mengupdate...');
            });

            // Initialize facility info display
            $('#fasilitas_id').trigger('change');
        });
    </script>
@endpush
