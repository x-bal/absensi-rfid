@extends('layouts.master', ['title' => 'Edit Kelas'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Edit Kelas</div>

            <div class="card-body">
                <form action="{{ route('kelas.update', $kela->id) }}" method="post">
                    @method('PATCH')
                    @csrf
                    @include('kelas.form')
                </form>
            </div>
        </div>
    </div>
</div>
@stop