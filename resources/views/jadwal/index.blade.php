@extends('layouts.master', ['title' => 'Master Jadwal'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Master Jadwal</div>

            <div class="card-body">
                <a href="{{ route('jadwal.create') }}" class="btn btn-primary mb-3">Tambah Jadwal</a>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Mon</th>
                                <th>Tue</th>
                                <th>Wed</th>
                                <th>Thu</th>
                                <th>Fri</th>
                                <th>Sat</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($jadwal as $jdl)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $jdl->staff->nama }}</td>
                                <td>{{ $jdl->monday }}</td>
                                <td>{{ $jdl->tuesday }}</td>
                                <td>{{ $jdl->wednesday }}</td>
                                <td>{{ $jdl->thursday }}</td>
                                <td>{{ $jdl->friday }}</td>
                                <td>{{ $jdl->saturday }}</td>
                                <td>
                                    <a href="{{ route('jadwal.edit', $jdl->id) }}" class="btn btn-sm btn-success"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('jadwal.destroy', $jdl->id) }}" method="post" style="display: inline;" class="form-delete">
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
</div>
@stop

@push('script')
<script>
    $(".table").DataTable()
</script>
@endpush