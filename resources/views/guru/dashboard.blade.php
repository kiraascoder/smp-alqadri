@extends('components.admin')

@section('title', 'Dashboard Guru')
@section('page_title', 'Dashboard Guru')

@section('content')
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-2xl font-semibold mb-4">Selamat Datang, {{ Auth::user()->name }} 👋</h2>
        <p class="text-gray-600">Ini adalah halaman utama dashboard Guru. Silakan pilih menu di sebelah kiri untuk melihat
            informasi lebih lanjut.</p>
    </div>
@endsection
