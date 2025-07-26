<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="#" class="app-brand-link">
            <img src="{{ asset('asset/img/layouts/uniba-madura.png') }}" alt="Logo UNIBA Madura" height="30"
                style="width: 200px; height: auto;">
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Dashboard</span>
        </li>
        <!-- Dashboard -->
        @if (auth()->user()->role == 'mahasiswa')
            <li class="menu-item">
                <a href="{{ route('mahasiswa.dashboard') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home"></i>
                    <div data-i18n="Dashboard">Dashboard</div>
                </a>
            </li>

            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Pages</span>
            </li>

            <li class="menu-item">
                <a href="{{ route('notifications.page') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-bell"></i>
                    <div data-i18n="Notifikasi">Notifikasi</div>
                    @if (auth()->user()->notifications()->unread()->count() > 0)
                        <span
                            class="badge bg-danger ms-2">{{ auth()->user()->notifications()->unread()->count() }}</span>
                    @endif
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('mahasiswa.peminjaman') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-key"></i>
                    <div data-i18n="Fasilitas">Fasilitas</div>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('mahasiswa.riwayat') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-history"></i>
                    <div data-i18n="Riwayat Peminjaman">Riwayat Peminjaman</div>
                </a>
            </li>

            <li class="menu-item">
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="menu-link">
                    <i class="menu-icon tf-icons bx bx-log-out"></i>
                    <div data-i18n="Log Out">Log Out</div>
                </a>
                <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        @endif

        @if (auth()->user()->role == 'non_mahasiswa')
            <li class="menu-item">
                <a href="{{ route('non_mahasiswa.dashboard') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home"></i>
                    <div data-i18n="Dashboard">Dashboard</div>
                </a>
            </li>

            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Pages</span>
            </li>

            <li class="menu-item">
                <a href="{{ route('notifications.page') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-bell"></i>
                    <div data-i18n="Notifikasi">Notifikasi</div>
                    @if (auth()->user()->notifications()->unread()->count() > 0)
                        <span
                            class="badge bg-danger ms-2">{{ auth()->user()->notifications()->unread()->count() }}</span>
                    @endif
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('non_mahasiswa.peminjaman') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-key"></i>
                    <div data-i18n="Fasilitas">Fasilitas</div>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('non_mahasiswa.pembayaran') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-credit-card"></i>
                    <div data-i18n="Pembayaran">Pembayaran</div>
                </a>
            </li>

            <li class="menu-item">
                <a href="{{ route('non_mahasiswa.riwayat') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-history"></i>
                    <div data-i18n="Riwayat Peminjaman">Riwayat Peminjaman</div>
                </a>
            </li>

            <li class="menu-item">
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="menu-link">
                    <i class="menu-icon tf-icons bx bx-log-out"></i>
                    <div data-i18n="Log Out">Log Out</div>
                </a>
                <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        @endif
    </ul>
</aside>
