@extends('layouts.master', ['title' => 'History Alat'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">History Alat</div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Rfid</th>
                                <th>Device</th>
                                <th>Keterangan</th>
                                <th>Waktu</th>
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
<script>
    $(".table").DataTable({
        processing: true,
        serverSide: true,
        orderable: true,
        searchable: true,
        ajax: "{{ route('history.index') }}",
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'rfid',
                name: 'rfid'
            },
            {
                data: 'device',
                name: 'device'
            },
            {
                data: 'keterangan',
                name: 'keterangan'
            },
            {
                data: 'waktu',
                name: 'waktu'
            },
        ]
    })
</script>
@endpush