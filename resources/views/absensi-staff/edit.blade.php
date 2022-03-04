@extends('layouts.master', ['title' => 'Edit Absensi Staff'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Edit Absensi Staff</div>

            <div class="card-body">
                <form action="{{ route('absensi-staff.update', $absensiStaff->id) }}" method="post">
                    @method('PATCH')
                    @csrf
                    @include('absensi-staff.form')
                </form>
            </div>
        </div>
    </div>
</div>
@stop