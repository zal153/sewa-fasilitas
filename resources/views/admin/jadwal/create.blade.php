@extends('admin.layouts.admin')
@section('title', 'Tambah Jadwal')

@push('styles')
    <link rel="stylesheet"
        href="{{ asset('adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <style>
        .form-section {
            background: #f8f9fa;
            border-left: 4px solid #007bff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .time-input {
            position: relative;
        }

        .datetime-preview {
            background: #e9ecef;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
        }
    </style>
@endpush

@section('contentAdmin')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="fas fa-plus-circle"></i> Tambah Jadwal Baru</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('jadwal') }}">Jadwal</a></li>
                            <li class="breadcrumb-item active">Tambah</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-calendar-plus"></i> Form Tambah Jadwal
                                </h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('jadwal.store') }}" id="jadwalForm">
                                @csrf
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
                                                        {{ old('fasilitas_id') == $f->id ? 'selected' : '' }}>
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
                                                    <div class="input-group date" id="tanggalMulaiPicker">
                                                        <input type="date" name="tanggal_mulai" class="form-control"
                                                            value="{{ old('tanggal_mulai', date('Y-m-d')) }}" required>
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
                                                    <div class="input-group time-input">
                                                        <input type="time" name="jam_mulai" class="form-control"
                                                            value="{{ old('jam_mulai', '08:00') }}" required>
                                                        <div class="input-group-append">
                                                            <div class="input-group-text"><i class="fas fa-clock"></i></div>
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
                                                    <div class="input-group date" id="tanggalSelesaiPicker">
                                                        <input type="date" name="tanggal_selesai" class="form-control"
                                                            value="{{ old('tanggal_selesai', date('Y-m-d')) }}" required>
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
                                                    <div class="input-group time-input">
                                                        <input type="time" name="jam_selesai" class="form-control"
                                                            value="{{ old('jam_selesai', '17:00') }}" required>
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

                                        <!-- Duration Preview -->
                                        <div class="datetime-preview" id="durationPreview" style="display: none;">
                                            <h6><i class="fas fa-info-circle"></i> Preview Jadwal:</h6>
                                            <div id="previewContent"></div>
                                        </div>
                                    </div>

                                    <!-- Additional Info Section -->
                                    <div class="form-section">
                                        <h5><i class="fas fa-sticky-note"></i> Informasi Tambahan</h5>
                                        <div class="form-group">
                                            <label for="keterangan">Keterangan (Opsional)</label>
                                            <textarea name="keterangan" id="keterangan" class="form-control" rows="3"
                                                placeholder="Masukkan keterangan tambahan untuk jadwal ini...">{{ old('keterangan') }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                                        <i class="fas fa-save"></i> Simpan Jadwal
                                    </button>
                                    <a href="{{ route('jadwal') }}" class="btn btn-secondary btn-lg">
                                        <i class="fas fa-arrow-left"></i> Kembali
                                    </a>
                                    <button type="reset" class="btn btn-warning btn-lg">
                                        <i class="fas fa-undo"></i> Reset Form
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
    <script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/moment/moment.min.js') }}"></script>

    <script>
        $(document).ready(function() {
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

                updatePreview();
            });

            // Update preview when datetime changes
            $('input[name="tanggal_mulai"], input[name="jam_mulai"], input[name="tanggal_selesai"], input[name="jam_selesai"]')
                .change(function() {
                    updatePreview();
                });

            // Auto-set end date when start date changes
            $('input[name="tanggal_mulai"]').change(function() {
                const startDate = $(this).val();
                if (startDate && !$('input[name="tanggal_selesai"]').val()) {
                    $('input[name="tanggal_selesai"]').val(startDate);
                }
                updatePreview();
            });

            // Validate end time is after start time
            $('input[name="jam_selesai"]').change(function() {
                const startDate = $('input[name="tanggal_mulai"]').val();
                const endDate = $('input[name="tanggal_selesai"]').val();
                const startTime = $('input[name="jam_mulai"]').val();
                const endTime = $(this).val();

                if (startDate === endDate && startTime && endTime) {
                    if (endTime <= startTime) {
                        alert('Jam selesai harus lebih besar dari jam mulai!');
                        $(this).focus();
                        return;
                    }
                }
                updatePreview();
            });

            // Update preview function
            function updatePreview() {
                const startDate = $('input[name="tanggal_mulai"]').val();
                const startTime = $('input[name="jam_mulai"]').val();
                const endDate = $('input[name="tanggal_selesai"]').val();
                const endTime = $('input[name="jam_selesai"]').val();

                if (startDate && startTime && endDate && endTime) {
                    const start = moment(`${startDate} ${startTime}`);
                    const end = moment(`${endDate} ${endTime}`);

                    if (end.isBefore(start)) {
                        $('#previewContent').html(
                            '<span class="text-danger"><i class="fas fa-exclamation-triangle"></i> Waktu selesai tidak boleh lebih awal dari waktu mulai!</span>'
                            );
                        $('#durationPreview').show();
                        return;
                    }

                    const duration = moment.duration(end.diff(start));
                    const days = duration.days();
                    const hours = duration.hours();
                    const minutes = duration.minutes();

                    let durationText = '';
                    if (days > 0) durationText += `${days} hari `;
                    if (hours > 0) durationText += `${hours} jam `;
                    if (minutes > 0) durationText += `${minutes} menit`;

                    const previewHtml = `
               <div class="row">
                   <div class="col-md-6">
                       <strong>Mulai:</strong><br>
                       <i class="fas fa-calendar"></i> ${start.locale('id').format('dddd, DD MMMM YYYY')}<br>
                       <i class="fas fa-clock"></i> ${start.format('HH:mm')} WIB
                   </div>
                   <div class="col-md-6">
                       <strong>Selesai:</strong><br>
                       <i class="fas fa-calendar"></i> ${end.locale('id').format('dddd, DD MMMM YYYY')}<br>
                       <i class="fas fa-clock"></i> ${end.format('HH:mm')} WIB
                   </div>
               </div>
               <hr>
               <div class="text-center">
                   <span class="badge badge-success badge-lg">
                       <i class="fas fa-hourglass-half"></i> Durasi: ${durationText}
                   </span>
               </div>
           `;

                    $('#previewContent').html(previewHtml);
                    $('#durationPreview').show();
                } else {
                    $('#durationPreview').hide();
                }
            }

            // Form validation
            $('#jadwalForm').submit(function(e) {
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

                    if (start.isBefore(moment())) {
                        e.preventDefault();
                        alert('Tidak dapat membuat jadwal untuk waktu yang sudah berlalu!');
                        return false;
                    }
                }

                // Show loading state
                $('#submitBtn').prop('disabled', true).html(
                    '<i class="fas fa-spinner fa-spin"></i> Menyimpan...');
            });

            // Initialize preview
            updatePreview();
        });
    </script>
@endpush
