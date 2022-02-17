@extends('layouts.master', ['title' => 'Data User'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Data User</div>

            <div class="card-body">
                <a href="{{ route('user.create') }}" class="btn btn-primary mb-3">Tambah User</a>

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>Device</th>
                            <th>RFID</th>
                            <th>Username</th>
                            <th>Nik</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="avatar avatar-l">
                                    <img src="{{ asset('storage/' . $user->foto ) }}" alt="" class="avatar-img rounded-circle">
                                </div>
                            </td>
                            <td>{{ $user->device->nama ?? '' }} ({{ $user->device->id ?? '' }})</td>
                            <td>{{ $user->rfid }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->nik }}</td>
                            <td>{{ $user->nama }}</td>
                            <td>{{ $user->jabatan }}</td>
                            <td>
                                <a href="{{ route('user.edit', $user->id) }}" class="btn btn-sm btn-success"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('user.destroy', $user->id) }}" method="post" style="display: inline;" class="form-delete">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm btn-delete"><i class="fas fa-trash"></i></button>
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