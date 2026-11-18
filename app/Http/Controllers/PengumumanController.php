<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Throwable;

class PengumumanController extends Controller
{
    public function publicIndex(Request $request)
    {
        $input = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'kategori' => ['nullable', 'string', 'max:100'],
        ]);
        $search = trim($input['search'] ?? '');
        $kategori = trim($input['kategori'] ?? '');

        $pengumumanList = Pengumuman::visible()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('judul', 'like', '%' . $search . '%')
                      ->orWhere('ringkasan', 'like', '%' . $search . '%')
                      ->orWhere('isi', 'like', '%' . $search . '%');
                });
            })
            ->when($kategori !== '', fn ($q) => $q->where('kategori', $kategori))
            ->orderByDesc('is_pinned')
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->paginate(9)
            ->withQueryString();

        $kategoriList = Pengumuman::visible()
            ->whereNotNull('kategori')
            ->where('kategori', '!=', '')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        return view('pengumuman.index', compact('pengumumanList', 'search', 'kategori', 'kategoriList'));
    }

    public function publicShow(Pengumuman $pengumuman)
    {
        abort_unless($pengumuman->isVisible(), 404);

        $terbaru = Pengumuman::visible()
            ->where('id', '!=', $pengumuman->id)
            ->orderByDesc('is_pinned')
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        return view('pengumuman.show', compact('pengumuman', 'terbaru'));
    }

    public function adminIndex(Request $request)
    {
        $input = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', Rule::in(['draft', 'published'])],
        ]);
        $search = trim($input['search'] ?? '');
        $status = $input['status'] ?? '';

        $pengumumanList = Pengumuman::query()
            ->with('creator')
            ->when($search !== '', function ($q) use ($search) {
                $q->where(function ($filter) use ($search) {
                    $filter->where('judul', 'like', '%' . $search . '%')
                        ->orWhere('kategori', 'like', '%' . $search . '%');
                });
            })
            ->when($status !== '', fn ($q) => $q->where('status', $status))
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.pengumuman.index', compact('pengumumanList', 'search', 'status'));
    }

    public function create()
    {
        return view('admin.pengumuman.form', ['pengumuman' => new Pengumuman()]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data['slug'] = $this->uniqueSlug($data['judul']);
        $data['created_by'] = auth()->id();
        $data['published_at'] = $data['status'] === 'published' ? now() : null;

        $newPaths = [];
        try {
            if ($request->hasFile('gambar')) {
                $data['gambar'] = $request->file('gambar')->store('pengumuman/gambar', 'public');
                $newPaths[] = $data['gambar'];
            }
            if ($request->hasFile('lampiran')) {
                $data['lampiran'] = $request->file('lampiran')->store('pengumuman/lampiran', 'public');
                $data['nama_lampiran'] = Str::limit($request->file('lampiran')->getClientOriginalName(), 240, '');
                $newPaths[] = $data['lampiran'];
            }
            Pengumuman::create($data);
        } catch (Throwable $e) {
            foreach ($newPaths as $path) Storage::disk('public')->delete($path);
            throw $e;
        }

        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function edit(Pengumuman $pengumuman)
    {
        return view('admin.pengumuman.form', compact('pengumuman'));
    }

    public function update(Request $request, Pengumuman $pengumuman)
    {
        $data = $this->validatedData($request);
        $removeImage = $request->boolean('hapus_gambar');
        $removeAttachment = $request->boolean('hapus_lampiran');
        $oldImage = $pengumuman->gambar;
        $oldAttachment = $pengumuman->lampiran;
        $newPaths = [];

        // Mempertahankan slug agar URL yang pernah dibagikan tidak berubah.
        $data['published_at'] = $data['status'] === 'published'
            ? ($pengumuman->published_at ?? now())
            : null;

        try {
            if ($request->hasFile('gambar')) {
                $data['gambar'] = $request->file('gambar')->store('pengumuman/gambar', 'public');
                $newPaths[] = $data['gambar'];
            } elseif ($removeImage) {
                $data['gambar'] = null;
            }

            if ($request->hasFile('lampiran')) {
                $data['lampiran'] = $request->file('lampiran')->store('pengumuman/lampiran', 'public');
                $data['nama_lampiran'] = Str::limit($request->file('lampiran')->getClientOriginalName(), 240, '');
                $newPaths[] = $data['lampiran'];
            } elseif ($removeAttachment) {
                $data['lampiran'] = null;
                $data['nama_lampiran'] = null;
            }
            $pengumuman->update($data);
        } catch (Throwable $e) {
            foreach ($newPaths as $path) Storage::disk('public')->delete($path);
            throw $e;
        }

        if ($oldImage && (array_key_exists('gambar', $data) && $oldImage !== ($data['gambar'] ?? null))) {
            Storage::disk('public')->delete($oldImage);
        }
        if ($oldAttachment && (array_key_exists('lampiran', $data) && $oldAttachment !== ($data['lampiran'] ?? null))) {
            Storage::disk('public')->delete($oldAttachment);
        }

        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Pengumuman $pengumuman)
    {
        $paths = array_filter([$pengumuman->gambar, $pengumuman->lampiran]);
        $pengumuman->delete();
        foreach ($paths as $path) Storage::disk('public')->delete($path);

        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil dihapus.');
    }

    private function validatedData(Request $request): array
    {
        $data = $request->validate([
            'judul' => ['required', 'string', 'min:5', 'max:180'],
            'kategori' => ['nullable', 'string', 'max:100'],
            'ringkasan' => ['nullable', 'string', 'max:500'],
            'isi' => ['required', 'string', 'min:10'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'is_pinned' => ['sometimes', 'boolean'],
            'expires_on' => ['nullable', 'date'],
            'gambar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'lampiran' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
            'hapus_gambar' => ['sometimes', 'boolean'],
            'hapus_lampiran' => ['sometimes', 'boolean'],
        ]);
        unset($data['gambar'], $data['lampiran'], $data['hapus_gambar'], $data['hapus_lampiran']);

        $data['kategori'] = trim($data['kategori'] ?? '') ?: null;
        $data['ringkasan'] = trim($data['ringkasan'] ?? '')
            ?: Str::limit(trim(preg_replace('/\s+/u', ' ', $data['isi'])), 180, '');
        $data['is_pinned'] = $request->boolean('is_pinned');
        $data['expires_on'] = $data['expires_on'] ?? null;

        return $data;
    }

    private function uniqueSlug(string $judul): string
    {
        $base = substr(Str::slug($judul) ?: 'pengumuman', 0, 175);
        $slug = $base;
        $number = 2;
        while (Pengumuman::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $number;
            $number++;
        }
        return $slug;
    }
}
