<p>Selamat datang {{ Auth::user()->name }}</p>

<ul>
    <li><a href="{{ route('bk.dashboard') }}">Dashboard</a></li>
    <li><a href="{{ route('bk.profil') }}">profil</a></li>
    <li><a href="{{ route('bk.pelanggaran') }}">pelanggaran</a></li>
    <li><a href="{{ route('bk.riwayat') }}">riwayat</a></li>
    <li><a href="{{ route('bk.skorsing') }}">skorsing</a></li>
    <li><a href="{{ route('bk.pengelolaan') }}">pengelolaan</a></li>
</ul>

<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>
