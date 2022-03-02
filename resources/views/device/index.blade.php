@extends('layouts.master', ['title' => 'Data Device'])

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
            <div class="card-header">Data Device</div>

            <div class="card-body">
                <a href="{{ route('device.create') }}" class="btn btn-danger mb-3">Tambah Device</a>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Id Device</th>
                                <th>Nama</th>
                                <th>Mode</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($devices as $device)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $device->id }}</td>
                                <td>{{ $device->nama }}</td>
                                <td class="text-center text-light">
                                    <input type="checkbox" class="mode" id="{{ $device->id }}" value="{{ $device->mode == 'SCAN' ? 'ADD' : 'SCAN' }}" {{ $device->mode == 'SCAN' ? 'checked' : '' }}>
                                </td>
                                <td>
                                    <a href="{{ route('device.edit', $device->id) }}" class="btn btn-sm btn-success"><i class="fas fa-edit"></i></a>
                                    <!-- <form action="{{ route('device.destroy', $device->id) }}" method="post" style="display: inline;" class="form-delete">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger btn-delete"><i class="fas fa-trash"></i></button>
                                    </form> -->
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
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(".table").DataTable();

        $('.mode').bootstrapToggle({
            on: 'Scan',
            off: 'Add',
            style: 'ios',
            size: 'sm',
        })

        $('.mode').change(function() {
            let id = $(this).attr("id")
            $.ajax({
                method: 'POST',
                type: 'POST',
                url: 'device/' + id + '/change',
                data: {
                    mode: $(this).val()
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
                }
            })

        })
    })
</script>
@endpush