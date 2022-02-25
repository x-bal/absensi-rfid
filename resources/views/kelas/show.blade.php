@extends('layouts.master', ['title' => 'Data Siswa Kelas ' . $kela->nama])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Data Siswa Kelas {{ $kela->nama }}</div>

            <div class="card-body">
                <a href="{{ route('kelas.index') }}" class="btn btn-secondary mb-3"><i class="fas fa-arrow-left"></i> Kembali</a>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Device</th>
                                <th>Rfid</th>
                                <th>Nisn</th>
                                <th>Nama</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($kela->siswa as $siswa)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $siswa->device->nama ?? '' }}</td>
                                <td>{{ $siswa->rfid }}</td>
                                <td>{{ $siswa->nisn }}</td>
                                <td>{{ $siswa->nama }}</td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('siswa.edit', $siswa->id) }}" class="btn btn-sm btn-success mr-1"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('siswa.destroy', $siswa->id) }}" method="post" style="display: inline;" class="form-delete">
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

    $(".btn-import").on('click', function() {
        let id = $(this).attr('id');

        $('.kelas_id').val('');
        $('.kelas_id').val(id);
    })
</script>
@endpush