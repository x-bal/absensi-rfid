<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Tanggal</th>
            <th>Hadir Onsite</th>
            <th>Hadir Via Zoom</th>
            <th>Sakit</th>
            <th>Ijin</th>
            <th>Alpa</th>
        </tr>
    </thead>

    <tbody>
        @foreach($absensi as $absen)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $absen->siswa->nama }}</td>
            <td>{{ Carbon\Carbon::parse($absen->created_at)->format('d/m/Y') }}</td>
            <td>{{ $absen->status_hadir == 'Hadir' ? 'Y' : '' }}</td>
            <td>{{ $absen->status_hadir == 'Hadir Via Zoom' ? 'Y' : '' }}</td>
            <td>{{ $absen->status_hadir == 'Sakit' ? 'Y' : '' }}</td>
            <td>{{ $absen->status_hadir == 'Ijin' ? 'Y' : '' }}</td>
            <td>{{ $absen->status_hadir == 'Alpa' ? 'Y' : '' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>