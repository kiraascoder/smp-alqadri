@extends('components.admin')

@section('title', 'Dashboard Siswa')
@section('page_title', 'Dashboard Siswa')

@section('content')
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-2xl font-semibold mb-4">Selamat Datang, {{ Auth::user()->name }} 👋</h2>
        <p class="text-gray-600">Ini adalah halaman utama dashboard siswa. Silakan pilih menu di sebelah kiri untuk melihat
            informasi lebih lanjut.</p>
    </div>
@endsection
