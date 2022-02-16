@extends('layouts.master', ['title' => 'Edit Device'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Edit Device</div>

            <div class="card-body">
                <form action="{{ route('device.update', $device->id) }}" method="post">
                    @method('PATCH')
                    @csrf
                    @include('device.form')
                </form>
            </div>
        </div>
    </div>
</div>
@stop