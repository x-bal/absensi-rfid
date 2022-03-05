@extends('layouts.master', ['title' => 'Dashboard'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card full-height">
            <div class="card-body">
                <div class="card-title">Overall statistics</div>
                <div class="d-flex flex-wrap justify-content-around pb-2 pt-4">
                    <div class="px-2 pb-2 pb-md-0 text-center">
                        <div id="circles-1"></div>
                        <h6 class="fw-bold mt-3 mb-0">Total Kelas</h6>
                    </div>
                    <div class="px-2 pb-2 pb-md-0 text-center">
                        <div id="circles-2"></div>
                        <h6 class="fw-bold mt-3 mb-0">Total Staff</h6>
                    </div>
                    <div class="px-2 pb-2 pb-md-0 text-center">
                        <div id="circles-3"></div>
                        <h6 class="fw-bold mt-3 mb-0">Total Siswa</h6>
                    </div>
                    <div class="px-2 pb-2 pb-md-0 text-center">
                        <div id="circles-4"></div>
                        <h6 class="fw-bold mt-3 mb-0">Total Pengguna</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card full-height">
            <div class="card-body">
                <div class="card-title">Total Absensi</div>
                <div class="card-category">Daily information about statistics in system</div>
                <div class="row py-3">
                    <div class="col-md-4 d-flex flex-column justify-content-around">
                        <div>
                            <h6 class="fw-bold text-uppercase text-success op-8">Total Hadir</h6>
                            <div class="d-flex">
                                <h3 class="fw-bold mr-4">Staff : {{ $hadirStaff + $zoomStaff }}</h3>
                                <h3 class="fw-bold">Siswa : {{ $hadirSiswa + $zoomSiswa }}</h3>
                            </div>
                        </div>
                        <div>
                            <h6 class="fw-bold text-uppercase text-danger op-8">Total Absen</h6>
                            <div class="d-flex">
                                <h3 class="fw-bold mr-4">Staff : {{ $sakitStaff + $ijinStaff + $alpaStaff }}</h3>
                                <h3 class="fw-bold">Siswa : {{ $sakitSiswa + $ijinSiswa + $alpaSiswa }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div id="chart-container">
                            <canvas id="totalIncomeChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card full-height">
            <div class="card-body">
                <div class="card-title">Siswa yang belum absensi</div>
                <div class="card-category">Tanggal {{ Carbon\Carbon::now('Asia/Jakarta')->format('d/m/Y') }}</div>
                <div class="row py-3">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Rfid</th>
                                    <th>Nisn</th>
                                    <th>Kelas</th>
                                    <th>Nama</th>
                                    @can('absensi-siswa-edit')
                                    <th>Action</th>
                                    @endcan
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($siswa as $sw)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $sw->siswa->rfid }}</td>
                                    <td>{{ $sw->siswa->nisn }}</td>
                                    <td>{{ $sw->siswa->kelas->nama }}</td>
                                    <td>{{ $sw->siswa->nama }}</td>
                                    @can('absensi-siswa-edit')
                                    <td>
                                        <a href="{{ route('absensi.edit', $sw->id) }}" class="btn btn-sm btn-success"><i class="fas fa-edit"></i></a>
                                    </td>
                                    @endcan
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@push('script')
<script>
    $(".table").DataTable()

    Circles.create({
        id: 'circles-1',
        radius: 45,
        value: '{{ $totalKelas }}',
        maxValue: '{{ $totalKelas }}',
        width: 10,
        text: '{{ $totalKelas }}',
        colors: ['#f1f1f1', '#FF9E27'],
        duration: 400,
        wrpClass: 'circles-wrp',
        textClass: 'circles-text',
        styleWrapper: true,
        styleText: true
    })

    Circles.create({
        id: 'circles-2',
        radius: 45,
        value: '{{ $totalUser }}',
        maxValue: '{{ $totalUser }}',
        width: 10,
        text: '{{ $totalUser }}',
        colors: ['#f1f1f1', '#2BB930'],
        duration: 400,
        wrpClass: 'circles-wrp',
        textClass: 'circles-text',
        styleWrapper: true,
        styleText: true
    })

    Circles.create({
        id: 'circles-3',
        radius: 45,
        value: '{{ $totalSiswa }}',
        maxValue: '{{ $totalSiswa }}',
        width: 10,
        text: '{{ $totalSiswa }}',
        colors: ['#f1f1f1', '#F25961'],
        duration: 400,
        wrpClass: 'circles-wrp',
        textClass: 'circles-text',
        styleWrapper: true,
        styleText: true
    })

    Circles.create({
        id: 'circles-4',
        radius: 45,
        value: '{{ $totalPengguna }}',
        maxValue: '{{ $totalPengguna }}',
        width: 10,
        text: '{{ $totalPengguna }}',
        colors: ['#f1f1f1', '#1572E8'],
        duration: 400,
        wrpClass: 'circles-wrp',
        textClass: 'circles-text',
        styleWrapper: true,
        styleText: true
    })

    var totalIncomeChart = document.getElementById('totalIncomeChart').getContext('2d');

    var mytotalIncomeChart = new Chart(totalIncomeChart, {
        type: 'bar',
        data: {
            labels: ["Hadir", "Hadir Via Zoom", "Sakit", "Ijin", "Alpa"],
            datasets: [{
                label: "Staff",
                backgroundColor: "#CD1818",
                data: ['{{ $hadirStaff }}', '{{ $zoomStaff }}', '{{ $sakitStaff }}', '{{ $ijinStaff }}', '{{ $alpaStaff }}']
            }, {
                label: "Siswa",
                backgroundColor: "#5463FF",
                data: ['{{ $hadirSiswa }}', '{{ $zoomSiswa }}', '{{ $sakitSiswa }}', '{{ $ijinSiswa }}', '{{ $alpaSiswa }}']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: false,
            },
            scales: {
                yAxes: [{
                    ticks: {
                        display: false //this will remove only the label
                    },
                    gridLines: {
                        drawBorder: false,
                        display: false
                    }
                }],
                xAxes: [{
                    gridLines: {
                        drawBorder: false,
                        display: false
                    }
                }]
            },
        }
    });
</script>
@endpush