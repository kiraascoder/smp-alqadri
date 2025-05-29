<p>Selamat Datang Admin</p>

<ul>
    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li><a href="{{ route('admin.bk') }}">Guru BK</a></li>
    <li><a href="{{ route('admin.guru') }}">guru</a></li>
    <li><a href="{{ route('admin.laporan') }}">laporan</a></li>
    <li><a href="{{ route('admin.pelanggaran') }}">pelanggaran</a></li>
    <li><a href="{{ route('admin.riwayat') }}">riwayat</a></li>
    <li><a href="{{ route('admin.siswa') }}">siswa</a></li>
</ul>

<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>
