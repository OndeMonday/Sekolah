<h2 style="text-align:center;">Daftar Kelas</h2>
<h3>Kelas: {{ $class->name }}</h3>


<h3>Data Guru</h3>

<table border="1" cellpadding="5" cellspacing="0" width="100%">
<thead>
<tr>
    <th>No</th>
    <th>Nama</th>
    <th>NIP</th>
    <th>Mapel</th>
</tr>
</thead>
<tbody>
@php $no = 1; @endphp
@foreach($users as $user)
@if($user['role'] == 'guru')
<tr>
    <td>{{ $no++ }}</td>
    <td>{{ $user['nama'] }}</td>
    <td>{{ $user['nisn_nip'] }}</td>
    <td>{{ $user['mapel'] ?? '-' }}</td>
</tr>
@endif
@endforeach
</tbody>
</table>


<br><br>

<h3>Data Murid</h3>

<table border="1" cellpadding="5" cellspacing="0" width="100%">
<thead>
<tr>
    <th>Absen</th>
    <th>Nama</th>
    <th>NISN</th>
</tr>
</thead>
<tbody>
@php $no = 1; @endphp
@foreach($users as $user)
@if($user['role'] == 'murid')
<tr>
    <td>{{ $no++ }}</td>
    <td>{{ $user['nama'] }}</td>
    <td>{{ $user['nisn_nip'] }}</td>
</tr>
@endif
@endforeach
</tbody>
</table>

<p>Exported at: {{ now() }}</p>