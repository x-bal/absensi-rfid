@extends('layouts.master', ['title' => 'Edit Siswa'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Edit Siswa</div>

            <div class="card-body">
                <form action="{{ route('siswa.update', $siswa->id) }}" method="post" enctype="multipart/form-data">
                    @method('PATCH')
                    @csrf
                    @include('siswa.form')
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@push('script')
<script>
    setTimeout(function() {
        $.ajax({
            method: 'GET',
            type: 'GET',
            url: '{{ route("rfid.show", 1) }}',
            success: function(response) {
                $("#rfid").val(response.rfid.rfid)
            }
        })
    }, 2000)
</script>
@endpush