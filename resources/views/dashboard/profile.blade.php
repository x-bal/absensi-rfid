@extends('layouts.master', ['title' => 'Profile'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body row">
                <div class="col-md-4 text-center">
                    <div class="avatar avatar-xxl">
                        <img src="{{ asset('/storage/'.auth()->user()->foto) }}" alt="{{auth()->user()->foto}}" class="avatar-img rounded-circle">
                    </div>
                    <p>
                        Jabatan : <b>{{ auth()->user()->jabatan ?? '-' }}</b><br>
                        Role : <b>{{ auth()->user()->roles()->first()->name ?? '-' }}</b><br>
                        Rfid : <b>{{ auth()->user()->rfid ?? '-' }}</b><br>
                    </p>
                </div>

                <div class="col-md-8">
                    <form action="{{ route('profile.update') }}" method="post">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-2">
                                <label for="nama">Nama</label>
                            </div>

                            <div class="col-md-10">
                                <input type="text" name="nama" id="nama" class="form-control" value="{{ auth()->user()->nama }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-2">
                                <label for="gender">Gender</label>
                            </div>

                            <div class="col-md-10">
                                <select name="gender" id="gender" class="form-control">
                                    <option {{ auth()->user()->gender == 'Laki - Laki' ? 'selected' : '' }} value="Laki - Laki">Laki - Laki</option>
                                    <option {{ auth()->user()->gender == 'Perempuan' ? 'selected' : '' }} value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-2">
                                <label for="password">Password</label>
                            </div>

                            <div class="col-md-10">
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-2"></div>

                            <div class="col-md-10">
                                <button type="submit" class="btn btn-danger">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop