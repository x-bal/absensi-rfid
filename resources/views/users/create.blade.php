@extends('layouts.master', ['title' => 'Create User'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Create User</div>

            <div class="card-body">
                <form action="{{ route('user.store') }}" method="post" enctype="multipart/form-data">
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
    setInterval(function() {
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