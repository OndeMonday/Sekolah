<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <style>
        body {
            font-family: sans-serif;
            font-size: 10px;
        }
        body {
    font-family: DejaVu Sans;
}

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 4px;
            text-align: center;
        }

        .left {
            text-align: left;
        }
    </style>
</head>
<body>

    <h2>
        Rekap Absensi Bulanan
    </h2>

    <p>
        Kelas: {{ $kelas }}
    </p>

    <p>
        Bulan: {{ $bulan }} / {{ $tahun }}
    </p>

    <table>

        <thead>

            <tr>
                <th>No</th>
                <th>Nama</th>

                @for ($i = 1; $i <= $jumlahHari; $i++)
                    <th>{{ $i }}</th>
                @endfor
            </tr>

        </thead>

        <tbody>

            @foreach ($siswa as $index => $item)

                <tr>

                    <td>
                        {{ $loop->iteration }}
                    </td>

                    <td class="left">
                        {{ $item['name'] }}
                    </td>

                    @for ($i = 1; $i <= $jumlahHari; $i++)

                        <td>

                            @if(isset($item['hari'][$i]))
                                ✓
                            @else
                                -
                            @endif

                        </td>

                    @endfor

                </tr>

            @endforeach

        </tbody>

    </table>

</body>
</html>