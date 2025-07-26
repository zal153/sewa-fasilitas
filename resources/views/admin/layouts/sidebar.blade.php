<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <p>
        {{-- <img src="{{ asset('assets/images/download.jpeg') }}" alt="Logo UNIBA" class="elevation-3"
            style="height: 100px; opacity: 0.9;" /> --}}
        <span class="brand-text font-weight-light"></span>
    </p>

    <!-- Sidebar -->
    <nav class="mt-2">
        <div class="sidebar">
            <!-- User Panel -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ asset('assets/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                        alt="User Image">
                </div>
                <div class="info">
                    <span class="d-block text-white">{{ auth()->user()->name }}</span>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.notifications.index') }}"
                        class="nav-link {{ request()->routeIs('admin.notifications.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-bell"></i>
                        <p>
                            Notifikasi
                            @if (auth()->user()->unreadNotifications->count() > 0)
                                <span
                                    class="badge badge-warning right">{{ auth()->user()->unreadNotifications->count() }}</span>
                            @endif
                        </p>
                    </a>
                </li>

                <!-- Data Master -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-database"></i>
                        <p>
                            Data Master
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('mahasiswa') }}" class="nav-link">
                                <i class="far fa-user nav-icon"></i>
                                <p>Mahasiswa</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('eksternal') }}" class="nav-link">
                                <i class="far fa-user-circle nav-icon"></i>
                                <p>Eksternal</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Kelola Fasilitas -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cubes"></i>
                        <p>
                            Kelola Fasilitas
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('fasilitas') }}" class="nav-link">
                                <i class="fas fa-building nav-icon"></i>
                                <p>Fasilitas</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('jadwal') }}" class="nav-link">
                                <i class="far fa-calendar-alt nav-icon"></i>
                                <p>Jadwal Fasilitas</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Peminjaman -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Peminjaman
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('peminjaman') }}" class="nav-link">
                                <i class="fas fa-hand-holding nav-icon"></i>
                                <p>Peminjaman</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('riwayat') }}" class="nav-link">
                                <i class="fas fa-history nav-icon"></i>
                                <p>Riwayat Peminjaman</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('pembayaran') }}" class="nav-link">
                                <i class="fas fa-receipt nav-icon"></i>
                                <p>Riwayat Pembayaran</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Operator -->
                <li class="nav-item">
                    <a href="{{ route('operator') }}" class="nav-link">
                        <i class="nav-icon fas fa-user-shield"></i>
                        <p>Operator</p>
                    </a>
                </li>

                <!-- Logout -->
                <li class="nav-item">
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>

            </ul>
        </div>
    </nav>
</aside>
