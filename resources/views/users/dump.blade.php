@extends('layouts.master', ['title' => 'Data Dump User'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Data Dump User</div>

            <div class="card-body">
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
                                <td>{{ $user->rfid }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->nik }}</td>
                                <td>{{ $user->nama }}</td>
                                <td>{{ $user->jabatan }}</td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('user.status', $user->id) }}" class="btn btn-sm btn-success mr-1" onclick="return confirm('Aktifkan kembali User?')"><i class="fas fa-check"></i></a>
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
    $(".table").DataTable()
</script>
@endpush