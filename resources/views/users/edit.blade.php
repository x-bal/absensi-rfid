@extends('layouts.master', ['title' => 'Edit User'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Edit User</div>

            <div class="card-body">
                <form action="{{ route('user.update', $user->id) }}" method="post" enctype="multipart/form-data">
                    @method('PATCH')
                    @csrf
                    @include('users.form')
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