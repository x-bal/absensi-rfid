@extends('layouts.master', ['title' => 'Create Holiday'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Create Holiday</div>

            <div class="card-body">
                <form action="{{ route('holiday.store') }}" method="post">
                    @csrf
                    @include('holiday.form')
                </form>
            </div>
        </div>
    </div>
</div>
@stop