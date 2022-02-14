@extends('layouts.master', ['title' => 'Data Permission'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Data Permission</div>

            <div class="card-body">
                <a href="{{ route('permission.create') }}" class="btn btn-primary mb-3">Tambah Permission</a>

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($permissions as $permission)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $permission->name }}</td>
                            <td>
                                <a href="{{ route('permission.edit', $permission->id) }}" class="btn btn-sm btn-success"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('permission.destroy', $permission->id) }}" method="post" style="display: inline;" class="form-delete">
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