<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <li class="nav-header" style="margin-top: -10px;">MENU UTAMA</li>

        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}"
               class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.article.index') }}"
               class="nav-link {{ request()->routeIs('admin.article.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-newspaper"></i>
                <p>Artikel Berita</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.campaign.index') }}"
               class="nav-link {{ request()->routeIs('admin.campaign.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-th-list"></i>
                <p>Penggalangan</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.donation') }}"
               class="nav-link {{ request()->routeIs('admin.donation') ? 'active' : '' }}">
                <i class="nav-icon fas fa-users"></i>
                <p>Daftar Donasi</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.withdrawal.index') }}"
               class="nav-link {{ request()->routeIs('admin.withdrawal.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-money-bill-wave"></i>
                <p>Penarikan Dana</p>
            </a>
        </li>

       <li class="nav-item">
            <a href="{{ route('admin.report.index') }}"
                class="nav-link {{ request()->routeIs('admin.report.*') ? 'active' : '' }}">
                 <i class="nav-icon fas fa-file-pdf"></i>
                 <p>Laporan Donasi</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.contact.index') }}"
               class="nav-link {{ request()->routeIs('admin.contact.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-inbox"></i>
                <p>Kontak</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ url('/') }}" target="_blank" class="nav-link">
                <i class="nav-icon fas fa-globe"></i>
                <p>Lihat Website</p>
            </a>
        </li>

        <li class="nav-header">LAINNYA</li>

        <li class="nav-item">
            <a href="#" class="nav-link" id="logout">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>Logout</p>
            </a>
        </li>

    </ul>
</nav>