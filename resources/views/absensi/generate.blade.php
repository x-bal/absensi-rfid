<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Nisn</th>
            <th>Nama</th>
            @if($act == 'export' && $from != '' && $to != '')
            @foreach (Carbon\CarbonPeriod::create($from, $to) as $date)
            <th>{{ $date->format('d/m/y') }}</th>
            @endforeach
            @endif
            <th>Hadir</th>
            <th>Hadir Via Zoom</th>
            <th>Sakit</th>
            <th>Ijin</th>
            <th>Alpa</th>
        </tr>
    </thead>

    @if(request('kelas'))
    <tbody>
        @php
        $hadir = 0;
        $zoom = 0;
        $sakit = 0;
        $ijin = 0;
        $alpa = 0;
        @endphp
        @foreach($siswa as $sw)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $sw->nisn }}</td>
            <td>{{ $sw->nama }}</td>
            @if($act == 'export' && $from != '' && $to != '')
            @foreach (Carbon\CarbonPeriod::create($from, $to) as $date)
            <td class="text-center">
                {{ $sw->absensi->where('created_at', '>=', $date->format('Y-m-d 00:00:00'))->where('created_at', '<', $date->addDay(1)->format('Y-m-d 00:00:00'))->first()->status_hadir ?? '-' }}
            </td>
            @endforeach
            @endif
            <td class="text-center">
                {{ $sw->absensi->whereBetween('created_at', [$from, Carbon\Carbon::parse($to)->addDay(1)->format('Y-m-d 00:00:00')])->where('status_hadir', 'Hadir')->count() }}
            </td>
            <td class="text-center">
                {{ $sw->absensi->whereBetween('created_at', [$from, Carbon\Carbon::parse($to)->addDay(1)->format('Y-m-d 00:00:00')])->where('status_hadir', 'Hadir Via Zoom')->count() }}
            </td>
            <td class="text-center">
                {{ $sw->absensi->whereBetween('created_at', [$from, Carbon\Carbon::parse($to)->addDay(1)->format('Y-m-d 00:00:00')])->where('status_hadir', 'Sakit')->count() }}
            </td>
            <td class="text-center">
                {{ $sw->absensi->whereBetween('created_at', [$from, Carbon\Carbon::parse($to)->addDay(1)->format('Y-m-d 00:00:00')])->where('status_hadir', 'Ijin')->count() }}
            </td>
            <td class="text-center">
                {{ $sw->absensi->whereBetween('created_at', [$from, Carbon\Carbon::parse($to)->addDay(1)->format('Y-m-d 00:00:00')])->where('status_hadir', 'Alpa')->count() }}
            </td>
            @php
            $hadir += $sw->absensi->whereBetween('created_at', [$from, Carbon\Carbon::parse($to)->addDay(1)->format('Y-m-d 00:00:00')])->where('status_hadir', 'Hadir')->count();

            $zoom += $sw->absensi->whereBetween('created_at', [$from, Carbon\Carbon::parse($to)->addDay(1)->format('Y-m-d 00:00:00')])->where('status_hadir', 'Hadir Via Zoom')->count();

            $sakit += $sw->absensi->whereBetween('created_at', [$from, Carbon\Carbon::parse($to)->addDay(1)->format('Y-m-d 00:00:00')])->where('status_hadir', 'Sakit')->count();

            $ijin += $sw->absensi->whereBetween('created_at', [$from, Carbon\Carbon::parse($to)->addDay(1)->format('Y-m-d 00:00:00')])->where('status_hadir', 'Ijin')->count();

            $alpa += $sw->absensi->whereBetween('created_at', [$from, Carbon\Carbon::parse($to)->addDay(1)->format('Y-m-d 00:00:00')])->where('status_hadir', 'Alpa')->count();
            @endphp
        </tr>
        @endforeach
    </tbody>
    @if($act == 'export' && $from != '' && $to != '')
    <tfoot>
        <tr>
            <th colspan="{{ Carbon\Carbon::parse(request('to'))->diffInDays(Carbon\Carbon::parse(request('from'))) + 4 }}">Total</th>
            <th class="text-center">{{ $hadir }}</th>
            <th class="text-center">{{ $zoom }}</th>
            <th class="text-center">{{ $sakit }}</th>
            <th class="text-center">{{ $ijin }}</th>
            <th class="text-center">{{ $alpa }}</th>
        </tr>
    </tfoot>
    @endif
    @endif
</table>