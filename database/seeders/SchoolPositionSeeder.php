<?php

namespace Database\Seeders;

use App\Models\SchoolPosition;
use Illuminate\Database\Seeder;

class SchoolPositionSeeder extends Seeder
{
    public function run(): void
    {
        $make = function (string $title, ?SchoolPosition $parent = null, int $order = 0, bool $home = false) {
            return SchoolPosition::firstOrCreate(
                ['title' => $title, 'parent_id' => $parent?->id],
                ['sort_order' => $order, 'is_active' => true, 'show_homepage' => $home]
            );
        };

        $make('Pengawas Pembina', null, 1);
        $principal = $make('Kepala Sekolah', null, 2, true);
        $make('Komite Sekolah', null, 3, true);
        $deputy = $make('Wakil Kepala Sekolah', $principal, 1, true);
        $make('Tata Usaha', $deputy, 1);
        $make('Bendahara', $deputy, 2);
        $make('Operator', $deputy, 3);
        $teachers = $make('Dewan Guru', $deputy, 4);

        $guardians = $make('Wali Kelas', $teachers, 1);
        foreach ([7, 8, 9] as $level) {
            $make('Wali Kelas '.$level, $guardians, $level);
        }

        $subjects = [
            'Guru PAI', 'Guru Fiqih', 'Guru Matematika', 'Bimbingan Konseling',
            'Guru Hafalan', 'Guru Hadits', 'Guru Bahasa Indonesia', 'Guru Bahasa Inggris',
            'Guru Sejarah Islam', 'Guru Kontrol Sholat', 'Guru PJOK', 'Guru IPA',
            'Guru Aqidah Akhlak', 'Guru Qiraatul Qur’an', 'Guru IPS', 'Guru Prakarya',
            'Guru Bahasa Arab', 'Guru Tahfidzul Doa', 'Guru PKN',
        ];
        $subjectGroup = $make('Guru Mata Pelajaran', $teachers, 2);
        foreach ($subjects as $i => $subject) {
            $make($subject, $subjectGroup, $i + 1);
        }
        $make('Satpam', $deputy, 5);
        $make('Caraka', $deputy, 6);
        $make('Peserta Didik', $principal, 2);
    }
}
