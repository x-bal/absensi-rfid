@extends('layouts.master', ['title' => 'Data Absensi'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Data Absensi Masuk Tanggal {{ Carbon\Carbon::now()->format('d/m/Y') }}</div>

            <div class="card-body">
                <!-- <a href="{{ route('absensi.create') }}" class="btn btn-primary mb-3">Tambah Absensi</a> -->

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Device</th>
                            <th>Rfid</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Ket</th>
                            <th>Waktu</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($absensiMasuk as $masuk)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $masuk->device->nama }}</td>
                            <td>{{ $masuk->siswa->rfid }}</td>
                            <td>{{ $masuk->siswa->nama }}</td>
                            <td>{{ $masuk->siswa->kelas->nama }}</td>
                            <td>{{ $masuk->masuk == 1 ? 'Masuk' : '' }}</td>
                            <td>{{ Carbon\Carbon::parse($masuk->updated_at)->format('d/m/Y H:i:s') }}</td>
                            <td>
                                <a href="{{ route('absensi.edit', $masuk->id) }}" class="btn btn-sm btn-success"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('absensi.destroy', $masuk->id) }}" method="post" style="display: inline;" class="form-delete">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger btn-delete"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Data Absensi Keluar Tanggal {{ Carbon\Carbon::now()->format('d/m/Y') }}</div>

            <div class="card-body">
                <!-- <a href="{{ route('absensi.create') }}" class="btn btn-primary mb-3">Tambah Absensi</a> -->

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Device</th>
                            <th>Rfid</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Ket</th>
                            <th>Waktu</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($absensiKeluar as $keluar)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $keluar->device->nama }}</td>
                            <td>{{ $keluar->siswa->rfid }}</td>
                            <td>{{ $keluar->siswa->nama }}</td>
                            <td>{{ $keluar->siswa->kelas->nama }}</td>
                            <td>{{ $keluar->keluar == 1 ? 'Keluar' : '' }}</td>
                            <td>{{ Carbon\Carbon::parse($keluar->updated_at)->format('d/m/Y H:i:s') }}</td>
                            <td>
                                <a href="{{ route('absensi.edit', $keluar->id) }}" class="btn btn-sm btn-success"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('absensi.destroy', $keluar->id) }}" method="post" style="display: inline;" class="form-delete">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger btn-delete"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop

@push('script')
<script>
    $(".table").DataTable()
</script>
@endpush