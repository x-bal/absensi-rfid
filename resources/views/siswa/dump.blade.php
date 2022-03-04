@extends('layouts.master', ['title' => 'Data Dump Siswa'])

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
            <div class="card-header">Data Dump Siswa</div>

            <div class="card-body">
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
                            @foreach($siswa as $sw)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="avatar avatar-l">
                                        <img src="{{ asset('/storage/' . $sw->foto) }}" alt="" class="avatar-img rounded-circle">
                                    </div>
                                </td>
                                <td>{{ $sw->rfid }}</td>
                                <td>{{ $sw->nisn }}</td>
                                <td>{{ $sw->nama }}</td>
                                <td>{{ $sw->gender }}</td>
                                <td>{{ $sw->kelas->nama }}</td>
                                <td>
                                    <a href="{{ route('siswa.activated', $sw->id) }}" class="btn btn-sm btn-success" onclick="return confirm('Aktifkan kembali siswa ?')"><i class="fas fa-check"></i></a>
                                </td>
                            </tr>
                            @endforeach
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('.table').DataTable({
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
    });
</script>
@endpush