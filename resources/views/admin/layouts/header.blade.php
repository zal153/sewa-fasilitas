<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown" id="notification-dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" id="notification-bell">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge" id="notification-count">
                    {{ auth()->user()->unreadNotifications->count() }}
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="notification-menu">
                <span class="dropdown-item dropdown-header">
                    <span id="notification-header">{{ auth()->user()->unreadNotifications->count() }} Notifikasi</span>
                    <a href="{{ route('admin.notifications.markAllAsRead') }}" class="float-right text-sm text-primary">Tandai Semua Dibaca</a>
                </span>
                <div class="dropdown-divider"></div>
                <div id="notification-list">
                    @forelse(auth()->user()->notifications->take(5) as $notification)
                        <a href="{{ route('admin.notifications.markAsRead', $notification->id) }}" 
                           class="dropdown-item {{ $notification->read_at ? '' : 'bg-light' }}">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    @if($notification->data['type'] == 'status_peminjaman')
                                        <i class="fas fa-clipboard-list mr-2 text-info"></i>
                                    @elseif($notification->data['type'] == 'status_pembayaran')
                                        <i class="fas fa-credit-card mr-2 text-success"></i>
                                    @else
                                        <i class="fas fa-undo mr-2 text-warning"></i>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <strong>{{ $notification->data['title'] }}</strong><br>
                                    <small>{{ $notification->data['message'] }}</small><br>
                                    <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                    @empty
                        <span class="dropdown-item text-center text-muted">Tidak ada notifikasi</span>
                    @endforelse
                </div>
                <a href="{{ route('admin.notifications.index') }}" class="dropdown-item dropdown-footer">Lihat Semua Notifikasi</a>
            </div>
        </li>
        
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-user"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                <span class="dropdown-item dropdown-header">{{ auth()->user()->name }}</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-user mr-2"></i> Profile
                    <span class="float-right text-muted text-sm">Settings</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="dropdown-item">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    <span class="float-right text-muted text-sm">Logout</span>
                </a>
                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>

<script>
// Auto refresh notification count setiap 30 detik
setInterval(function() {
    fetch('{{ route("admin.notifications.unreadCount") }}')
        .then(response => response.json())
        .then(data => {
            document.getElementById('notification-count').textContent = data.count;
            document.getElementById('notification-header').textContent = data.count + ' Notifikasi';
            
            if (data.count > 0) {
                document.getElementById('notification-count').style.display = 'inline';
            } else {
                document.getElementById('notification-count').style.display = 'none';
            }
        });
}, 30000);
</script>