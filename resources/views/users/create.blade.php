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