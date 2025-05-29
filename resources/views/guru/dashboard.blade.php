<p>Selamat Guru {{ Auth::user()->name }}</p>

<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>

<ul>
    <li><a href="{{ route('guru.profil') }}">Profil</a></li>
    <li><a href="{{ route('guru.siswa') }}">Siswa</a></li>
    <li><a href="{{ route('guru.skorsing') }}">Skorsing</a></li>
    <li><a href="{{ route('guru.pelanggaran') }}">Pelanggaran</a></li>
</ul>
