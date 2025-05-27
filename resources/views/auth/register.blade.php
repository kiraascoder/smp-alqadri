<!-- resources/views/admin/register.blade.php -->

<!DOCTYPE html>
<html>

<head>
    <title>Register Admin</title>
</head>

<body>
    <h2>Register</h2>

    @if ($errors->any())
        <ul style="color: red">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('register.submit') }}">
        @csrf
        <label>Nama:</label>
        <input type="text" name="name" required><br><br>

        <div class="form-group">
            <label for="nisn">NISN</label>
            <input type="text" name="nisn" class="form-control" required>
        </div>


        <label>Email:</label>
        <input type="email" name="email" required><br><br>

        <div class="form-group">
            <label for="kelas_id">Pilih Kelas</label>
            <select name="kelas_id" class="form-control" required>
                <option value="">-- Pilih Kelas --</option>
                @foreach ($kelas as $item)
                    <option value="{{ $item->id }}">{{ $item->nama_kelas }}</option>
                @endforeach
            </select>
        </div>


        <label>Password:</label>
        <input type="password" name="password" required><br><br>

        <label>Konfirmasi Password:</label>
        <input type="password" name="password_confirmation" required><br><br>

        <button type="submit">Register</button>
    </form>

    <p>Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
</body>

</html>
