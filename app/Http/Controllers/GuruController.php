<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index()
    {
        return view('guru.dashboard');
    }

    public function siswa()
    {
        return view('guru.siswa');
    }
    public function profil()
    {
        return view('guru.profil');
    }
    public function skorsing()
    {
        return view('guru.skorsing');
    }
    public function pelanggaran()
    {
        return view('guru.pelanggaran');
    }
}
