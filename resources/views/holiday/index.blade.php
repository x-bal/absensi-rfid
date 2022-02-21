@extends('layouts.master', ['title' => 'Data Holiday'])

@push('style')
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">

<style>
    .toggle.ios,
    .toggle-on.ios,
    .toggle-off.ios {
        border-radius: 20rem;
    }

    .toggle.ios .toggle-handle {
        border-radius: 20rem;
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Data Holiday</div>

            <div class="card-body">
                <a href="{{ route('holiday.create') }}" class="btn btn-primary mb-3">Tambah Holiday</a>

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Waktu</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($holidays as $holiday)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $holiday->nama }}</td>
                            <td>{{ Carbon\Carbon::parse($holiday->waktu)->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('holiday.edit', $holiday->id) }}" class="btn btn-sm btn-success"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('holiday.destroy', $holiday->id) }}" method="post" style="display: inline;" class="form-delete">
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
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(".table").DataTable();
    })
</script>
@endpush