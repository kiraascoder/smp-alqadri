<header
    class="fixed top-0 left-0 right-0 z-50
    lg:hidden
    bg-white border-b border-slate-200
    px-4 py-3 flex items-center justify-between">


    <button id="hamburger-btn"
        class="p-2 rounded-xl
        text-slate-700
        hover:bg-slate-100
        transition">


        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">

            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />

        </svg>


    </button>



    <div class="flex items-center gap-2">

        <div
            class="w-8 h-8 rounded-xl
            bg-blue-700
            flex items-center justify-center
            text-white font-bold">

            A

        </div>


        <span class="font-bold text-slate-800">

            SMP AL-QADRI

        </span>


    </div>


</header>




<div id="sidebar-overlay" class="fixed inset-0 z-40
bg-black/40 hidden lg:hidden">
</div>





<aside id="sidebar"
    class="
fixed top-0 left-0 z-50
h-full w-72

-translate-x-full
lg:translate-x-0

bg-slate-900

text-white

shadow-xl

transition-transform duration-300">


    {{-- HEADER SIDEBAR --}}

    <div class="
p-6
border-b border-slate-700">


        <div class="flex items-center gap-3">


            <div class="
w-12 h-12
rounded-2xl
bg-blue-600
flex items-center justify-center
text-xl font-bold">

                A

            </div>


            <div>

                <h1 class="font-bold text-lg">

                    SMP AL-QADRI

                </h1>


                <p class="text-xs text-slate-400">

                    Sistem Informasi Sekolah

                </p>


            </div>


        </div>





        <div class="
mt-6
p-4
rounded-xl
bg-slate-800">


            <p class="font-semibold text-sm">

                {{ auth()->user()->name }}

            </p>


            <p class="
text-xs
text-blue-300
capitalize
mt-1">

                {{ str_replace('_', ' ', auth()->user()->role) }}

            </p>


        </div>



    </div>





    @php

        $role = auth()->user()->role;

    @endphp





    <nav class="
p-4
overflow-y-auto
h-[calc(100%-190px)]">


        <ul class="space-y-1 text-sm">



            {{-- COMPONENT MENU --}}
            @php

                $active = 'flex items-center gap-3
px-4 py-3 rounded-xl
transition
font-medium';

                $normal = 'text-slate-300 hover:bg-slate-800 hover:text-white';

                $selected = 'bg-blue-600 text-white';

            @endphp




            @if ($role === 'admin')
                <li>

                    <a href="{{ route('admin.dashboard') }}"
                        class="{{ $active }}
{{ request()->routeIs('admin.dashboard') ? $selected : $normal }}">

                        <span>📊</span>

                        Dashboard

                    </a>

                </li>



                <li>
                    <a href="{{ route('admin.guru') }}"
                        class="{{ $active }}
{{ request()->routeIs('admin.guru*') || request()->routeIs('admin-guru.*') ? $selected : $normal }}">

                        <span>👨‍🏫</span>
                        Guru

                    </a>
                </li>



                <li>
                    <a href="{{ route('admin.kelas') }}"
                        class="{{ $active }}
{{ request()->routeIs('admin.kelas*') ? $selected : $normal }}">

                        <span>🏫</span>
                        Kelas

                    </a>
                </li>



                <li>
                    <a href="{{ route('admin.siswa') }}"
                        class="{{ $active }}
{{ request()->routeIs('admin.siswa*') ? $selected : $normal }}">

                        <span>👨‍🎓</span>
                        Siswa

                    </a>
                </li>




                <li>
                    <a href="{{ route('admin.orang') }}"
                        class="{{ $active }}
{{ request()->routeIs('admin.orang*') ? $selected : $normal }}">

                        <span>👪</span>
                        Orang Tua

                    </a>
                </li>



                <li>
                    <a href="{{ route('admin.pelanggaran') }}"
                        class="{{ $active }}
{{ request()->routeIs('admin.pelanggaran*') ? $selected : $normal }}">

                        <span>⚠️</span>
                        Pelanggaran

                    </a>
                </li>



                <li>
                    <a href="{{ route('admin.kebajikan') }}"
                        class="{{ $active }}
{{ request()->routeIs('admin.kebajikan*') ? $selected : $normal }}">

                        <span>⭐</span>
                        Jenis Kebajikan

                    </a>
                </li>



                <li>
                    <a href="{{ route('admin.skorsing') }}"
                        class="{{ $active }}
{{ request()->routeIs('admin.skorsing*') ? $selected : $normal }}">

                        <span>🚨</span>
                        Skorsing

                    </a>
                </li>



                <li>
                    <a href="{{ route('admin.rekap-skorsing') }}"
                        class="{{ $active }}
{{ request()->routeIs('admin.rekap-skorsing') ? $selected : $normal }}">

                        <span>📋</span>
                        Rekap Skorsing

                    </a>
                </li>
            @elseif($role === 'guru')
                <li>

                    <a href="{{ route('guru.dashboard') }}"
                        class="{{ $active }}
{{ request()->routeIs('guru.dashboard') ? $selected : $normal }}">

                        📊 Dashboard

                    </a>

                </li>



                <li>

                    <a href="{{ route('guru.pelanggaran') }}"
                        class="{{ $active }}
{{ request()->routeIs('guru.pelanggaran') ? $selected : $normal }}">

                        ⚠️ Jenis Pelanggaran

                    </a>

                </li>



                <li>

                    <a href="{{ route('guru.skorsing') }}"
                        class="{{ $active }}
{{ request()->routeIs('guru.skorsing*') ? $selected : $normal }}">

                        🚨 Skorsing

                    </a>

                </li>



                <li>

                    <a href="{{ route('guru.kebajikan') }}"
                        class="{{ $active }}
{{ request()->routeIs('guru.kebajikan*') ? $selected : $normal }}">

                        ⭐ Poin Kebajikan

                    </a>

                </li>



                <li>

                    <a href="{{ route('guru.profil') }}"
                        class="{{ $active }}
{{ request()->routeIs('guru.profil') ? $selected : $normal }}">

                        👤 Profil

                    </a>

                </li>
            @elseif($role === 'orang_tua')
                <li>

                    <a href="{{ route('ortu.dashboard') }}"
                        class="{{ $active }}
{{ request()->routeIs('ortu.dashboard') ? $selected : $normal }}">

                        📊 Dashboard

                    </a>

                </li>



                <li>

                    <a href="{{ route('ortu.pelanggaran') }}"
                        class="{{ $active }}
{{ request()->routeIs('ortu.pelanggaran') ? $selected : $normal }}">

                        ⚠️ Jenis Pelanggaran

                    </a>

                </li>
            @endif




        </ul>


    </nav>





    {{-- LOGOUT --}}

    <div class="
absolute bottom-0
left-0 right-0
p-4
border-t border-slate-700">


        <form method="POST" action="{{ route('logout') }}">

            @csrf


            <button
                class="
w-full
flex items-center
justify-center
gap-2

px-4 py-3

rounded-xl

bg-red-600
hover:bg-red-700

text-white

font-semibold

transition">


                🚪 Keluar


            </button>


        </form>


    </div>



</aside>





<script>
    document.addEventListener('DOMContentLoaded', () => {


        const button =
            document.getElementById('hamburger-btn');


        const sidebar =
            document.getElementById('sidebar');


        const overlay =
            document.getElementById('sidebar-overlay');



        function toggle() {

            sidebar.classList.toggle('-translate-x-full');

            overlay.classList.toggle('hidden');

        }



        button?.addEventListener(
            'click',
            toggle
        );


        overlay?.addEventListener(
            'click',
            toggle
        );


    });
</script>
