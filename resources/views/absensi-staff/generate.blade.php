<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Westin ID</th>
            <th>Nama</th>
            @if($act == 'export' && $from != '' && $to != '')
            @foreach (Carbon\CarbonPeriod::create($from, $to) as $date)
            <th>{{ $date->format('d/m/y') }}</th>
            @endforeach
            @endifach
            @endif
            <th>Hadir</th>
            <th>Hadir Via Zoom</th>
            <th>Sakit</th>
            <th>Ijin</th>
            <th>Alpa</th>
            @if($act != 'export')
            <th>Action</th>
            @endif
        </tr>
    </thead>

    <tbody>
        @php
        $hadir = 0;
        $zoom = 0;
        $sakit = 0;
        $ijin = 0;
        $alpa = 0;
        @endphp
        @foreach($staff as $stf)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $stf->nik }}</td>
            <td>{{ $stf->nama }}</td>
            @if($act == 'export' && $from != '' && $to != '')
            @foreach (Carbon\CarbonPeriod::create($from, $to) as $date)
            <td class="text-center">
                {{ $stf->absensiStaff->where('created_at', '>=', $date->format('Y-m-d 00:00:00'))->where('created_at', '<', $date->addDay(1)->format('Y-m-d 00:00:00'))->first()->status_hadir ?? '-' }}
            </td>
            @endforeach
            @endif
            <td class="text-center">
                {{ $stf->absensiStaff->whereBetween('created_at', [$from, Carbon\Carbon::parse($to)->addDay(1)->format('Y-m-d 00:00:00')])->where('status_hadir', 'Hadir')->count() }}
            </td>
            <td class="text-center">
                {{ $stf->absensiStaff->whereBetween('created_at', [$from, Carbon\Carbon::parse($to)->addDay(1)->format('Y-m-d 00:00:00')])->where('status_hadir', 'Hadir Via Zoom')->count() }}
            </td>
            <td class="text-center">
                {{ $stf->absensiStaff->whereBetween('created_at', [$from, Carbon\Carbon::parse($to)->addDay(1)->format('Y-m-d 00:00:00')])->where('status_hadir', 'Sakit')->count() }}
            </td>
            <td class="text-center">
                {{ $stf->absensiStaff->whereBetween('created_at', [$from, Carbon\Carbon::parse($to)->addDay(1)->format('Y-m-d 00:00:00')])->where('status_hadir', 'Ijin')->count() }}
            </td>
            <td class="text-center">
                {{ $stf->absensiStaff->whereBetween('created_at', [$from, Carbon\Carbon::parse($to)->addDay(1)->format('Y-m-d 00:00:00')])->where('status_hadir', 'Alpa')->count() }}
            </td>
            @php
            $hadir += $stf->absensiStaff->whereBetween('created_at', [$from, Carbon\Carbon::parse($to)->addDay(1)->format('Y-m-d 00:00:00')])->where('status_hadir', 'Hadir')->count();

            $zoom += $stf->absensiStaff->whereBetween('created_at', [$from, Carbon\Carbon::parse($to)->addDay(1)->format('Y-m-d 00:00:00')])->where('status_hadir', 'Hadir Via Zoom')->count();

            $sakit += $stf->absensiStaff->whereBetween('created_at', [$from, Carbon\Carbon::parse($to)->addDay(1)->format('Y-m-d 00:00:00')])->where('status_hadir', 'Sakit')->count();

            $ijin += $stf->absensiStaff->whereBetween('created_at', [$from, Carbon\Carbon::parse($to)->addDay(1)->format('Y-m-d 00:00:00')])->where('status_hadir', 'Ijin')->count();

            $alpa += $stf->absensiStaff->whereBetween('created_at', [$from, Carbon\Carbon::parse($to)->addDay(1)->format('Y-m-d 00:00:00')])->where('status_hadir', 'Alpa')->count();
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
</table>