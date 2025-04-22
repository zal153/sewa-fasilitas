<nav class="navbar-vertical navbar">
    <div id="myScrollableElement" class="h-screen" data-simplebar>
        <!-- brand logo -->
        <a class="navbar-brand" href="index.html">
            <img src="{{ asset('') }}asset/images/brand/logo/logo.svg" alt="" />
        </a>

        <!-- navbar nav -->
        <ul class="navbar-nav flex-col" id="sideNavbar">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('mahasiswa.dashboard') }}" data-bs-target="#navDashboard"
                    aria-expanded="false" aria-controls="navDashboard">
                    <i data-feather="home" class="w-4 h-4 mr-2"></i>
                    Dashboard
                </a>
            </li>
            <!-- nav item -->
            <li class="nav-item">
                <div class="navbar-heading">Menu</div>
            </li>

            <!-- nav item -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('mahasiswa.peminjaman') }}" data-bs-target="#navEcommerce"
                    aria-expanded="false" aria-controls="navPages">
                    <i data-feather="layers" class="w-4 h-4 mr-2"></i>
                    Fasilitas
                </a>
            </li>
            <!-- Nav item -->
            <li class="nav-item">
                <a class="nav-link" href="chat.html">
                    <i data-feather="message-square" class="w-4 h-4 mr-2"></i>
                    Notifikasi
                </a>
            </li>
            <!-- Nav item -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#!" data-bs-target="#navEmail" aria-expanded="false"
                    aria-controls="navEmail">
                    <i data-feather="mail" class="w-4 h-4 mr-2"></i>
                    Riwayat Peminjaman
                </a>
            </li>
            <!-- Nav item -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#!" data-bs-target="#navKanban" aria-expanded="false"
                    aria-controls="navKanban">
                    <i data-feather="user" class="w-4 h-4 mr-2"></i>
                    Profil Saya
                </a>
            </li>
            <!-- nav heading -->
            <li class="nav-item">
                <a class="nav-link" href="#"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i data-feather="log-out" class="w-4 h-4 mr-2"></i>
                    Logout
                </a>
                <form id="logout-form" action="#" method="POST" class="hidden">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</nav>
