@extends('layouts.master', ['title' => 'Data Siswa'])

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
            <div class="card-header">Data Siswa</div>

            <div class="card-body">
                <a href="{{ route('siswa.create') }}" class="btn btn-danger mb-3">Tambah Siswa</a>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>No</th>
                                <th>Foto</th>
                                <th>RFID</th>
                                <th>Nisn</th>
                                <th>Nama</th>
                                <th>Gender</th>
                                <th>Kelas</th>
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
<script src=" https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js">
</script>
<script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.1.7/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.6/js/responsive.bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        var table = $('.table').DataTable({
            processing: true,
            serverSide: true,
            orderable: true,
            searchable: true,
            ajax: "{{ route('siswa.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'foto',
                    name: 'foto'
                },
                {
                    data: 'rfid',
                    name: 'rfid'
                },
                {
                    data: 'nisn',
                    name: 'nisn'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'gender',
                    name: 'gender'
                },
                {
                    data: 'kelas',
                    name: 'kelas'
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

        $('.btn-delete').click(function(e) {
            e.preventDefault();
            swal({
                title: 'Hapus data?',
                text: "Data yang dihapus bersifat permanen!",
                type: 'warning',
                buttons: {
                    confirm: {
                        text: 'Ya, Hapus!',
                        className: 'btn btn-success'
                    },
                    cancel: {
                        text: 'Batal',
                        visible: true,
                        className: 'btn btn-danger'
                    }
                }
            }).then((response) => {
                if (response) {
                    $(".form-delete").submit()
                } else {
                    swal.close();
                }
            });
        });
    });
</script>
@endpush