<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BkController extends Controller
{
    public function index()
    {
        return view('bk.dashboard');
    }
    public function profil()
    {
        return view('bk.profil');
    }
    public function pengaduan()
    {
        return view('bk.pengaduan');
    }
    public function pelanggaran()
    {
        return view('bk.pelanggaran');
    }
    public function riwayat()
    {
        return view('bk.riwayat');
    }
    public function skorsing()
    {
        return view('bk.skorsing');
    }
    public function pengelolaan()
    {
        return view('bk.pengelolaan');
    }
}
