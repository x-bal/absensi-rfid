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
        </tr>
    </thead>

    <tbody>
        @foreach($absensi as $absen)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $absen->staff->nama }}</td>
            <td>{{ Carbon\Carbon::parse($absen->created_at)->format('d/m/Y') }}</td>
            <td>{{ Carbon\Carbon::parse($absen->created_at)->format('l') == 'Monday' ? 'Y' : '' }}</td>
            <td>{{ Carbon\Carbon::parse($absen->created_at)->format('l') == 'Tuesday' ? 'Y' : '' }}</td>
            <td>{{ Carbon\Carbon::parse($absen->created_at)->format('l') == 'Wednesday' ? 'Y' : '' }}</td>
            <td>{{ Carbon\Carbon::parse($absen->created_at)->format('l') == 'Thursday' ? 'Y' : '' }}</td>
            <td>{{ Carbon\Carbon::parse($absen->created_at)->format('l') == 'Friday' ? 'Y' : '' }}</td>
            <td>{{ Carbon\Carbon::parse($absen->created_at)->format('l') == 'Saturday' ? 'Y' : '' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>