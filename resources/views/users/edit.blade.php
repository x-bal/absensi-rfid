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