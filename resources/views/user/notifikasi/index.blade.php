@extends('user.layouts.template')
@section('title', 'Notifikasi')

@section('contentUser')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Notifikasi</h5>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-outline-primary" onclick="markAllAsRead()">
                                <i class="bx bx-check-double"></i> Tandai Semua Dibaca
                            </button>
                            <button class="btn btn-sm btn-outline-danger" onclick="deleteSelected()" id="delete-selected"
                                style="display: none;">
                                <i class="bx bx-trash"></i> Hapus Terpilih
                            </button>
                        </div>
                    </div>

                    <!-- Stats Cards -->
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="card bg-primary text-white">
                                    <div class="card-body text-center">
                                        <h4 class="card-title">{{ $stats['total'] }}</h4>
                                        <p class="card-text">Total Notifikasi</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-warning text-white">
                                    <div class="card-body text-center">
                                        <h4 class="card-title">{{ $stats['unread'] }}</h4>
                                        <p class="card-text">Belum Dibaca</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-success text-white">
                                    <div class="card-body text-center">
                                        <h4 class="card-title">{{ $stats['read'] }}</h4>
                                        <p class="card-text">Sudah Dibaca</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Filters -->
                        <form method="GET" class="row mb-4">
                            <div class="col-md-3">
                                <select name="status" class="form-select">
                                    <option value="">Semua Status</option>
                                    <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>Belum
                                        Dibaca</option>
                                    <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Sudah Dibaca
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="type" class="form-select">
                                    <option value="">Semua Tipe</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type['value'] }}"
                                            {{ request('type') == $type['value'] ? 'selected' : '' }}>
                                            {{ $type['label'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="Cari notifikasi..."
                                    value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bx bx-search"></i> Filter
                                </button>
                            </div>
                        </form>

                        <!-- Notifications List -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th width="50">
                                            <input type="checkbox" id="select-all" class="form-check-input">
                                        </th>
                                        <th>Notifikasi</th>
                                        <th width="150">Tanggal</th>
                                        <th width="100">Status</th>
                                        <th width="100">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($notifications as $notification)
                                        @php
                                            $data = $notification->data;
                                            $type = $data['type'] ?? class_basename($notification->type);
                                        @endphp
                                        <tr class="{{ $notification->read_at ? '' : 'table-warning' }}">
                                            <td>
                                                <input type="checkbox" class="form-check-input notification-checkbox"
                                                    value="{{ $notification->id }}">
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-shrink-0 me-2">
                                                        <i class="{{ getNotificationIcon($type) }} text-primary fs-4"></i>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1 {{ $notification->read_at ? '' : 'fw-bold' }}">
                                                            {{ $data['title'] ?? 'Notifikasi' }}
                                                        </h6>
                                                        <p class="mb-0 text-muted">
                                                            {{ $data['message'] ?? 'Pesan notifikasi' }}</p>
                                                        @if (isset($data['data']['kode_peminjaman']))
                                                            <small class="text-info">
                                                                Kode: {{ $data['data']['kode_peminjaman'] }}
                                                            </small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ $notification->created_at->format('d/m/Y H:i') }}<br>
                                                    <em>{{ $notification->created_at->diffForHumans() }}</em>
                                                </small>
                                            </td>
                                            <td>
                                                @if ($notification->read_at)
                                                    <span class="badge bg-success">Dibaca</span>
                                                @else
                                                    <span class="badge bg-warning">Belum Dibaca</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                        data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        @if (!$notification->read_at)
                                                            <li>
                                                                <a class="dropdown-item" href="#"
                                                                    onclick="markAsRead('{{ $notification->id }}')">
                                                                    <i class="bx bx-check me-2"></i>Tandai Dibaca
                                                                </a>
                                                            </li>
                                                        @endif
                                                        <li>
                                                            <a class="dropdown-item text-danger" href="#"
                                                                onclick="deleteNotification('{{ $notification->id }}')">
                                                                <i class="bx bx-trash me-2"></i>Hapus
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4">
                                                <i class="bx bx-bell-off fs-1 text-muted"></i><br>
                                                <span class="text-muted">Tidak ada notifikasi</span>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $notifications->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        function getNotificationIcon($type)
        {
            switch ($type) {
                case 'peminjaman_disetujui':
                case 'PeminjamanDisetujuiNotification':
                    return 'bx bx-check-circle';
                case 'pembayaran_disetujui':
                case 'PembayaranDisetujuiNotification':
                    return 'bx bx-dollar-circle';
                default:
                    return 'bx bx-bell';
            }
        }
    @endphp
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#select-all').change(function() {
                $('.notification-checkbox').prop('checked', this.checked);
                toggleDeleteButton();
            });

            $('.notification-checkbox').change(function() {
                toggleDeleteButton();
            });

            function toggleDeleteButton() {
                const checkedCount = $('.notification-checkbox:checked').length;
                if (checkedCount > 0) {
                    $('#delete-selected').show();
                } else {
                    $('#delete-selected').hide();
                }
            }
        });

        function markAsRead(id) {
            $.post(`/notifications/${id}/read`, {
                _token: '{{ csrf_token() }}'
            }, function(data) {
                if (data.success) {
                    location.reload();
                }
            });
        }

        function markAllAsRead() {
            $.post('{{ route('notifications.mark-all-read') }}', {
                _token: '{{ csrf_token() }}'
            }, function(data) {
                if (data.success) {
                    location.reload();
                }
            });
        }

        function deleteNotification(id) {
            if (confirm('Yakin ingin menghapus notifikasi ini?')) {
                $.post(`/notifications/${id}/delete`, {
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE'
                }, function(data) {
                    location.reload();
                });
            }
        }

        function deleteSelected() {
            const selected = $('.notification-checkbox:checked').map(function() {
                return this.value;
            }).get();

            if (selected.length === 0) {
                alert('Pilih notifikasi yang ingin dihapus');
                return;
            }

            if (confirm(`Yakin ingin menghapus ${selected.length} notifikasi?`)) {
                $.post('{{ route('notifications.bulk-delete') }}', {
                    _token: '{{ csrf_token() }}',
                    ids: selected
                }, function(data) {
                    location.reload();
                });
            }
        }
    </script>
@endpush
