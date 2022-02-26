@extends('layouts.master', ['title' => 'Data Absensi Siswa'])

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
            <div class="card-body">
                <form action="" class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="mulai">Mulai</label>
                            <input type="date" name="mulai" id="mulai" class="form-control" value="{{ request('mulai') }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="sampai">Sampai</label>
                            <input type="date" name="sampai" id="sampai" class="form-control" value="{{ request('sampai') }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for=""></label><br>
                            <button type="submit" class="btn btn-sm btn-danger mt-2">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Data Absensi Siswa Masuk Tanggal {{ Carbon\Carbon::now()->format('d/m/Y') }}</div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-masuk table-bordered table-striped" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>No</th>
                                <th>Device</th>
                                <th>Rfid</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Waktu</th>
                                <th>Keterangan</th>
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
            <div class="card-header">Data Absensi Siswa Keluar Tanggal {{ Carbon\Carbon::now()->format('d/m/Y') }}</div>

            <div class="card-body">
                <!-- <a href="{{ route('absensi.create') }}" class="btn btn-primary mb-3">Tambah Absensi</a> -->
                <div class="table-responvie">
                    <table class="table table-keluar table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>No</th>
                                <th>Device</th>
                                <th>Rfid</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Waktu</th>
                                <th>Keterangan</th>
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

<!-- Modal -->
<div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
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
            ajax: "{{ request('mulai') && request('selesai') ? '/absensi/masuk?mulai='.request('mulai').'&sampai='.request('sampai') : route('absensi.masuk') }}",
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
                    data: 'kelas',
                    name: 'kelas'
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
            ajax: "{{ request('mulai') && request('selesai') ? '/absensi/keluar?mulai='.request('mulai').'&sampai='.request('sampai') : route('absensi.keluar') }}",
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
                    data: 'kelas',
                    name: 'kelas'
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