<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Throwable;

class BeritaController extends Controller
{
    // Halaman publik. Berita draft atau belum masuk tanggal publikasi tetap tersembunyi.
    public function publicIndex(Request $request)
    {
        $data = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
        ]);
        $search = trim($data['search'] ?? '');

        $beritaList = Berita::published()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('judul', 'like', "%{$search}%")
                        ->orWhere('kategori', 'like', "%{$search}%")
                        ->orWhere('ringkasan', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->paginate(9)
            ->withQueryString();

        return view('berita.index', compact('beritaList', 'search'));
    }

    public function publicShow(Berita $berita)
    {
        abort_unless(
            $berita->status === 'published'
                && $berita->published_at !== null
                && $berita->published_at->lte(now()),
            404
        );

        $related = Berita::published()
            ->where('id', '!=', $berita->id)
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        return view('berita.show', compact('berita', 'related'));
    }

    // Bagian admin dilindungi oleh middleware auth + role:admin pada routes/web.php.
    public function adminIndex(Request $request)
    {
        $data = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', Rule::in(['draft', 'published'])],
        ]);
        $search = trim($data['search'] ?? '');
        $status = $data['status'] ?? '';

        $beritaList = Berita::query()
            ->with('creator')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('judul', 'like', "%{$search}%")
                        ->orWhere('kategori', 'like', "%{$search}%");
                });
            })
            ->when($status !== '', fn ($query) => $query->where('status', $status))
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.berita.index', compact('beritaList', 'search', 'status'));
    }

    public function create()
    {
        return view('admin.berita.form', ['berita' => new Berita()]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data['slug'] = $this->uniqueSlug($data['judul']);
        $data['created_by'] = auth()->id();
        $data['published_at'] = $data['status'] === 'published' ? now() : null;

        $newImagePath = null;
        if ($request->hasFile('gambar')) {
            $newImagePath = $request->file('gambar')->store('berita', 'public');
            $data['gambar'] = $newImagePath;
        }

        try {
            Berita::create($data);
        } catch (Throwable $e) {
            if ($newImagePath) Storage::disk('public')->delete($newImagePath);
            throw $e;
        }

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil disimpan.');
    }

    public function edit(Berita $berita)
    {
        return view('admin.berita.form', compact('berita'));
    }

    public function update(Request $request, Berita $berita)
    {
        $data = $this->validatedData($request);
        $removeImage = $request->boolean('hapus_gambar');
        $oldImagePath = $berita->gambar;
        $newImagePath = null;

        // Slug tidak berubah saat judul diperbarui supaya tautan berita lama tetap berlaku.
        if ($data['status'] === 'published') {
            $data['published_at'] = $berita->published_at ?? now();
        } else {
            $data['published_at'] = null;
        }

        if ($request->hasFile('gambar')) {
            $newImagePath = $request->file('gambar')->store('berita', 'public');
            $data['gambar'] = $newImagePath;
        } elseif ($removeImage) {
            $data['gambar'] = null;
        }

        try {
            $berita->update($data);
        } catch (Throwable $e) {
            if ($newImagePath) Storage::disk('public')->delete($newImagePath);
            throw $e;
        }

        if ($oldImagePath && ($newImagePath || $removeImage)) {
            Storage::disk('public')->delete($oldImagePath);
        }

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Berita $berita)
    {
        $imagePath = $berita->gambar;
        $berita->delete();
        if ($imagePath) Storage::disk('public')->delete($imagePath);

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil dihapus.');
    }

    private function validatedData(Request $request): array
    {
        $data = $request->validate([
            'judul' => ['required', 'string', 'min:5', 'max:180'],
            'kategori' => ['nullable', 'string', 'max:100'],
            'ringkasan' => ['nullable', 'string', 'max:500'],
            'isi' => ['required', 'string'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'gambar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'hapus_gambar' => ['sometimes', 'boolean'],
        ]);
        unset($data['gambar'], $data['hapus_gambar']);

        $data['kategori'] = trim($data['kategori'] ?? '') ?: null;
        $data['ringkasan'] = trim($data['ringkasan'] ?? '')
            ?: Str::limit(trim(preg_replace('/\s+/u', ' ', $data['isi'])), 180, '');

        return $data;
    }

    private function uniqueSlug(string $title): string
    {
        $base = Str::slug($title) ?: 'berita';
        $base = substr($base, 0, 185);
        $slug = $base;
        $suffix = 2;
        while (Berita::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $suffix;
            $suffix++;
        }
        return $slug;
    }
}
