@extends('layouts.master', ['title' => 'Data Kelas'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Data Kelas</div>

            <div class="card-body">
                <a href="{{ route('kelas.create') }}" class="btn btn-primary mb-3">Tambah Kelas</a>

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($kelas as $kela)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $kela->nama }}</td>
                            <td>
                                <a href="{{ route('kelas.edit', $kela->id) }}" class="btn btn-sm btn-success"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('kelas.destroy', $kela->id) }}" method="post" style="display: inline;" class="form-delete">
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