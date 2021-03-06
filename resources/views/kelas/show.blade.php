@extends('layouts.master', ['title' => 'Data Siswa Kelas ' . $kela->nama])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div>
                    Data Siswa Kelas {{ $kela->nama }}
                </div>
                <a href="{{ route('kelas.index') }}" class="btn btn-sm btn-default"><i class="fas fa-arrow-left"></i> Kembali</a>
            </div>

            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <form action="{{ route('kelas.kenaikan', $kela->id) }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="naik_kelas">Naik ke Kelas</label>
                                        <select name="kelas" id="kelas" class="form-control">
                                            <option disabled selected>-- Naik ke Kelas --</option>
                                            @foreach($kelas as $kls)
                                            <option {{ $kls->id == $kela->id ? 'selected': '' }} value="{{ $kls->id }}">{{ $kls->nama }}</option>
                                            @endforeach
                                            <option value="Lulus">Lulus</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-danger mt-4">Submit</button>
                                    </div>
                                </div>
                            </div>

                            <div class="form-target"></div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    <input class="form-check-input" type="checkbox" id="check-all">
                                </th>
                                <th>No</th>
                                <th>Rfid</th>
                                <th>Nisn</th>
                                <th>Nama</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($kela->siswa->where('is_active', 1) as $siswa)
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" class="form-check-input check-siswa" data-id="{{ $siswa->id }}">
                                </td>
                                <td>{{ $loop->iteration }}</td>
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
@stop

@push('script')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#check-all").click(function() {
        $('input:checkbox').not(this).prop('checked', this.checked);

        var ischecked = $(this).is(':checked');
        let id = '{{ $kela->id }}';

        if (ischecked == true) {
            $.ajax({
                url: '{{ route("kelas.siswa") }}',
                type: 'GET',
                data: {
                    id: id
                },
                success: function(response) {
                    $('.form-target').empty()
                    $.each(response.siswas, function(index, item) {
                        $('.form-target').append('<input type="hidden" name="id[]" id="' + item.id + '" value="' + item.id + '"/>');
                    });
                }
            })
        } else {
            $.ajax({
                url: '{{ route("kelas.siswa") }}',
                type: 'GET',
                data: {
                    id: id
                },
                success: function(response) {
                    $.each(response.siswas, function(index, item) {
                        $('#' + item.id).remove();
                    });
                }
            })
        }
    });

    $('.table').on('click', '.check-siswa', function() {
        var ischecked = $(this).is(':checked');
        let id = $(this).attr('data-id')
        console.log(id)
        if (ischecked == false) {
            $('#' + id).remove();
        } else {
            $('.form-target').append('<input type="hidden" name="id[]" id="' + id + '" value="' + id + '"/>');
        }
    })

    $(".table").DataTable();

    $(".btn-import").on('click', function() {
        let id = $(this).attr('id');

        $('.kelas_id').val('');
        $('.kelas_id').val(id);
    })
</script>
@endpush