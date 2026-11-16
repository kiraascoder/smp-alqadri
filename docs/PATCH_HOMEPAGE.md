# Tautan dan ringkasan di resources/views/welcome.blade.php

## 1. Menu desktop dan mobile

Tambahkan tautan di dalam menu navbar desktop dan mobile yang sudah ada:

```blade
<a href="{{ route('struktur.index') }}" class="hover:text-emerald-600 transition">Struktur Organisasi</a>
```

Untuk menu mobile ikuti class link mobile lama, bukan mengganti navbar seluruhnya.

## 2. Tambahkan ringkasan di homepage

Sisipkan section ini setelah penutup `</section>` HERO dan sebelum `AKSES CEPAT`, atau pada lokasi lain yang lebih cocok:

```blade
@if(isset($leaders) && $leaders->isNotEmpty())
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-5 lg:px-8">
        <div class="text-center mb-9">
            <span class="font-semibold text-emerald-700 text-sm">Profil Sekolah</span>
            <h2 class="text-3xl font-bold text-slate-900 mt-2">Struktur Organisasi</h2>
            <p class="text-slate-500 mt-3">Kenali pimpinan dan pengurus SMP Al-Qadri Islamic School.</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach($leaders as $position)
                <div class="rounded-2xl border border-emerald-100 bg-slate-50 overflow-hidden shadow-sm">
                    <div class="bg-emerald-800 text-white font-semibold px-4 py-3 text-center">{{ $position->title }}</div>
                    <div class="p-5 text-center space-y-3">
                        @forelse($position->members as $member)
                            <div>
                                @if($member->photo_path)
                                    <img src="{{ asset('storage/'.$member->photo_path) }}" alt="" class="w-20 h-20 mx-auto rounded-full object-cover mb-3">
                                @endif
                                <p class="font-semibold text-slate-900">{{ $member->name }}</p>
                                @if($member->subtitle)<p class="text-sm text-slate-500">{{ $member->subtitle }}</p>@endif
                            </div>
                        @empty
                            <p class="text-sm text-slate-500">Belum ada nama yang dipublikasikan.</p>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center mt-9">
            <a href="{{ route('struktur.index') }}" class="inline-flex px-6 py-3 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-semibold">
                Lihat Struktur Organisasi Lengkap
            </a>
        </div>
    </div>
</section>
@endif
```
