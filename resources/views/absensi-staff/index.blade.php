@extends('layouts.master', ['title' => 'Data Absensi Staff'])

@push('style')
<!-- Datatable -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.7/css/fixedHeader.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.bootstrap4.min.css">
@endpush

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Data Absensi Staff Masuk Tanggal {{ Carbon\Carbon::now()->format('d/m/Y') }}</div>

            <div class="card-body">
                <!-- <a href="{{ route('absensi.create') }}" class="btn btn-primary mb-3">Tambah Absensi</a> -->

                <div class="table-responsive">
                    <table class="table table-masuk table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>No</th>
                                <th>Device</th>
                                <th>Rfid</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Waktu</th>
                                <th>Ket</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Data Absensi Staff Keluar Tanggal {{ Carbon\Carbon::now()->format('d/m/Y') }}</div>

            <div class="card-body">
                <!-- <a href="{{ route('absensi.create') }}" class="btn btn-primary mb-3">Tambah Absensi</a> -->

                <div class="table-responsive">
                    <table class="table table-keluar table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>No</th>
                                <th>Device</th>
                                <th>Rfid</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Waktu</th>
                                <th>Ket</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@push('script')
<!-- Datatable -->
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.1.7/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.6/js/responsive.bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        var table = $('.table-masuk').DataTable({
            processing: true,
            serverSide: true,
            orderable: true,
            searchable: true,
            ajax: "{{ route('absensi-staff.masuk') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'device',
                    name: 'device'
                },
                {
                    data: 'rfid',
                    name: 'rfid'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'jabatan',
                    name: 'jabatan'
                },
                {
                    data: 'waktu',
                    name: 'waktu'
                },
                {
                    data: 'status_hadir',
                    name: 'status_hadir'
                },
                {
                    data: 'action',
                    name: 'action'
                },
            ],
            responsive: {
                details: {
                    type: 'column'
                }
            },
            columnDefs: [{
                className: 'dtr-control',
                responsivePriority: 1,
                targets: 0
            }, ]
        });

        var tableKeluar = $('.table-keluar').DataTable({
            processing: true,
            serverSide: true,
            orderable: true,
            searchable: true,
            ajax: "{{ route('absensi-staff.keluar') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'device',
                    name: 'device'
                },
                {
                    data: 'rfid',
                    name: 'rfid'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'jabatan',
                    name: 'jabatan'
                },
                {
                    data: 'waktu',
                    name: 'waktu'
                },
                {
                    data: 'status_hadir',
                    name: 'status_hadir'
                },
                {
                    data: 'action',
                    name: 'action'
                },
            ],
            responsive: {
                details: {
                    type: 'column'
                }
            },
            columnDefs: [{
                className: 'dtr-control',
                responsivePriority: 1,
                targets: 0
            }, ]
        });

        new $.fn.dataTable.FixedHeader(table);
        new $.fn.dataTable.FixedHeader(tableKeluar);
    });
</script>
@endpush