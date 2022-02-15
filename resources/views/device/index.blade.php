@extends('layouts.master', ['title' => 'Data Device'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Data Device</div>

            <div class="card-body">
                <a href="{{ route('device.create') }}" class="btn btn-primary mb-3">Tambah Device</a>

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Mode</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($devices as $device)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $device->nama }}</td>
                            <td>{{ $device->mode }}</td>
                            <td>
                                <a href="{{ route('device.edit', $device->id) }}" class="btn btn-sm btn-success"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('device.destroy', $device->id) }}" method="post" style="display: inline;" class="form-delete">
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