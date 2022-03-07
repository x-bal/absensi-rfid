@extends('layouts.master', ['title' => 'Master Jadwal'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Master Jadwal</div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
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
                                <td>{{ $jdl->staff->jabatan }}</td>
                                <td class="text-center">
                                    <input type="checkbox" class="day" id="{{ $jdl->id }}" data-day="monday" {{ $jdl->monday == 1 ? 'checked' : '' }}>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" class="day" id="{{ $jdl->id }}" data-day="tuesday" {{ $jdl->tuesday == 1 ? 'checked' : '' }}>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" class="day" id="{{ $jdl->id }}" data-day="wednesday" {{ $jdl->wednesday == 1 ? 'checked' : '' }}>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" class="day" id="{{ $jdl->id }}" data-day="thursday" {{ $jdl->thursday == 1 ? 'checked' : '' }}>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" class="day" id="{{ $jdl->id }}" data-day="friday" {{ $jdl->friday == 1 ? 'checked' : '' }}>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" class="day" id="{{ $jdl->id }}" data-day="saturday" {{ $jdl->saturday == 1 ? 'checked' : '' }}>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('jadwal.edit', $jdl->id) }}" class="btn btn-sm btn-success mr-1"><i class="fas fa-edit"></i></a>
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

    $(".table").DataTable()

    $(".table").on('click', '.day', function() {
        let id = $(this).attr('id')
        let day = $(this).attr('data-day')
        console.log(id)
        $.ajax({
            url: '{{ route("jadwal.set") }}',
            type: 'GET',
            data: {
                id: id,
                day: day
            },
            success: function(response) {
                swal("Selamat!", response.message, {
                    icon: "success",
                    buttons: {
                        confirm: {
                            className: 'btn btn-success'
                        }
                    },
                });
            },
        })
    })
</script>
@endpush