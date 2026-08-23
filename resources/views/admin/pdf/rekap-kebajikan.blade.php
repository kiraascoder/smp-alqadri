<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Rekap Kebajikan</title>

    <style>

        @page {
            margin: 25px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #1e293b;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 20px;
            margin: 0;
        }

        .header p {
            margin: 5px 0 0;
            color: #64748b;
        }

        .info {
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f1f5f9;
            font-weight: bold;
            text-align: left;
        }

        th,
        td {
            border: 1px solid #cbd5e1;
            padding: 6px;
            vertical-align: top;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 20px;
            font-size: 9px;
            color: #64748b;
        }

    </style>

</head>


<body>

    <div class="header">

        <h1>
            SMP AL-QADRI
        </h1>

        <p>
            REKAP KEBAJIKAN SISWA
        </p>

    </div>


    <div class="info">

        <strong>Periode:</strong>

        {{ $filter['tanggal_mulai'] ?: 'Semua' }}

        s/d

        {{ $filter['tanggal_selesai'] ?: 'Semua' }}

    </div>


    <table>

        <thead>

            <tr>

                <th>No</th>

                <th>Tanggal</th>

                <th>Siswa</th>

                <th>Kelas</th>

                <th>Kebajikan</th>

                <th>Poin</th>

                <th>Dibuat Oleh</th>

                <th>Keterangan</th>

            </tr>

        </thead>


        <tbody>

            @forelse($rekap as $item)

                <tr>

                    <td class="text-center">
                        {{ $loop->iteration }}
                    </td>

                    <td>
                        {{ $item->tanggal?->format('d/m/Y') }}
                    </td>

                    <td>
                        {{ $item->siswa?->nama ?? '-' }}
                    </td>

                    <td>
                        {{ $item->siswa?->kelas?->nama_kelas ?? '-' }}
                    </td>

                    <td>
                        {{ $item->kebajikan?->deskripsi ?? '-' }}
                    </td>

                    <td class="text-center">
                        +{{ $item->skor }}
                    </td>

                    <td>
                        {{ $item->creator?->name ?? 'User dihapus' }}
                    </td>

                    <td>
                        {{ $item->keterangan ?? '-' }}
                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="8" class="text-center">
                        Tidak ada data.
                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>


    <div class="footer">

        Dicetak pada:
        {{ now()->format('d/m/Y H:i') }}

    </div>

</body>

</html>
