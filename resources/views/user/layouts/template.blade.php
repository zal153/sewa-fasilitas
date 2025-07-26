<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('asset/') }}" data-template="vertical-menu-template-free">

<head>
    @include('user.layouts.style')

    <style>
        .badge-notification {
            position: absolute;
            top: -5px;
            right: -5px;
            font-size: 0.7rem;
            min-width: 18px;
            height: 18px;
            border-radius: 50%;
        }

        .notification-dropdown {
            box-shadow: 0 0.25rem 1rem rgba(161, 172, 184, 0.45);
        }

        .notification-item:not(.bg-light) {
            opacity: 0.7;
        }

        .notification-item.bg-light {
            background-color: #f8f9fa !important;
        }

        .dropdown-header {
            padding: 1rem;
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }

        .dropdown-footer {
            padding: 0.5rem 1rem;
            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;
        }
    </style>

    @stack('style')
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            @include('user.layouts.sidebar')
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="bx bx-menu bx-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <!-- Search -->
                        <div class="navbar-nav align-items-center">
                            <div class="nav-item d-flex align-items-center">
                                <i class="bx bx-search fs-4 lh-0"></i>
                                <input type="text" class="form-control border-0 shadow-none" placeholder="Search..."
                                    aria-label="Search..." />
                            </div>
                        </div>
                        <!-- /Search -->

                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <!-- Place this tag where you want the button to render. -->
                            <!-- Notification Bell -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow position-relative"
                                    href="javascript:void(0);" data-bs-toggle="dropdown">
                                    <i class="bx bx-bell bx-sm"></i>
                                    <span class="badge bg-danger badge-notification" id="notification-count"
                                        style="display: none;">0</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end notification-dropdown"
                                    style="width: 350px; max-height: 400px; overflow-y: auto;">
                                    <li class="dropdown-header d-flex justify-content-between align-items-center">
                                        <span class="fw-semibold">Notifikasi</span>
                                        <button class="btn btn-sm btn-outline-primary" id="mark-all-read">Tandai Semua
                                            Dibaca</button>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <div id="notification-list">
                                        <li class="text-center p-3">
                                            <small class="text-muted">Memuat notifikasi...</small>
                                        </li>
                                    </div>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li class="dropdown-footer text-center">
                                        <a href="{{ route('notifications.page') }}" class="text-primary">Lihat Semua Notifikasi</a>
                                    </li>
                                </ul>
                            </li>

                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="{{ asset('asset/img/avatars/1.png') }}" alt
                                            class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img src="{{ asset('asset/img/avatars/1.png') }}" alt
                                                            class="w-px-40 h-auto rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span class="fw-semibold d-block">{{ auth()->user()->name }}</span>
                                                    <small class="text-muted">{{ auth()->user()->role }}</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    {{-- <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="bx bx-user me-2"></i>
                                            <span class="align-middle">My Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="bx bx-cog me-2"></i>
                                            <span class="align-middle">Settings</span>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li> --}}
                                    <li>
                                        <a class="dropdown-item" href="#"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="bx bx-power-off me-2"></i>
                                            <span class="align-middle">Log Out</span>
                                        </a>
                                        <form id="logout-form" action="{{ route('user.logout') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>
                </nav>

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    @yield('contentUser')
                    <!-- / Content -->

                    <!-- Footer -->
                    @include('user.layouts.footer')
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    @include('user.layouts.script')

    <script>
        $(document).ready(function() {
            let isNotificationOpen = false;

            // Load notification count
            function loadNotificationCount() {
                $.get('{{ route('notifications.count') }}', function(data) {
                    if (data.count > 0) {
                        $('#notification-count').text(data.count).show();
                    } else {
                        $('#notification-count').hide();
                    }
                });
            }

            // Load notifications
            function loadNotifications() {
                $.get('{{ route('notifications.index') }}', function(data) {
                    let html = '';

                    if (data.length === 0) {
                        html =
                            '<li class="text-center p-3"><small class="text-muted">Tidak ada notifikasi</small></li>';
                    } else {
                        data.forEach(function(notification) {
                            const isRead = notification.read_at !== null;
                            const bgClass = isRead ? '' : 'bg-light';
                            const icon = getNotificationIcon(notification.type);

                            html += `
                                <li class="notification-item ${bgClass}" data-id="${notification.id}">
                                    <a class="dropdown-item d-flex align-items-start p-3" href="#" onclick="markAsRead(${notification.id})">
                                        <div class="flex-shrink-0 me-2">
                                            <i class="${icon} text-primary"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="fw-semibold">${notification.title}</div>
                                            <small class="text-muted">${notification.message}</small>
                                            <div class="text-muted" style="font-size: 0.75rem;">${notification.time_ago}</div>
                                        </div>
                                        ${!isRead ? '<div class="flex-shrink-0"><span class="badge bg-primary rounded-pill">Baru</span></div>' : ''}
                                    </a>
                                </li>
                            `;
                        });
                    }

                    $('#notification-list').html(html);
                });
            }

            function getNotificationIcon(type) {
                switch (type) {
                    case 'peminjaman_disetujui':
                        return 'bx bx-check-circle';
                    case 'pembayaran_disetujui':
                        return 'bx bx-dollar-circle';
                    default:
                        return 'bx bx-bell';
                }
            }

            // Mark notification as read
            window.markAsRead = function(id) {
                $.post(`{{ url('notifications') }}/${id}/read`, {
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    if (data.success) {
                        loadNotificationCount();
                        loadNotifications();
                    }
                });
            }

            // Mark all as read
            $('#mark-all-read').click(function() {
                $.post('{{ route('notifications.mark-all-read') }}', {
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    if (data.success) {
                        loadNotificationCount();
                        loadNotifications();
                    }
                });
            });

            // Load on dropdown open
            $('.dropdown-user').on('show.bs.dropdown', function() {
                if (!isNotificationOpen) {
                    loadNotifications();
                    isNotificationOpen = true;
                }
            });

            // Initial load
            loadNotificationCount();

            // Auto refresh every 30 seconds
            setInterval(function() {
                loadNotificationCount();
                if (isNotificationOpen) {
                    loadNotifications();
                }
            }, 30000);
        });
    </script>

    @stack('script')
</body>

</html>
