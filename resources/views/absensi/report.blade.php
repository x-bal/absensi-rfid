@extends('layouts.master', ['title' => 'Rekap Absensi Siswa'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Rekap Absensi Siswa</div>

            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <form action="" method="get">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="kelas">Kelas</label>
                                        <select name="kelas" id="kelas" class="form-control">
                                            <option disabled selected>-- Pilih Kelas --</option>
                                            <option {{ request('kelas') == 'all' ? 'selected' : '' }} value="all">ALL</option>
                                            @foreach($kelas as $kls)
                                            <option {{ request('kelas') == $kls->id ? 'selected' : '' }} value="{{ $kls->id }}">{{ $kls->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="from">From</label>
                                        <input type="date" name="from" id="from" class="form-control" value="{{ request('from') ?? '' }}">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="to">To</label>
                                        <input type="date" name="to" id="to" class="form-control" value="{{ request('to') ?? '' }}">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-danger mt-4">Submit</button>
                                        <a href="{{ route('absensi.generate') }}?kelas={{ request('kelas') }}&from={{ request('from') }}&to={{ request('to') }}&act=export" class="btn btn-success mt-4"><i class="fas fa-file-excel"></i> Export</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive">
                    @include('absensi.generate')
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@push('script')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(".table").DataTable();
</script>
@endpush