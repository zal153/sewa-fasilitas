@extends('admin.layouts.admin')
@section('title', 'Notifikasi')

@section('contentAdmin')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Notifikasi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Notifikasi</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Notifikasi</h3>
                            <div class="card-tools">
                                <a href="{{ route('admin.notifications.markAllAsRead') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-check-double"></i> Tandai Semua Dibaca
                                </a>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Jenis</th>
                                            <th>Judul</th>
                                            <th>Pesan</th>
                                            <th>Waktu</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($notifications as $key => $notification)
                                            <tr class="{{ $notification->read_at ? '' : 'bg-light' }}">
                                                <td>{{ $notifications->firstItem() + $key }}</td>
                                                <td>
                                                    @if($notification->data['type'] == 'status_peminjaman')
                                                        <span class="badge badge-info">
                                                            <i class="fas fa-clipboard-list"></i> Peminjaman
                                                        </span>
                                                    @elseif($notification->data['type'] == 'status_pembayaran')
                                                        <span class="badge badge-success">
                                                            <i class="fas fa-credit-card"></i> Pembayaran
                                                        </span>
                                                    @else
                                                        <span class="badge badge-warning">
                                                            <i class="fas fa-undo"></i> Pengembalian
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>{{ $notification->data['title'] }}</td>
                                                <td>{{ $notification->data['message'] }}</td>
                                                <td>{{ $notification->created_at->format('d/m/Y H:i') }}</td>
                                                <td>
                                                    @if($notification->read_at)
                                                        <span class="badge badge-secondary">Dibaca</span>
                                                    @else
                                                        <span class="badge badge-primary">Belum Dibaca</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!$notification->read_at)
                                                        <a href="{{ route('admin.notifications.markAsRead', $notification->id) }}" 
                                                           class="btn btn-sm btn-success" title="Tandai Dibaca">
                                                            <i class="fas fa-check"></i>
                                                        </a>
                                                    @endif
                                                    <form action="{{ route('admin.notifications.destroy', $notification->id) }}" 
                                                          method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                                onclick="return confirm('Yakin ingin menghapus notifikasi ini?')"
                                                                title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">Tidak ada notifikasi</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if($notifications->hasPages())
                            <div class="card-footer">
                                {{ $notifications->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection