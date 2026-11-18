{{-- Tempelkan di dalam @if($role === 'admin'), misalnya setelah menu Struktur Organisasi. --}}
<li>
    <a href="{{ route('admin.berita.index') }}"
       class="{{ $active }} {{ request()->routeIs('admin.berita.*') ? $selected : $normal }}">
        📰 Berita Sekolah
    </a>
</li>
