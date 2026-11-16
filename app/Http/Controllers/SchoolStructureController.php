<?php

namespace App\Http\Controllers;

use App\Models\SchoolPosition;
use App\Models\SchoolPositionMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class SchoolStructureController extends Controller
{
    public function publicIndex()
    {
        $positions = SchoolPosition::query()
            ->where('is_active', true)
            ->with(['members' => fn ($query) => $query->where('is_active', true)
                ->orderBy('sort_order')->orderBy('id')])
            ->orderBy('sort_order')->orderBy('id')->get();

        // Only true roots are displayed: hidden ancestors hide their descendants.
        $roots = $positions->whereNull('parent_id');

        return view('struktur.index', compact('positions', 'roots'));
    }

    public function adminIndex()
    {
        $positions = SchoolPosition::query()
            ->with(['parent', 'members'])
            ->orderBy('sort_order')->orderBy('id')->get();

        $members = SchoolPositionMember::query()
            ->with('position')
            ->orderBy('school_position_id')->orderBy('sort_order')->orderBy('id')
            ->paginate(25);

        return view('admin.struktur-organisasi', compact('positions', 'members'));
    }

    public function storePosition(Request $request)
    {
        $data = $this->validatePosition($request);
        SchoolPosition::create($data);
        return back()->with('success', 'Jabatan berhasil ditambahkan.');
    }

    public function updatePosition(Request $request, SchoolPosition $position)
    {
        $data = $this->validatePosition($request, $position);
        $position->update($data);
        return back()->with('success', 'Jabatan berhasil diperbarui.');
    }

    private function validatePosition(Request $request, ?SchoolPosition $position = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'parent_id' => ['nullable', 'integer', Rule::exists('school_positions', 'id')],
            'sort_order' => ['required', 'integer', 'min:0', 'max:99999'],
            'is_active' => ['sometimes', 'boolean'],
            'show_homepage' => ['sometimes', 'boolean'],
        ]);

        $data['parent_id'] = $data['parent_id'] ?: null;
        $data['is_active'] = $request->boolean('is_active');
        $data['show_homepage'] = $request->boolean('show_homepage');

        // Prevent cycles: a position cannot become its own descendant.
        if ($position && $data['parent_id']) {
            $cursorId = (int) $data['parent_id'];
            $visited = [];
            while ($cursorId) {
                if ($cursorId === $position->id || isset($visited[$cursorId])) {
                    throw ValidationException::withMessages([
                        'parent_id' => 'Induk jabatan tidak boleh membentuk hubungan melingkar.',
                    ]);
                }
                $visited[$cursorId] = true;
                $cursorId = SchoolPosition::whereKey($cursorId)->value('parent_id');
            }
        }

        return $data;
    }

    public function destroyPosition(SchoolPosition $position)
    {
        if ($position->children()->exists() || $position->members()->exists()) {
            return back()->with('error', 'Pindahkan atau hapus anak jabatan dan personel terlebih dahulu.');
        }
        $position->delete();
        return back()->with('success', 'Jabatan berhasil dihapus.');
    }

    public function storeMember(Request $request)
    {
        $data = $this->validateMember($request);
        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('struktur-organisasi', 'public');
        }
        SchoolPositionMember::create($data);
        return back()->with('success', 'Personel berhasil ditambahkan.');
    }

    public function updateMember(Request $request, SchoolPositionMember $member)
    {
        $data = $this->validateMember($request);
        if ($request->hasFile('photo')) {
            $newPath = $request->file('photo')->store('struktur-organisasi', 'public');
            $oldPath = $member->photo_path;
            $data['photo_path'] = $newPath;
            $member->update($data);
            if ($oldPath) Storage::disk('public')->delete($oldPath);
        } else {
            if ($request->boolean('remove_photo')) {
                if ($member->photo_path) Storage::disk('public')->delete($member->photo_path);
                $data['photo_path'] = null;
            }
            $member->update($data);
        }
        return back()->with('success', 'Personel berhasil diperbarui.');
    }

    private function validateMember(Request $request): array
    {
        $data = $request->validate([
            'school_position_id' => ['required', 'integer', Rule::exists('school_positions', 'id')],
            'name' => ['required', 'string', 'max:150'],
            'subtitle' => ['nullable', 'string', 'max:180'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:99999'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'remove_photo' => ['sometimes', 'boolean'],
            'is_active' => ['sometimes', 'boolean'],
        ]);
        unset($data['photo'], $data['remove_photo']);
        $data['is_active'] = $request->boolean('is_active');
        return $data;
    }

    public function destroyMember(SchoolPositionMember $member)
    {
        $path = $member->photo_path;
        $member->delete();
        if ($path) Storage::disk('public')->delete($path);
        return back()->with('success', 'Personel berhasil dihapus.');
    }
}
