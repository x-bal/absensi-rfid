@extends('layouts.master', ['title' => 'Data Siswa'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Data Siswa</div>

            <div class="card-body">
                <a href="{{ route('siswa.create') }}" class="btn btn-primary mb-3">Tambah Siswa</a>

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>Device</th>
                            <th>RFID</th>
                            <th>Nisn</th>
                            <th>Nama</th>
                            <th>Gender</th>
                            <th>Kelas</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($siswas as $siswa)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="avatar avatar-l">
                                    <img src="{{ asset('storage/' . $siswa->foto ) }}" alt="" class="avatar-img rounded-circle">
                                </div>
                            </td>
                            <td>{{ $siswa->device->nama ?? '' }} {{ $siswa->device->id ?? '' }}</td>
                            <td>{{ $siswa->rfid }}</td>
                            <td>{{ $siswa->nisn }}</td>
                            <td>{{ $siswa->nama }}</td>
                            <td>{{ $siswa->gender }}</td>
                            <td>{{ $siswa->kelas->nama }}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('siswa.edit', $siswa->id) }}" class="btn btn-sm btn-success mr-1"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('siswa.destroy', $siswa->id) }}" method="post" class="form-delete">
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
@stop

@push('script')
<script>
    $(".table").DataTable()
</script>
@endpush