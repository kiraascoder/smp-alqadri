<!-- Header -->
<!-- Header (Hanya muncul di Mobile, disembunyikan di Desktop) -->
<header class="fixed top-0 left-0 right-0 z-30 bg-white shadow-md flex items-center justify-between px-4 py-3 lg:hidden">
    <!-- Tombol Hamburger -->
    <button id="hamburger-btn" class="text-blue-900 focus:outline-none">
        <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round"
            stroke-linejoin="round">
            <path d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <!-- Logo -->
    <div class="flex items-center gap-2">
        <span class="text-2xl">🎓</span>
        <span class="text-lg font-semibold text-blue-900">EduPanel</span>
    </div>
</header>


<!-- Sidebar -->
<div id="sidebar"
    class="fixed top-0 left-0 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out w-64 min-h-screen bg-blue-900 text-white flex flex-col justify-between shadow-xl z-40 pt-16">

    @php
        $role = Auth::user()->role;
    @endphp

    {{-- Sidebar Header --}}
    <div class="p-6">
        <div class="text-center border-b border-blue-700 pb-4 mb-4">
            <h1 class="text-xl font-bold tracking-wide">🎓 EduPanel</h1>
            <p class="text-sm mt-2 text-blue-200">Selamat <span class="capitalize">{{ $role }}</span></p>
            <p class="text-sm font-semibold">{{ Auth::user()->name }}</p>
        </div>

        {{-- Navigation --}}
        <ul class="space-y-2 text-sm">
            @if ($role === 'admin')
                @include('components.sidebar-link', [
                    'route' => route('admin.dashboard'),
                    'label' => 'Dashboard',
                    'icon' => 'chart-bar',
                ])
                @include('components.sidebar-link', [
                    'route' => route('admin.bk'),
                    'label' => 'Guru BK',
                    'icon' => 'users',
                ])
                @include('components.sidebar-link', [
                    'route' => route('admin.guru'),
                    'label' => 'Guru',
                    'icon' => 'user-group',
                ])
                @include('components.sidebar-link', [
                    'route' => route('admin.pelanggaran'),
                    'label' => 'Pelanggaran',
                    'icon' => 'exclamation-circle',
                ])
                @include('components.sidebar-link', [
                    'route' => route('admin.riwayat'),
                    'label' => 'Riwayat',
                    'icon' => 'clock',
                ])
                @include('components.sidebar-link', [
                    'route' => route('admin.siswa'),
                    'label' => 'Siswa',
                    'icon' => 'academic-cap',
                ])
            @elseif ($role === 'guru')
                @include('components.sidebar-link', [
                    'route' => route('guru.profil'),
                    'label' => 'Profil',
                    'icon' => 'user',
                ])
                @include('components.sidebar-link', [
                    'route' => route('guru.siswa'),
                    'label' => 'Siswa',
                    'icon' => 'academic-cap',
                ])
                @include('components.sidebar-link', [
                    'route' => route('guru.skorsing'),
                    'label' => 'Skorsing',
                    'icon' => 'ban',
                ])
                @include('components.sidebar-link', [
                    'route' => route('guru.pelanggaran'),
                    'label' => 'Pelanggaran',
                    'icon' => 'exclamation',
                ])
            @elseif ($role === 'guru_bk')
                @include('components.sidebar-link', [
                    'route' => route('bk.dashboard'),
                    'label' => 'Dashboard',
                    'icon' => 'chart-bar',
                ])
                @include('components.sidebar-link', [
                    'route' => route('bk.profil'),
                    'label' => 'Profil',
                    'icon' => 'user',
                ])
                @include('components.sidebar-link', [
                    'route' => route('bk.pelanggaran'),
                    'label' => 'Pelanggaran',
                    'icon' => 'exclamation-circle',
                ])
                @include('components.sidebar-link', [
                    'route' => route('bk.riwayat'),
                    'label' => 'Riwayat',
                    'icon' => 'clock',
                ])
                @include('components.sidebar-link', [
                    'route' => route('bk.skorsing'),
                    'label' => 'Skorsing',
                    'icon' => 'ban',
                ])
                @include('components.sidebar-link', [
                    'route' => route('bk.pengaduan'),
                    'label' => 'Pengaduan',
                    'icon' => 'inbox',
                ])
                @include('components.sidebar-link', [
                    'route' => route('bk.konseling'),
                    'label' => 'Konseling',
                    'icon' => 'chat-alt',
                ])
            @elseif ($role === 'siswa')
                @include('components.sidebar-link', [
                    'route' => route('siswa.profil'),
                    'label' => 'Profil',
                    'icon' => 'user',
                ])
                @include('components.sidebar-link', [
                    'route' => route('siswa.pelanggaran'),
                    'label' => 'Pelanggaran',
                    'icon' => 'exclamation',
                ])
                @include('components.sidebar-link', [
                    'route' => route('siswa.konseling'),
                    'label' => 'Konseling',
                    'icon' => 'chat-alt',
                ])
                @include('components.sidebar-link', [
                    'route' => route('siswa.laporan'),
                    'label' => 'Laporan',
                    'icon' => 'document-report',
                ])
            @endif
        </ul>
    </div>

    {{-- Logout --}}
    <form action="{{ route('logout') }}" method="POST" class="p-6">
        @csrf
        <button type="submit"
            class="w-full flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-red-500 border border-red-500 rounded hover:bg-red-500 hover:text-white transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7" />
            </svg>
            Logout
        </button>
    </form>
</div>

<!-- Script Toggle Sidebar -->
<script>
    const btn = document.getElementById('hamburger-btn');
    const sidebar = document.getElementById('sidebar');

    btn.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
    });
</script>
