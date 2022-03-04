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
            <div class="card-body">
                <div class="row">
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
                            <button type="submit" class="btn btn-sm btn-danger btn-submit mt-2">Submit</button>
                            <a href="{{ route('absensi-staff.export') }}" class="btn btn-sm btn-success link mt-2"><i class="fas fa-file-excel"></i> Export</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Data Absensi Staff Masuk Tanggal {{ Carbon\Carbon::now()->format('d/m/Y') }}</div>

            <div class="card-body">
                <!-- <a href="{{ route('absensi.create') }}" class="btn btn-primary mb-3">Tambah Absensi</a> -->

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>No</th>
                                <th>Device</th>
                                <th>Rfid</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Masuk</th>
                                <th>Keluar</th>
                                <th>Kehadiran</th>
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
        function loadData(mulai = '', sampai = '') {
            var table = $('.table').DataTable({
                processing: true,
                serverSide: true,
                orderable: true,
                searchable: true,
                ajax: {
                    url: "{{ route('absensi-staff.index') }}",
                    data: {
                        mulai: mulai,
                        sampai: sampai,
                    }
                },
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
                        data: 'waktu_masuk',
                        name: 'waktu_masuk'
                    },
                    {
                        data: 'waktu_keluar',
                        name: 'waktu_keluar'
                    },
                    {
                        data: 'status_hadir',
                        name: 'status_hadir'
                    },
                    {
                        data: 'ket',
                        name: 'ket'
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
        }

        setInterval(loadData(), 2000)

        $('.btn-submit').click(function() {
            var mulai = $('#mulai').val();
            var sampai = $('#sampai').val();
            console.log(mulai)
            if (mulai != '' && sampai != '') {
                $('.table').DataTable().destroy();
                loadData(mulai, sampai);
                $(".link").attr('href', '{{ route("absensi-staff.export") }}?mulai=' + mulai + '&sampai=' + sampai)
            } else {
                alert('Pilih Tanggal');
            }
        });
    });
</script>
@endpush