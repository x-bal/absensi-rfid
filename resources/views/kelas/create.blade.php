@extends('layouts.master', ['title' => 'Create Kelas'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Create Kelas</div>

            <div class="card-body">
                <form action="{{ route('kelas.store') }}" method="post">
                    @csrf
                    @include('kelas.form')
                </form>
            </div>
        </div>
    </div>
</div>
@stop