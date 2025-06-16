<header class="fixed top-0 left-0 right-0 z-50 bg-white shadow-lg flex items-center justify-between px-4 py-3 lg:hidden">
    <!-- Hamburger Button -->
    <button id="hamburger-btn"
        class="p-2 text-blue-900 hover:bg-blue-50 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500">
        <svg id="hamburger-icon" class="h-6 w-6 transition-transform duration-300" fill="none" stroke="currentColor"
            stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
        <svg id="close-icon" class="h-6 w-6 hidden transition-transform duration-300" fill="none"
            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>

    <!-- Logo -->
    <div class="flex items-center gap-2">
        <span class="text-2xl">🎓</span>
        <span class="text-lg font-bold text-blue-900">EduPanel</span>
    </div>
</header>

<!-- Sidebar Overlay (Mobile Only) -->
<div id="sidebar-overlay" class="fixed inset-0  z-40 lg:hidden opacity-0 invisible transition-opacity duration-300">
</div>

<!-- Sidebar -->
<aside id="sidebar"
    class="fixed top-0 left-0 w-64 h-full bg-gradient-to-b from-blue-900 to-blue-800 text-white shadow-2xl z-50 transform transition-transform duration-300 -translate-x-full lg:translate-x-0">
    <!-- Sidebar Header -->
    <div class="p-6 border-b border-blue-700">
        <div class="text-center">
            <div class="mb-3">
                <span class="text-3xl">🎓</span>
            </div>
            <h1 class="text-xl font-bold tracking-wide mb-2">EduPanel</h1>
            <div class="bg-blue-800 rounded-lg p-3">
                <p class="text-sm text-blue-200">Selamat datang</p>
                <p class="text-xs text-blue-300 mt-1 capitalize">{{ Auth::user()->role }}</p>
            </div>
        </div>
    </div>

    @php
        $role = Auth::user()->role;
    @endphp
    <!-- Navigation Menu -->
    <nav class="flex-1 p-4 overflow-y-auto">
        <ul class="space-y-2">
            <!-- Admin Menu Items -->
            @if ($role === 'admin')
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-800 transition-colors group">
                        <!-- Dashboard Icon -->
                        <svg class="w-5 h-5 text-blue-300 group-hover:text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <span class="text-sm font-medium">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.bk') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-800 transition-colors group">
                        <!-- Guru BK/Counseling Icon -->
                        <svg class="w-5 h-5 text-blue-300 group-hover:text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <span class="text-sm font-medium">Guru BK</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.guru') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-800 transition-colors group">
                        <!-- Teacher Icon -->
                        <svg class="w-5 h-5 text-blue-300 group-hover:text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <span class="text-sm font-medium">Guru</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.pelanggaran') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-800 transition-colors group">
                        <!-- Warning/Violation Icon -->
                        <svg class="w-5 h-5 text-blue-300 group-hover:text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.314 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                        <span class="text-sm font-medium">Pelanggaran</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.riwayat') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-800 transition-colors group">
                        <!-- History/Clock Icon -->
                        <svg class="w-5 h-5 text-blue-300 group-hover:text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm font-medium">Riwayat</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.siswa') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-800 transition-colors group">
                        <!-- Students Icon -->
                        <svg class="w-5 h-5 text-blue-300 group-hover:text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                        <span class="text-sm font-medium">Siswa</span>
                    </a>
                </li>
            @elseif($role === 'guru')
                <li>
                    <a href="{{ route('guru.profil') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-800 transition-colors group">
                        <!-- Profile Icon -->
                        <svg class="w-5 h-5 text-blue-300 group-hover:text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="text-sm font-medium">Profil</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('guru.siswa') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-800 transition-colors group">
                        <!-- Students Icon -->
                        <svg class="w-5 h-5 text-blue-300 group-hover:text-white" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                        <span class="text-sm font-medium">Siswa</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('guru.skorsing') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-800 transition-colors group">
                        <!-- Suspension/Ban Icon -->
                        <svg class="w-5 h-5 text-blue-300 group-hover:text-white" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728" />
                        </svg>
                        <span class="text-sm font-medium">Skorsing</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('guru.pelanggaran') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-800 transition-colors group">
                        <!-- Warning/Violation Icon -->
                        <svg class="w-5 h-5 text-blue-300 group-hover:text-white" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.314 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                        <span class="text-sm font-medium">Pelanggaran</span>
                    </a>
                </li>
            @elseif($role === 'guru_bk')
                <li>
                    <a href="{{ route('bk.profil') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-800 transition-colors group">
                        <!-- Profile Icon -->
                        <svg class="w-5 h-5 text-blue-300 group-hover:text-white" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="text-sm font-medium">Profil</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('bk.pelanggaran') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-800 transition-colors group">
                        <!-- Warning/Violation Icon -->
                        <svg class="w-5 h-5 text-blue-300 group-hover:text-white" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.314 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                        <span class="text-sm font-medium">Pelanggaran</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('bk.skorsing') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-800 transition-colors group">
                        <!-- Suspension/Ban Icon -->
                        <svg class="w-5 h-5 text-blue-300 group-hover:text-white" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728" />
                        </svg>
                        <span class="text-sm font-medium">Skorsing</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('bk.pengaduan') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-800 transition-colors group">
                        <!-- Report/Complaint Icon -->
                        <svg class="w-5 h-5 text-blue-300 group-hover:text-white" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span class="text-sm font-medium">Pengaduan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('bk.konseling') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-800 transition-colors group">
                        <!-- Counseling/Chat Icon -->
                        <svg class="w-5 h-5 text-blue-300 group-hover:text-white" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <span class="text-sm font-medium">Konseling</span>
                    </a>
                </li>
            @elseif($role === 'siswa')
                <li>
                    <a href="{{ route('siswa.profil') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-800 transition-colors group">
                        <!-- Profile Icon -->
                        <svg class="w-5 h-5 text-blue-300 group-hover:text-white" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="text-sm font-medium">Profil</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('siswa.pelanggaran') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-800 transition-colors group">
                        <!-- Warning/Violation Icon -->
                        <svg class="w-5 h-5 text-blue-300 group-hover:text-white" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.314 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                        <span class="text-sm font-medium">Pelanggaran</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('siswa.konseling') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-800 transition-colors group">
                        <!-- Counseling/Chat Icon -->
                        <svg class="w-5 h-5 text-blue-300 group-hover:text-white" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <span class="text-sm font-medium">Konseling</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('siswa.laporan') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-blue-800 transition-colors group">
                        <!-- Report/Document Icon -->
                        <svg class="w-5 h-5 text-blue-300 group-hover:text-white" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span class="text-sm font-medium">Laporan</span>
                    </a>
                </li>
            @endif
        </ul>
    </nav>


    <div class="p-6 border-t border-blue-700">
        <form method="POST" action="{{ route('logout') }}">
            @csrf            
            <button type="submit"
                class="w-full flex items-center justify-center gap-2 px-4 py-3 text-sm font-medium text-red-400 border border-red-400 rounded-lg hover:bg-red-500 hover:text-white hover:border-red-500 transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m10.5 0V5a2 2 0 00-2-2H6a2 2 0 00-2 2v14a2 2 0 002 2h9.5" />
                </svg>
                Logout
            </button>
        </form>
    </div>
</aside>
<script>
    function toggleSidebar() {
        const isOpen = sidebar.classList.contains('translate-x-0');

        if (isOpen) {
            sidebar.classList.remove('translate-x-0');
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('opacity-0', 'invisible');
            sidebarOverlay.classList.remove('opacity-100');
            hamburgerIcon.classList.remove('hidden');
            closeIcon.classList.add('hidden');
            body.classList.remove('no-scroll');
        } else {
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');
            sidebarOverlay.classList.remove('opacity-0', 'invisible');
            sidebarOverlay.classList.add('opacity-100');
            hamburgerIcon.classList.add('hidden');
            closeIcon.classList.remove('hidden');
            body.classList.add('no-scroll');
        }
    }
    document.addEventListener("DOMContentLoaded", function() {
        const hamburgerBtn = document.getElementById('hamburger-btn');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');
        const hamburgerIcon = document.getElementById('hamburger-icon');
        const closeIcon = document.getElementById('close-icon');
        const body = document.body;

        function toggleSidebar() {
            const isOpen = !sidebar.classList.contains('-translate-x-full');

            if (isOpen) {
                sidebar.classList.add('-translate-x-full');
                sidebarOverlay.classList.add('opacity-0', 'invisible');
                sidebarOverlay.classList.remove('opacity-100');
                hamburgerIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
                body.classList.remove('no-scroll');
            } else {
                sidebar.classList.remove('-translate-x-full');
                sidebarOverlay.classList.remove('opacity-0', 'invisible');
                sidebarOverlay.classList.add('opacity-100');
                hamburgerIcon.classList.add('hidden');
                closeIcon.classList.remove('hidden');
                body.classList.add('no-scroll');
            }
        }

        hamburgerBtn.addEventListener('click', toggleSidebar);
        sidebarOverlay.addEventListener('click', toggleSidebar);
        document.addEventListener('click', (e) => {
            if (window.innerWidth < 1024) {
                if (!sidebar.contains(e.target) && !hamburgerBtn.contains(e.target)) {
                    if (!sidebar.classList.contains('-translate-x-full')) {
                        toggleSidebar();
                    }
                }
            }
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('-translate-x-full');
                sidebarOverlay.classList.add('opacity-0', 'invisible');
                sidebarOverlay.classList.remove('opacity-100');
                hamburgerIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
                body.classList.remove('no-scroll');
            } else {
                sidebar.classList.add('-translate-x-full');
                sidebarOverlay.classList.add('opacity-0', 'invisible');
                sidebarOverlay.classList.remove('opacity-100');
                hamburgerIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
                body.classList.remove('no-scroll');
            }
        });

        sidebar.addEventListener('touchmove', (e) => {
            if (window.innerWidth < 1024) {
                e.stopPropagation();
            }
        });
    });
</script>

<style>
    /* Custom transition untuk smooth sliding */
    .sidebar-transition {
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .sidebar-overlay {
        transition: opacity 0.3s ease-in-out;
    }

    .no-scroll {
        overflow: hidden;
    }

    [x-cloak] {
        display: none !important;
    }
</style>
