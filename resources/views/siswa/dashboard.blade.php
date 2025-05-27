<p>Selamat Datang Siswa {{ Auth::user()->name }}</p>

<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>

<a href="{{ route('siswa.profil') }}">Profil</a>
<a href="{{ route('siswa.pelanggaran') }}">Pelanggaran</a>
<a href="{{ route('siswa.konseling') }}">konseling</a>
<a href="{{ route('siswa.laporan') }}">laporan</a>
