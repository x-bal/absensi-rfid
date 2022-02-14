@extends('layouts.master', ['title' => 'Edit Role'])

@push('style')
<!-- Select 2 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Edit Role</div>

            <div class="card-body">
                <form action="{{ route('role.update', $role->id) }}" method="post">
                    @method('PATCH')
                    @csrf
                    @include('roles.form')
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@push('script')
<!-- Select 2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $("#permission").select2()
</script>
@endpush