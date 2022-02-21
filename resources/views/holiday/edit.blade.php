@extends('layouts.master', ['title' => 'Edit Holiday'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Edit Holiday</div>

            <div class="card-body">
                <form action="{{ route('holiday.update', $holiday->id) }}" method="post">
                    @method('PATCH')
                    @csrf
                    @include('holiday.form')
                </form>
            </div>
        </div>
    </div>
</div>
@stop