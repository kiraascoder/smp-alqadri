<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminSesiController extends Controller
{
    public function adminLoginView()
    {
        return view('admin.auth.login');
    }

    public function index()
    {
        return view('admin.dashboard');
    }
}
