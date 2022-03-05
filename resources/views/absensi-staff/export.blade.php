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
            <td>
                @if(Carbon\Carbon::parse($absen->created_at)->format('l') == 'Monday')
                {{ $absen->status_hadir == 'Hadir' ? 'Y' : '' }}
                {{ $absen->status_hadir == 'Hadir Via Zoom' ? 'Z' : '' }}
                {{ $absen->status_hadir == 'Sakit' ? 'S' : '' }}
                {{ $absen->status_hadir == 'Ijin' ? 'I' : '' }}
                {{ $absen->status_hadir == 'Alpa' ? 'A' : '' }}
                @endif
            </td>
            <td>
                @if(Carbon\Carbon::parse($absen->created_at)->format('l') == 'Tuesday')
                {{ $absen->status_hadir == 'Hadir' ? 'Y' : '' }}
                {{ $absen->status_hadir == 'Hadir Via Zoom' ? 'Z' : '' }}
                {{ $absen->status_hadir == 'Sakit' ? 'S' : '' }}
                {{ $absen->status_hadir == 'Ijin' ? 'I' : '' }}
                {{ $absen->status_hadir == 'Alpa' ? 'A' : '' }}
                @endif
            </td>
            <td>
                @if(Carbon\Carbon::parse($absen->created_at)->format('l') == 'Wednesday')
                {{ $absen->status_hadir == 'Hadir' ? 'Y' : '' }}
                {{ $absen->status_hadir == 'Hadir Via Zoom' ? 'Z' : '' }}
                {{ $absen->status_hadir == 'Sakit' ? 'S' : '' }}
                {{ $absen->status_hadir == 'Ijin' ? 'I' : '' }}
                {{ $absen->status_hadir == 'Alpa' ? 'A' : '' }}
                @endif
            </td>
            <td>
                @if(Carbon\Carbon::parse($absen->created_at)->format('l') == 'Thursday')
                {{ $absen->status_hadir == 'Hadir' ? 'Y' : '' }}
                {{ $absen->status_hadir == 'Hadir Via Zoom' ? 'Z' : '' }}
                {{ $absen->status_hadir == 'Sakit' ? 'S' : '' }}
                {{ $absen->status_hadir == 'Ijin' ? 'I' : '' }}
                {{ $absen->status_hadir == 'Alpa' ? 'A' : '' }}
                @endif
            </td>
            <td>
                @if(Carbon\Carbon::parse($absen->created_at)->format('l') == 'Friday')
                {{ $absen->status_hadir == 'Hadir' ? 'Y' : '' }}
                {{ $absen->status_hadir == 'Hadir Via Zoom' ? 'Z' : '' }}
                {{ $absen->status_hadir == 'Sakit' ? 'S' : '' }}
                {{ $absen->status_hadir == 'Ijin' ? 'I' : '' }}
                {{ $absen->status_hadir == 'Alpa' ? 'A' : '' }}
                @endif
            </td>
            <td>
                @if(Carbon\Carbon::parse($absen->created_at)->format('l') == 'Saturday')
                {{ $absen->status_hadir == 'Hadir' ? 'Y' : '' }}
                {{ $absen->status_hadir == 'Hadir Via Zoom' ? 'Z' : '' }}
                {{ $absen->status_hadir == 'Sakit' ? 'S' : '' }}
                {{ $absen->status_hadir == 'Ijin' ? 'I' : '' }}
                {{ $absen->status_hadir == 'Alpa' ? 'A' : '' }}
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>