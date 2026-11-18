{{-- Sisipkan dalam blok @if($role === 'admin'), misalnya setelah menu Berita. --}}
<li>
    <a href="{{ route('admin.pengumuman.index') }}"
       class="{{ $active }} {{ request()->routeIs('admin.pengumuman.*') ? $selected : $normal }}">
        📢 Pengumuman Sekolah
    </a>
</li>
