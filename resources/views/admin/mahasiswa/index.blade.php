@extends('admin.layouts.admin')

@section('title', 'Daftar Mahasiswa')

@section('contentAdmin')
    <!-- Main Content -->
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <form class="form-inline mr-3" method="GET" action="{{ route('mahasiswa') }}">
                        <div class="input-group input-group-sm">
                            <input name="search" class="form-control form-control-navbar" type="search"
                                placeholder="Cari nama atau email..." value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button class="btn btn-navbar" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <button onclick="window.location.reload();" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-sync-alt"></i> Refresh Data
                    </button>
                </div>
                <a href="{{ route('mahasiswa.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Tambah Data
                </a>
            </div>
        </section>

        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body table-responsive p-0">
                        <table class="table table-bordered table-head-fixed text-nowrap">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>NIM</th>
                                    <th>Jurusan</th>
                                    <th>Angkatan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $item->user->name ?? '-' }}</td>
                                        <td>{{ $item->user->email ?? '-' }}</td>
                                        <td>{{ $item->nim ?? 'Belum Diisi' }}</td>
                                        <td>{{ $item->jurusan ?? 'Belum Diisi' }}</td>
                                        <td>{{ $item->angkatan ?? 'Belum Diisi' }}</td>
                                        <td>
                                            <a href="{{ route('mahasiswa.edit', $item->id) }}"
                                                class="btn btn-sm btn-primary">Edit</a>
                                            <form action="{{ route('mahasiswa.destroy', $item->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Data tidak ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="card-footer clearfix">
                        <div class="float-left">
                            @php
                                $start = ($data->currentPage() - 1) * $data->perPage() + 1;
                                $end = min($data->currentPage() * $data->perPage(), $data->total());
                            @endphp
                            <p>Showing {{ $start }} to {{ $end }} of {{ $data->total() }} entries</p>
                        </div>
                        <div class="float-right">
                            {{ $data->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
