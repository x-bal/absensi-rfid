@extends('layouts.master', ['title' => 'Create Device'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Create Device</div>

            <div class="card-body">
                <form action="{{ route('device.store') }}" method="post">
                    @csrf
                    @include('device.form')
                </form>
            </div>
        </div>
    </div>
</div>
@stop