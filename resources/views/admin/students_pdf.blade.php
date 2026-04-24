<h2 style="text-align:center;">Daftar Murid</h2>

<table border="1" width="100%" cellpadding="5">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>NISN</th>
        </tr>
    </thead>
    <tbody>
        @foreach($students as $index => $student)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $student->name }}</td>
            <td>{{ $student->nisn_nip }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<p>Exported at: {{ now() }}</p>