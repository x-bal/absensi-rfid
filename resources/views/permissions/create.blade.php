@extends('layouts.master', ['title' => 'Create Permission'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Create Permission</div>

            <div class="card-body">
                <form action="{{ route('permission.store') }}" method="post">
                    @csrf
                    @include('permissions.form')
                </form>
            </div>
        </div>
    </div>
</div>
@stop