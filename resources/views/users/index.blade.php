@extends('layouts.master', ['title' => 'Data User Aktif'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Data User Aktif</div>

            <div class="card-body">
                <a href="{{ route('user.create') }}" class="btn btn-danger mb-3">Tambah User</a>
                <a href="{{ route('user.download') }}" class="btn btn-success mb-3"><i class="fas fa-download"></i> Example Format</a>
                <button type="button" class="btn mb-3 btn-info btn-import" data-toggle="modal" data-target="#modalImport">
                    <i class="fas fa-upload"></i> Import
                </button>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>RFID</th>
                                <th>Username</th>
                                <th>West ID</th>
                                <th>Nama</th>
                                <th>Jabatan / Role</th>
                                <th>Access Login</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td class="{{ $user->is_login == 0 ? 'text-danger' : '' }}">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="avatar avatar-l">
                                        <img src="{{ asset('storage/' . $user->foto ) }}" alt="" class="avatar-img rounded-circle">
                                    </div>
                                </td>
                                <td class="{{ $user->is_login == 0 ? 'text-danger' : '' }}">{{ $user->rfid }}</td>
                                <td class="{{ $user->is_login == 0 ? 'text-danger' : '' }}">{{ $user->username }}</td>
                                <td class="{{ $user->is_login == 0 ? 'text-danger' : '' }}">{{ $user->nik }}</td>
                                <td class="{{ $user->is_login == 0 ? 'text-danger' : '' }}">{{ $user->nama }}</td>
                                <td class="{{ $user->is_login == 0 ? 'text-danger' : '' }}">{{ $user->jabatan }} / {{ $user->roles()->first()->name ?? '-' }}</td>
                                <td class="text-center">
                                    <input type="checkbox" id="{{ $user->id }}" class="islogin" {{ $user->is_login == 1 ? 'checked' : '' }}>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-sm btn-success mr-1"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('user.destroy', $user->id) }}" method="post" class="form-delete">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm btn-delete"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
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

<div class="modal fade" id="modalImport" tabindex="-1" aria-labelledby="modalImportLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalImportLabel">Import Data Staff</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('user.import') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-gruop">
                        <label for="file">File Excel</label>
                        <input type="file" name="file" id="file" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@push('script')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(".table").DataTable()

    $(".islogin").on('click', function() {
        let id = $(this).attr('id')
        $.ajax({
            url: '{{ route("user.islogin") }}',
            type: 'GET',
            data: {
                id: id,
            },
            success: function(response) {
                swal("Selamat!", response.message, {
                    icon: "success",
                    buttons: {
                        confirm: {
                            className: 'btn btn-success'
                        }
                    },
                });
            },
        })
    })
</script>
@endpush