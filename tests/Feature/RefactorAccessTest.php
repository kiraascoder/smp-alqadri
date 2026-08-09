<?php

namespace Tests\Feature;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\OrangTua;
use App\Models\Pelanggaran;
use App\Models\RiwayatPelanggaran;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RefactorAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_final_roles_have_dashboard_access(): void
    {
        $admin = User::factory()->admin()->create();
        $guru = User::factory()->guru()->create();
        Guru::create(['user_id' => $guru->id]);
        $parentUser = User::factory()->orangTua()->create();
        OrangTua::create(['user_id' => $parentUser->id]);

        $this->actingAs($admin)->get(route('admin.dashboard'))->assertOk();
        $this->actingAs($guru)->get(route('guru.dashboard'))->assertOk();
        $this->actingAs($parentUser)->get(route('ortu.dashboard'))->assertOk();

        $this->actingAs($guru)->get(route('admin.dashboard'))->assertForbidden();
        $this->actingAs($parentUser)->get(route('guru.skorsing'))->assertForbidden();
    }

    public function test_guru_only_sees_skorsing_created_by_that_guru(): void
    {
        [$kelas, $siswaA, $siswaB, $pelanggaran] = $this->schoolData();
        $guruA = User::factory()->guru()->create(['name' => 'Guru A']);
        $guruB = User::factory()->guru()->create(['name' => 'Guru B']);

        RiwayatPelanggaran::create([
            'siswa_id' => $siswaA->id,
            'pelanggaran_id' => $pelanggaran->id,
            'created_by' => $guruA->id,
            'skor' => 10,
            'tanggal' => now()->toDateString(),
        ]);

        RiwayatPelanggaran::create([
            'siswa_id' => $siswaB->id,
            'pelanggaran_id' => $pelanggaran->id,
            'created_by' => $guruB->id,
            'skor' => 10,
            'tanggal' => now()->toDateString(),
        ]);

        $response = $this->actingAs($guruA)
            ->get(route('guru.skorsing'));

        $response->assertOk();

        $response->assertViewHas('riwayat', function ($riwayat) use ($guruA, $guruB) {
            $items = collect($riwayat->items());

            return $items->count() === 1
                && $items->every(
                    fn($item) => $item->created_by === $guruA->id
                )
                && ! $items->contains(
                    fn($item) => $item->created_by === $guruB->id
                );
        });
    }

    public function test_parent_only_sees_own_children_and_their_skorsing(): void
    {
        [$kelas, $siswaA, $siswaB, $pelanggaran] = $this->schoolData();
        $parentA = User::factory()->orangTua()->create(['name' => 'Orang Tua A']);
        $parentB = User::factory()->orangTua()->create(['name' => 'Orang Tua B']);
        $profileA = OrangTua::create(['user_id' => $parentA->id]);
        $profileB = OrangTua::create(['user_id' => $parentB->id]);
        $siswaA->update(['orang_tua_id' => $profileA->id]);
        $siswaB->update(['orang_tua_id' => $profileB->id]);
        $guru = User::factory()->guru()->create();

        RiwayatPelanggaran::create([
            'siswa_id' => $siswaA->id,
            'pelanggaran_id' => $pelanggaran->id,
            'created_by' => $guru->id,
            'skor' => 10,
            'tanggal' => now()->toDateString(),
        ]);
        RiwayatPelanggaran::create([
            'siswa_id' => $siswaB->id,
            'pelanggaran_id' => $pelanggaran->id,
            'created_by' => $guru->id,
            'skor' => 10,
            'tanggal' => now()->toDateString(),
        ]);

        $this->actingAs($parentA)
            ->get(route('ortu.skorsing'))
            ->assertOk()
            ->assertSee('Anak A')
            ->assertDontSee('Anak B');
    }

    public function test_guru_creating_skorsing_records_creator_and_score_snapshot(): void
    {
        [$kelas, $siswaA, $siswaB, $pelanggaran] = $this->schoolData();
        $guru = User::factory()->guru()->create();

        $this->actingAs($guru)->post(route('guru.skorsing.store'), [
            'siswa_id' => $siswaA->id,
            'pelanggaran_id' => $pelanggaran->id,
            'tanggal' => now()->toDateString(),
            'keterangan' => 'Uji skorsing',
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseHas('riwayat_pelanggaran', [
            'siswa_id' => $siswaA->id,
            'pelanggaran_id' => $pelanggaran->id,
            'created_by' => $guru->id,
            'skor' => 10,
        ]);
        $this->assertSame(10, $siswaA->fresh()->score_bk);
    }

    private function schoolData(): array
    {
        $kelas = Kelas::create(['nama_kelas' => 'VII A']);
        $siswaA = Siswa::create([
            'nama' => 'Anak A',
            'kelas_id' => $kelas->id,
            'tanggal_lahir' => '2013-01-01',
            'score_bk' => 0,
        ]);
        $siswaB = Siswa::create([
            'nama' => 'Anak B',
            'kelas_id' => $kelas->id,
            'tanggal_lahir' => '2013-02-01',
            'score_bk' => 0,
        ]);
        $pelanggaran = Pelanggaran::create([
            'kategori' => 'ringan',
            'deskripsi' => 'Terlambat',
            'skor' => 10,
        ]);

        return [$kelas, $siswaA, $siswaB, $pelanggaran];
    }
}
