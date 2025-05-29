<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }


    public function guru()
    {
        return view('admin.guru');
    }

    public function siswa()
    {
        return view('admin.siswa');
    }

    public function bk()
    {
        return view('admin.bk');
    }

    public function laporan()
    {
        return view('admin.laporan');
    }

    public function konseling()
    {
        return view('admin.konseling');
    }

    public function pengaduan()
    {
        return view('admin.pengaduan');
    }

    public function pelanggaran()
    {
        return view('admin.pelanggaran');
    }
    public function riwayat()
    {
        return view('admin.riwayat');
    }
}
