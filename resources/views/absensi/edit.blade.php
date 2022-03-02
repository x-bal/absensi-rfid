@extends('layouts.master', ['title' => 'Edit Absensi Siswa'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Edit Absensi Siswa</div>

            <div class="card-body">
                <form action="{{ route('absensi.update', $absensi->id) }}" method="post">
                    @method('PATCH')
                    @csrf
                    @include('absensi.form')
                </form>
            </div>
        </div>
    </div>
</div>
@stop