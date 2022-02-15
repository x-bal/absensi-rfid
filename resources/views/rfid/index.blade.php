@extends('layouts.master', ['title' => 'Data Rfid'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Data Rfid</div>

            <div class="card-body">
                <a href="{{ route('rfid.create') }}" class="btn btn-primary mb-3">Tambah Rfid</a>

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Rfid</th>
                            <th>Device</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($rfids as $rfid)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $rfid->rfid }}</td>
                            <td>{{ $rfid->device->nama }}</td>
                            <td>
                                <a href="{{ route('rfid.edit', $rfid->id) }}" class="btn btn-sm btn-success"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('rfid.destroy', $rfid->id) }}" method="post" style="display: inline;" class="form-delete">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger btn-delete"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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