@extends('layouts.master', ['title' => 'Data Rfid Baru'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Data Rfid Baru</div>

            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Rfid</th>
                                <th>Device</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($rfids as $rfid)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $rfid->rfid }}</td>
                                <td>{{ $rfid->device->nama ?? 'Device tidak ditemukan' }}</td>
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
<script>
    $(".table").DataTable()
</script>
@endpush