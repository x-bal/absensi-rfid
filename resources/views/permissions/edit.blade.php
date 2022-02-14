@extends('layouts.master', ['title' => 'Edit Permission'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Edit Permission</div>

            <div class="card-body">
                <form action="{{ route('permission.update', $permission->id) }}" method="post">
                    @method('PATCH')
                    @csrf
                    @include('permissions.form')
                </form>
            </div>
        </div>
    </div>
</div>
@stop