@extends('layouts.master', ['title' => 'Data Dump User'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-stats card-danger card-round">
            <div class="card-body">
                <div class="row">
                    <div class="col-2">
                        <div class="icon-big text-center">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                    </div>
                    <div class="col-10 col-stats">
                        <div class="numbers">
                            <h4 class="card-title">Warning</h4>
                            <p class="card-category">
                                Data staff yang dihapus dari sini bersifat permanen & semua data absensi staff juga akan ikut terhapus !
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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

                                        <form action="{{ route('user.delete', $user->id) }}" method="post" class="form-delete">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger btn-delete"><i class="fas fa-times"></i></button>
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

@stop

@push('script')
<script>
    $(".table").DataTable()
</script>
@endpush