@extends('admin.layouts.admin')
@section('title', 'Dashboard')

@section('contentAdmin')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3 id="total-fasilitas">{{ $totalFasilitas }}</h3>
                            <p>Total Fasilitas</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <a href="{{ route('fasilitas') ?? '#' }}" class="small-box-footer">
                            Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3 id="persentase-peminjaman">{{ $persentasePeminjaman }}<sup style="font-size: 20px">%</sup>
                            </h3>
                            <p>Tingkat Persetujuan</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <a href="{{ route('peminjaman') ?? '#' }}" class="small-box-footer">
                            Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3 id="pengajuan-peminjaman">{{ $pengajuanPeminjaman }}</h3>
                            <p>Pengajuan Menunggu</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <a href="{{ route('admin.peminjaman.pending') ?? '#' }}" class="small-box-footer">
                            Proses Sekarang <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3 id="total-user">{{ $totalUser }}</h3>
                            <p>Total Pengguna</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <a href="{{ route('operator') ?? '#' }}" class="small-box-footer">
                            Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Informasi tambahan -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Ringkasan Sistem</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-sm btn-primary" onclick="refreshDashboard()">
                                    <i class="fas fa-sync-alt"></i> Refresh Data
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead class="table-dark">
                                        <tr>
                                            <th width="40%">Kategori</th>
                                            <th width="30%">Jumlah</th>
                                            <th width="30%">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><strong>Total Peminjaman</strong></td>
                                            <td><span class="badge badge-info">{{ $totalPeminjaman }}</span></td>
                                            <td>Semua peminjaman yang pernah diajukan</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Menunggu Persetujuan</strong></td>
                                            <td><span class="badge badge-warning">{{ $pengajuanPeminjaman }}</span></td>
                                            <td>Pengajuan yang perlu diproses</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Fasilitas Tersedia</strong></td>
                                            <td>
                                                <span class="badge badge-success">
                                                    {{ \App\Models\Fasilitas::where('status_penggunaan', 'digunakan')->count() }}
                                                </span>
                                            </td>
                                            <td>Fasilitas yang dapat dipinjam</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Fasilitas</strong></td>
                                            <td><span class="badge badge-secondary">{{ $totalFasilitas }}</span></td>
                                            <td>Semua fasilitas (aktif + non-aktif)</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Tingkat Persetujuan</strong></td>
                                            <td><span class="badge badge-primary">{{ $persentasePeminjaman }}%</span></td>
                                            <td>Persentase peminjaman yang disetujui</td>
                                        </tr>
                                        <tr class="table-light">
                                            <td colspan="3"><strong>Detail Pengguna</strong></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;&nbsp;&nbsp;<i class="fas fa-user-graduate"></i> Mahasiswa</td>
                                            <td><span class="badge badge-info">{{ \App\Models\Mahasiswa::count() }}</span>
                                            </td>
                                            <td>Pengguna mahasiswa terdaftar</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;&nbsp;&nbsp;<i class="fas fa-user-tie"></i> Non-Mahasiswa</td>
                                            <td><span
                                                    class="badge badge-info">{{ \App\Models\NonMahasiswa::count() }}</span>
                                            </td>
                                            <td>Pengguna eksternal terdaftar</td>
                                        </tr>
                                        <tr class="table-active">
                                            <td><strong>&nbsp;&nbsp;&nbsp;Total Pengguna</strong></td>
                                            <td><strong><span
                                                        class="badge badge-danger">{{ \App\Models\Mahasiswa::count() + \App\Models\NonMahasiswa::count() }}</span></strong>
                                            </td>
                                            <td><strong>Total semua pengguna aktif</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        function refreshDashboard() {
            // Tampilkan loading
            $('#total-fasilitas, #persentase-peminjaman, #pengajuan-peminjaman, #total-user').html(
                '<i class="fas fa-spinner fa-spin"></i>');

            $.ajax({
                url: '{{ route('admin.dashboard.data') ?? '#' }}',
                type: 'GET',
                success: function(data) {
                    // Update angka-angka di dashboard
                    $('#total-fasilitas').text(data.totalFasilitas);
                    $('#persentase-peminjaman').html(data.persentasePeminjaman +
                        '<sup style="font-size: 20px">%</sup>');
                    $('#pengajuan-peminjaman').text(data.pengajuanPeminjaman);
                    $('#total-user').text(data.totalUser);

                    // Tampilkan notifikasi berhasil
                    toastr.success('Dashboard berhasil diperbarui!');
                },
                error: function() {
                    toastr.error('Gagal memperbarui dashboard!');
                    // Reload halaman jika AJAX gagal
                    location.reload();
                }
            });
        }

        // Auto refresh setiap 2 menit
        setInterval(function() {
            refreshDashboard();
        }, 120000);
    </script>
@endpush
