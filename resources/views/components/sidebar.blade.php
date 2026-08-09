@php
    $role = Auth::user()->role;
    $itemClass = 'flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition-colors';
    $inactiveClass = 'text-blue-100 hover:bg-blue-800 hover:text-white';
    $activeClass = 'bg-white text-blue-900 shadow-sm';
@endphp

<header class="fixed inset-x-0 top-0 z-50 flex items-center justify-between border-b border-slate-200 bg-white px-4 py-3 lg:hidden">
    <button id="hamburger-btn" type="button"
        class="rounded-lg p-2 text-blue-900 hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500"
        aria-label="Buka menu">
        <svg id="hamburger-icon" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
        <svg id="close-icon" class="hidden h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>

    <div class="text-right">
        <p class="text-sm font-bold text-blue-950">SMP AL QADRI</p>
        <p class="text-xs text-slate-500">Islamic School</p>
    </div>
</header>

<div id="sidebar-overlay" class="fixed inset-0 z-40 invisible bg-black/40 opacity-0 transition-opacity lg:hidden"></div>

<aside id="sidebar"
    class="fixed inset-y-0 left-0 z-50 flex h-full w-64 -translate-x-full flex-col bg-blue-950 text-white shadow-xl transition-transform duration-300 lg:translate-x-0">

    <div class="border-b border-blue-900 p-6">
        <h1 class="text-lg font-bold tracking-wide">SMP AL QADRI</h1>
        <p class="mt-1 text-xs text-blue-300">Islamic School</p>

        <div class="mt-4 rounded-xl bg-blue-900/70 p-3">
            <p class="truncate text-sm font-semibold text-white">{{ Auth::user()->name }}</p>
            <p class="mt-0.5 text-xs capitalize text-blue-300">{{ str_replace('_', ' ', $role) }}</p>
        </div>
    </div>

    <nav class="flex-1 overflow-y-auto p-4">
        <ul class="space-y-1.5">
            @if ($role === 'admin')
                <li><a href="{{ route('admin.dashboard') }}" class="{{ $itemClass }} {{ request()->routeIs('admin.dashboard') ? $activeClass : $inactiveClass }}">Dashboard</a></li>
                <li><a href="{{ route('admin.bk') }}" class="{{ $itemClass }} {{ request()->routeIs('admin.bk*') ? $activeClass : $inactiveClass }}">Guru BK</a></li>
                <li><a href="{{ route('admin.guru') }}" class="{{ $itemClass }} {{ request()->routeIs('admin.guru*', 'admin-guru.*') ? $activeClass : $inactiveClass }}">Guru</a></li>
                <li><a href="{{ route('admin.siswa') }}" class="{{ $itemClass }} {{ request()->routeIs('admin.siswa*') ? $activeClass : $inactiveClass }}">Siswa</a></li>
                <li><a href="{{ route('admin.orang') }}" class="{{ $itemClass }} {{ request()->routeIs('admin.orang*') ? $activeClass : $inactiveClass }}">Orang Tua</a></li>

                <li class="px-4 pb-1 pt-4 text-[11px] font-semibold uppercase tracking-wider text-blue-400">Kedisiplinan</li>
                <li><a href="{{ route('admin.pelanggaran') }}" class="{{ $itemClass }} {{ request()->routeIs('admin.pelanggaran*', 'admin.tambah.pelanggaran') ? $activeClass : $inactiveClass }}">Jenis Pelanggaran</a></li>
                <li><a href="{{ route('admin.kebajikan') }}" class="{{ $itemClass }} {{ request()->routeIs('admin.kebajikan*') ? $activeClass : $inactiveClass }}">Jenis Kebajikan</a></li>
                <li><a href="{{ route('admin.riwayat') }}" class="{{ $itemClass }} {{ request()->routeIs('admin.riwayat*', 'admin.skorsing.*') ? $activeClass : $inactiveClass }}">Riwayat Skorsing</a></li>
                <li><a href="{{ route('admin.laporan') }}" class="{{ $itemClass }} {{ request()->routeIs('admin.laporan') ? $activeClass : $inactiveClass }}">Laporan</a></li>
                <li><a href="{{ route('admin.pengaduan') }}" class="{{ $itemClass }} {{ request()->routeIs('admin.pengaduan') ? $activeClass : $inactiveClass }}">Pengaduan</a></li>

            @elseif ($role === 'guru')
                <li><a href="{{ route('guru.dashboard') }}" class="{{ $itemClass }} {{ request()->routeIs('guru.dashboard') ? $activeClass : $inactiveClass }}">Dashboard</a></li>
                <li><a href="{{ route('guru.profil') }}" class="{{ $itemClass }} {{ request()->routeIs('guru.profil', 'guru.edit', 'guru.password.update') ? $activeClass : $inactiveClass }}">Profil</a></li>
                <li><a href="{{ route('guru.siswa') }}" class="{{ $itemClass }} {{ request()->routeIs('guru.siswa') ? $activeClass : $inactiveClass }}">Siswa</a></li>

                <li class="px-4 pb-1 pt-4 text-[11px] font-semibold uppercase tracking-wider text-blue-400">Poin Siswa</li>
                <li><a href="{{ route('guru.skorsing') }}" class="{{ $itemClass }} {{ request()->routeIs('guru.skorsing*', 'skorsing.guru') ? $activeClass : $inactiveClass }}">Skorsing / Pelanggaran</a></li>
                <li><a href="{{ route('guru.kebajikan') }}" class="{{ $itemClass }} {{ request()->routeIs('guru.kebajikan*') ? $activeClass : $inactiveClass }}">Poin Kebajikan</a></li>
                <li><a href="{{ route('guru.pelanggaran') }}" class="{{ $itemClass }} {{ request()->routeIs('guru.pelanggaran') ? $activeClass : $inactiveClass }}">Jenis Pelanggaran</a></li>

            @elseif ($role === 'guru_bk')
                <li><a href="{{ route('bk.dashboard') }}" class="{{ $itemClass }} {{ request()->routeIs('bk.dashboard') ? $activeClass : $inactiveClass }}">Dashboard</a></li>
                <li><a href="{{ route('bk.profil') }}" class="{{ $itemClass }} {{ request()->routeIs('bk.profil', 'bk.edit') ? $activeClass : $inactiveClass }}">Profil</a></li>
                <li><a href="{{ route('bk.siswa') }}" class="{{ $itemClass }} {{ request()->routeIs('bk.siswa') ? $activeClass : $inactiveClass }}">Siswa</a></li>
                <li><a href="{{ route('bk.pelanggaran') }}" class="{{ $itemClass }} {{ request()->routeIs('bk.pelanggaran') ? $activeClass : $inactiveClass }}">Pelanggaran</a></li>
                <li><a href="{{ route('bk.skorsing') }}" class="{{ $itemClass }} {{ request()->routeIs('bk.skorsing*', 'bk.riwayat.delete', 'skorsing.tambah-bk') ? $activeClass : $inactiveClass }}">Skorsing</a></li>
                <li><a href="{{ route('bk.riwayat') }}" class="{{ $itemClass }} {{ request()->routeIs('bk.riwayat') ? $activeClass : $inactiveClass }}">Riwayat</a></li>
                <li><a href="{{ route('bk.pengaduan') }}" class="{{ $itemClass }} {{ request()->routeIs('bk.pengaduan') ? $activeClass : $inactiveClass }}">Pengaduan</a></li>
                <li><a href="{{ route('bk.konseling') }}" class="{{ $itemClass }} {{ request()->routeIs('bk.konseling', 'konseling-Bk*', 'guru.konseling.*') ? $activeClass : $inactiveClass }}">Konseling</a></li>

            @elseif ($role === 'siswa')
                <li><a href="{{ route('siswa.dashboard') }}" class="{{ $itemClass }} {{ request()->routeIs('siswa.dashboard') ? $activeClass : $inactiveClass }}">Dashboard</a></li>
                <li><a href="{{ route('siswa.profil') }}" class="{{ $itemClass }} {{ request()->routeIs('siswa.profil', 'siswa.edit') ? $activeClass : $inactiveClass }}">Profil</a></li>
                <li><a href="{{ route('siswa.pelanggaran') }}" class="{{ $itemClass }} {{ request()->routeIs('siswa.pelanggaran', 'pelanggaran.*') ? $activeClass : $inactiveClass }}">Pelanggaran</a></li>
                <li><a href="{{ route('siswa.konseling') }}" class="{{ $itemClass }} {{ request()->routeIs('siswa.konseling', 'konseling.*') ? $activeClass : $inactiveClass }}">Konseling</a></li>
                <li><a href="{{ route('siswa.laporan') }}" class="{{ $itemClass }} {{ request()->routeIs('siswa.laporan', 'laporan.*') ? $activeClass : $inactiveClass }}">Laporan</a></li>

            @elseif ($role === 'orang_tua')
                <li><a href="{{ route('ortu.anak') }}" class="{{ $itemClass }} {{ request()->routeIs('ortu.anak') ? $activeClass : $inactiveClass }}">Anak Saya</a></li>
                <li><a href="{{ route('ortu.pelanggaran') }}" class="{{ $itemClass }} {{ request()->routeIs('ortu.pelanggaran') ? $activeClass : $inactiveClass }}">Pelanggaran</a></li>
            @endif
        </ul>
    </nav>

    <div class="border-t border-blue-900 p-4">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full rounded-xl border border-red-400/60 px-4 py-3 text-sm font-medium text-red-200 transition-colors hover:bg-red-500 hover:text-white">
                Logout
            </button>
        </form>
    </div>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const button = document.getElementById('hamburger-btn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const hamburger = document.getElementById('hamburger-icon');
        const close = document.getElementById('close-icon');

        if (!button || !sidebar || !overlay) return;

        const setOpen = (open) => {
            sidebar.classList.toggle('-translate-x-full', !open);
            overlay.classList.toggle('invisible', !open);
            overlay.classList.toggle('opacity-0', !open);
            overlay.classList.toggle('opacity-100', open);
            hamburger?.classList.toggle('hidden', open);
            close?.classList.toggle('hidden', !open);
            document.body.classList.toggle('overflow-hidden', open && window.innerWidth < 1024);
        };

        button.addEventListener('click', () => setOpen(sidebar.classList.contains('-translate-x-full')));
        overlay.addEventListener('click', () => setOpen(false));

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                setOpen(true);
                document.body.classList.remove('overflow-hidden');
            } else {
                setOpen(false);
            }
        });
    });
</script>

<style>
    [x-cloak] { display: none !important; }
</style>
