@extends('layouts.master', ['title' => 'Create Siswa'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Create Siswa</div>

            <div class="card-body">
                <form action="{{ route('siswa.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @include('siswa.form')
                </form>
            </div>
        </div>
    </div>
</div>
@stop