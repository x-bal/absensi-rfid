<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Tanggal</th>
            <th>Mon</th>
            <th>Tue</th>
            <th>Wed</th>
            <th>Thu</th>
            <th>Fri</th>
            <th>Sat</th>
            <th>Jam Masuk</th>
            <th>Jam Pulang</th>
        </tr>
    </thead>

    <tbody>
        @foreach($absensi as $absen)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $absen->staff->nama }}</td>
            <td>{{ Carbon\Carbon::parse($absen->created_at)->format('d/m/Y') }}</td>
            <td>
                {{ $absen->status_hadir }} ({{$absen->ket}})
            </td>
            <td>
                {{ $absen->status_hadir }} ({{$absen->ket}})
            </td>
            <td>
                {{ $absen->status_hadir }} ({{$absen->ket}})
            </td>
            <td>
                {{ $absen->status_hadir }} ({{$absen->ket}})
            </td>
            <td>
                {{ $absen->status_hadir }} ({{$absen->ket}})
            </td>
            <td>
                {{ $absen->status_hadir }} ({{$absen->ket}})
            </td>
            <td>
                {{ $absen->masuk == 1 ? Carbon\Carbon::parse($absen->waktu_masuk)->format('d/m/Y H:i:s') : '-' }}
            </td>
            <td>
                {{ $absen->keluar == 1 ? Carbon\Carbon::parse($absen->waktu_keluar)->format('d/m/Y H:i:s') : '-' }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>