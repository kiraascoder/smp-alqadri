@extends('components.app')

@section('title', 'SMP AL QADRI - Bimbingan dan Konseling')

@section('content')
    <!-- Hero Section -->
    <section class="relative">
        <div class="bg-blue-800 text-white">
            <div class="container mx-auto px-4 py-16 md:py-24">
                <div class="md:w-1/2">
                    <h1 class="text-3xl md:text-4xl font-bold mb-4">Kami Siap Mendengarkan dan Membantu</h1>
                    <p class="text-lg mb-6">Layanan Bimbingan dan Konseling untuk mendukung perkembangan emosional, sosial,
                        dan akademik siswa.</p>
                    <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                        <a href="#"
                            class="bg-white text-blue-800 hover:bg-gray-100 px-6 py-3 rounded-full font-medium text-center">Tentang
                            Layanan</a>
                        <a href="#"
                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-full font-medium text-center">Hubungi
                            Konselor</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="hidden md:block absolute right-0 bottom-0 w-5/12 h-full overflow-hidden">
            <img src="/images/konseling.jpg" alt="Sesi Konseling" class="object-cover h-full w-full" />
        </div>
    </section>

    <!-- Layanan Section -->
    <section class="py-14 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl md:text-3xl font-bold mb-10 text-center text-blue-900">Apa yang Bisa Kami Bantu Hari Ini?
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Edukasi -->
                <div class="bg-blue-50 p-6 rounded-xl shadow-md hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-700" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2">Edukasi & Pemahaman</h3>
                    <p class="text-gray-700 mb-4">Pelajari lebih dalam tentang cara mengelola emosi, stres, dan membangun
                        kepercayaan diri.</p>
                    <a href="#" class="text-blue-700 hover:text-blue-800 font-medium inline-flex items-center">
                        Pelajari lebih lanjut
                        <svg class="h-4 w-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                
                <div class="bg-green-50 p-6 rounded-xl shadow-md hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-700" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2">Layanan Konseling</h3>
                    <p class="text-gray-700 mb-4">Kami menyediakan sesi konseling pribadi, kelompok, maupun keluarga secara
                        rahasia dan aman.</p>
                    <a href="#" class="text-green-700 hover:text-green-800 font-medium inline-flex items-center">
                        Jadwalkan Konseling
                        <svg class="h-4 w-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>


                <div class="bg-purple-50 p-6 rounded-xl shadow-md hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-700" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2">Peduli Teman</h3>
                    <p class="text-gray-700 mb-4">Khawatir dengan temanmu? Temukan cara terbaik untuk mendekati dan membantu
                        mereka.</p>
                    <a href="#" class="text-purple-700 hover:text-purple-800 font-medium inline-flex items-center">
                        Lihat tipsnya
                        <svg class="h-4 w-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
</section>
@endsection
