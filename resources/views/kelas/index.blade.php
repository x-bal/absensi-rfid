@extends('layouts.master', ['title' => 'Data Kelas'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Data Kelas</div>

            <div class="card-body">
                <a href="{{ route('kelas.create') }}" class="btn btn-danger mb-3">Tambah Kelas</a>
                <a href="{{ route('kelas.download') }}" class="btn btn-success mb-3"><i class="fas fa-download"></i> Example Format</a>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($kelas as $kela)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $kela->nama }}</td>
                                <td>
                                    <div class="d-flex">
                                        <button type="button" class="btn btn-sm btn-info btn-import mr-1" data-toggle="modal" data-target="#modalImport" id="{{ $kela->id }}">
                                            <i class="fas fa-upload"></i>
                                        </button>
                                        <a href="{{ route('kelas.show', $kela->id) }}" class="btn btn-sm btn-secondary mr-1"><i class="fas fa-eye"></i></a>
                                        <a href="{{ route('kelas.edit', $kela->id) }}" class="btn btn-sm btn-success mr-1"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('kelas.destroy', $kela->id) }}" method="post" style="display: inline;" class="form-delete">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger btn-delete"><i class="fas fa-trash"></i></button>
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

<!-- Modal import -->
<div class="modal fade" id="modalImport" tabindex="-1" aria-labelledby="modalImportLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalImportLabel">Import Data Siswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('kelas.import') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" class="kelas_id" name="kelas_id" value="">
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
    $(".table").DataTable();

    $(".table").on('click', '.btn-import', function() {
        let id = $(this).attr('id');

        $('.kelas_id').val('');
        $('.kelas_id').val(id);
    })
</script>
@endpush