<header class="fixed w-full z-50">
    <nav class="bg-gradient-to-r bg-blue-800 py-2.5 shadow-md">
        <div class="flex flex-wrap items-center justify-between max-w-screen-xl px-4 mx-auto">
            <!-- Logo -->
            <a href="/" class="flex items-center">
                <img src="https://demo.themesberg.com/landwind/images/logo.svg" class="h-8 mr-3" alt="SmartTrans Logo" />
                <span class="text-xl font-semibold text-white">SMP AL Qadri</span>
            </a>

            <!-- Kanan: Masuk -->
            <div class="flex items-center lg:order-2">
                <a href="{{ route('login') }}"
                    class="text-blue-700 bg-white hover:bg-gray-100 focus:ring-4 focus:ring-white font-medium rounded-lg text-sm px-4 py-2 transition-all">
                    Masuk / Daftar
                </a>
                <!-- Hamburger -->
                <button data-collapse-toggle="mobile-menu" type="button"
                    class="inline-flex items-center p-2 ml-2 text-sm text-white rounded-lg lg:hidden hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-white"
                    aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Toggle menu</span>
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M3 5h14a1 1 0 100-2H3a1 1 0 100 2zm14 4H3a1 1 0 000 2h14a1 1 0 000-2zm0 6H3a1 1 0 000 2h14a1 1 0 000-2z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>

            <!-- Menu Navigasi -->
            <div class="hidden items-center justify-between w-full lg:flex lg:w-auto lg:order-1" id="mobile-menu">
                <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
                    <li><a href="/"
                            class="block py-2 pl-3 pr-4 text-white font-semibold hover:text-purple-200 lg:p-0 transition-all">Home</a>
                    </li>
                    <li><a href="{{ route('tentang') }}"
                            class="block py-2 pl-3 pr-4 text-white hover:text-purple-200 lg:p-0 transition-all">Tentang</a>
                    </li>
                    <li><a href="{{ route('layanan') }}"
                            class="block py-2 pl-3 pr-4 text-white hover:text-purple-200 lg:p-0 transition-all">Layanan</a>
                    </li>
                    <li><a href="{{ route('pengumuman') }}"
                            class="block py-2 pl-3 pr-4 text-white hover:text-purple-200 lg:p-0 transition-all">Pengumuman</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
