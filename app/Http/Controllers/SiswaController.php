<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    public function index()
    {
        return view('siswa.dashboard');
    }
    public function profil()
    {
        $siswa = Auth::user()->siswa->id;
        return view('siswa.profil', compact('siswa'));
    }

    public function pelanggaran()
    {
        return view('siswa.pelanggaran');
    }    
}
