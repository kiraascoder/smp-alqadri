<header class="fixed top-0 left-0 right-0 z-50 bg-white shadow flex items-center justify-between px-4 py-3 lg:hidden">
    <button id="hamburger-btn" class="p-2 text-blue-900 rounded-lg hover:bg-blue-50">☰</button>
    <span class="font-bold text-blue-900">SMP AL QADRI</span>
</header>

<div id="sidebar-overlay" class="fixed inset-0 z-40 bg-black/30 hidden lg:hidden"></div>

<aside id="sidebar"
    class="fixed top-0 left-0 z-50 h-full w-64 -translate-x-full lg:translate-x-0 bg-gradient-to-b from-blue-950 to-blue-800 text-white shadow-2xl transition-transform">
    <div class="p-6 border-b border-blue-700">
        <div class="text-3xl mb-2">🎓</div>
        <h1 class="font-bold">SMP AL QADRI</h1>
        <p class="text-sm text-blue-200 mt-2">{{ auth()->user()->name }}</p>
        <p class="text-xs text-blue-300 capitalize">{{ str_replace('_', ' ', auth()->user()->role) }}</p>
    </div>

    @php($role = auth()->user()->role)
    <nav class="p-4 overflow-y-auto h-[calc(100%-190px)]">
        <ul class="space-y-2 text-sm">
            @if ($role === 'admin')
                <li><a class="block px-4 py-3 rounded-lg hover:bg-blue-700 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-700' : '' }}"
                        href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li><a class="block px-4 py-3 rounded-lg hover:bg-blue-700 {{ request()->routeIs('admin.guru*') || request()->routeIs('admin-guru.*') ? 'bg-blue-700' : '' }}"
                        href="{{ route('admin.guru') }}">Guru</a></li>
                <li><a class="block px-4 py-3 rounded-lg hover:bg-blue-700 {{ request()->routeIs('admin.kelas*') ? 'bg-blue-700' : '' }}"
                        href="{{ route('admin.kelas') }}">Kelas</a></li>
                <li><a class="block px-4 py-3 rounded-lg hover:bg-blue-700 {{ request()->routeIs('admin.siswa*') ? 'bg-blue-700' : '' }}"
                        href="{{ route('admin.siswa') }}">Siswa</a></li>
                <li><a class="block px-4 py-3 rounded-lg hover:bg-blue-700 {{ request()->routeIs('admin.orang*') ? 'bg-blue-700' : '' }}"
                        href="{{ route('admin.orang') }}">Orang Tua</a></li>
                <li><a class="block px-4 py-3 rounded-lg hover:bg-blue-700 {{ request()->routeIs('admin.pelanggaran*') ? 'bg-blue-700' : '' }}"
                        href="{{ route('admin.pelanggaran') }}">Jenis Pelanggaran</a></li>
                <li><a class="block px-4 py-3 rounded-lg hover:bg-blue-700 {{ request()->routeIs('admin.skorsing*') ? 'bg-blue-700' : '' }}"
                        href="{{ route('admin.skorsing') }}">Skorsing</a></li>
                <li><a class="block px-4 py-3 rounded-lg hover:bg-blue-700 {{ request()->routeIs('admin.rekap-skorsing') ? 'bg-blue-700' : '' }}"
                        href="{{ route('admin.rekap-skorsing') }}">Rekap Skorsing</a></li>
            @elseif ($role === 'guru')
                <li><a class="block px-4 py-3 rounded-lg hover:bg-blue-700 {{ request()->routeIs('guru.dashboard') ? 'bg-blue-700' : '' }}"
                        href="{{ route('guru.dashboard') }}">Dashboard</a></li>
                <li><a class="block px-4 py-3 rounded-lg hover:bg-blue-700 {{ request()->routeIs('guru.pelanggaran') ? 'bg-blue-700' : '' }}"
                        href="{{ route('guru.pelanggaran') }}">Jenis Pelanggaran</a></li>
                <li><a class="block px-4 py-3 rounded-lg hover:bg-blue-700 {{ request()->routeIs('guru.skorsing*') ? 'bg-blue-700' : '' }}"
                        href="{{ route('guru.skorsing') }}">Skorsing</a></li>
                <li><a class="block px-4 py-3 rounded-lg hover:bg-blue-700 {{ request()->routeIs('guru.profil') ? 'bg-blue-700' : '' }}"
                        href="{{ route('guru.profil') }}">Profil</a></li>
            @elseif ($role === 'orang_tua')
                <li><a class="block px-4 py-3 rounded-lg hover:bg-blue-700 {{ request()->routeIs('ortu.dashboard') ? 'bg-blue-700' : '' }}"
                        href="{{ route('ortu.dashboard') }}">Dashboard</a></li>
                <li><a class="block px-4 py-3 rounded-lg hover:bg-blue-700 {{ request()->routeIs('ortu.pelanggaran') ? 'bg-blue-700' : '' }}"
                        href="{{ route('ortu.pelanggaran') }}">Jenis Pelanggaran</a></li>
            @endif
        </ul>
    </nav>

    <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-blue-700">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button
                class="w-full px-4 py-3 border border-red-300 text-red-200 rounded-lg hover:bg-red-500 hover:text-white">Keluar</button>
        </form>
    </div>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const button = document.getElementById('hamburger-btn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const toggle = () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        };
        button?.addEventListener('click', toggle);
        overlay?.addEventListener('click', toggle);
    });
</script>
