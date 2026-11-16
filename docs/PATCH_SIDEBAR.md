# Tambahkan tautan menu pada resources/views/components/sidebar.blade.php

Di dalam blok `@if ($role === 'admin')`, tambahkan `<li>` berikut, misalnya setelah menu `Guru`:

```blade
<li>
    <a href="{{ route('admin.struktur.index') }}"
        class="{{ $active }} {{ request()->routeIs('admin.struktur.*') ? $selected : $normal }}">
        Struktur Organisasi
    </a>
</li>
```

Jangan tambahkan menu tersebut ke blok guru atau orang_tua. Pengelolaan hanya untuk admin.
