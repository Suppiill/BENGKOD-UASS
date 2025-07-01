<aside class="main-sidebar {{ config('adminlte.classes_sidebar', 'sidebar-dark-primary elevation-4') }}">

    {{-- Sidebar brand logo --}}
<a href="{{ url('/') }}" class="brand-link">
    <i class="fas fa-clinic-medical fa-lg mx-3"></i>
    <span class="brand-text font-weight-light">Klinik XYZ</span>
</a>
{{-- Sidebar User Panel --}}
<div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
    <div class="image">
        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0d6efd&color=fff&size=100"
             class="img-circle elevation-2" alt="User Image">
    </div>
    <div class="info">
        <a href="{{ route('dokter.profil') }}" class="d-block text-white fw-semibold">
            {{ Auth::user()->name }}
        </a>
        <small class="text-muted d-block">{{ ucfirst(Auth::user()->role) }}</small>
    </div>
</div>

    {{-- Sidebar menu --}}
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                
                {{-- Menu untuk Admin (Tidak diubah) --}}
                @if (Auth::user()->role == 'admin')

                    <li class="nav-header">MENU ADMINISTRATOR</li>
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.dokter.index') }}" class="nav-link {{ request()->routeIs('admin.dokter.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-md"></i>
                            <p>Dokter</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.pasien.index') }}" class="nav-link {{ request()->routeIs('admin.pasien.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-injured"></i>
                            <p>Pasien</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.poli.index') }}" class="nav-link {{ request()->routeIs('admin.poli.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-hospital"></i>
                            <p>Poli</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.obat.index') }}" class="nav-link {{ request()->routeIs('admin.obat.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-pills"></i>
                            <p>Obat</p>
                        </a>
                    </li>

                {{-- Menu untuk Dokter (INI YANG KITA SESUAIKAN) --}}
                @elseif (Auth::user()->role == 'dokter')
                    
                    <li class="nav-header">MENU DOKTER</li>
                    <li class="nav-item">
                        <a href="{{ route('dokter.dashboard') }}" class="nav-link {{ request()->routeIs('dokter.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dokter.jadwal-periksa.index') }}" class="nav-link {{ request()->routeIs('dokter.jadwal-periksa.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-calendar-alt"></i>
                            <p>Jadwal Periksa</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dokter.periksa.index') }}" class="nav-link {{ request()->routeIs('dokter.periksa.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-stethoscope"></i>
                            <p>Memeriksa Pasien</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        {{-- =============================================== --}}
                        {{-- == INI BAGIAN YANG DIPERBAIKI == --}}
                        <a href="{{ route('dokter.riwayat.index') }}" class="nav-link {{ request()->routeIs('dokter.riwayat.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-history"></i>
                            <p>Riwayat Pasien</p>
                        </a>
                        {{-- =============================================== --}}
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dokter.profil') }}" class="nav-link {{ request()->routeIs('dokter.profil') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-circle"></i>
                            <p>Profil</p>
                        </a>
                    </li>

                {{-- Menu untuk Pasien (Tidak diubah) --}}
                @elseif (Auth::user()->role == 'pasien')
                    
                    <li class="nav-header">MENU PASIEN</li>
                    <li class="nav-item">
                        <a href="{{ route('pasien.dashboard') }}" class="nav-link {{ request()->routeIs('pasien.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard Saya</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('pasien.poli.daftar') }}" class="nav-link {{ request()->routeIs('pasien.poli.daftar') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-notes-medical"></i>
                            <p>Daftar Poli</p>
                        </a>
                    </li>
                @endif
                {{-- Akhir dari blok if/elseif --}}
            
            </ul>
        </nav>
    </div>

</aside>
