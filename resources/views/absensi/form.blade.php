<div class="form-group row">
    <div class="col-md-3">
        <label for="nisn">Nisn</label>
    </div>

    <div class="col-md-9">
        <input type="text" name="nisn" id="nisn" class="form-control" value="{{ $absensi->siswa->nisn ?? old('nisn') }}" readonly>

        @error('nisn')
        <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>

<div class="form-group row">
    <div class="col-md-3">
        <label for="nama">Nama</label>
    </div>

    <div class="col-md-9">
        <input type="text" name="nama" id="nama" class="form-control" value="{{ $absensi->siswa->nama ?? old('nama') }}" readonly>

        @error('nama')
        <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>

<div class="form-group row">
    <div class="col-md-3">
        <label for="rfid">Rfid</label>
    </div>

    <div class="col-md-9">
        <input type="text" name="rfid" id="rfid" class="form-control" value="{{ $absensi->siswa->rfid ?? old('rfid') }}" readonly>

        @error('rfid')
        <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>

<div class="form-group row">
    <div class="col-md-3">
        <label for="status_hadir">Status Hadir</label>
    </div>

    <div class="col-md-9">
        <select name="status_hadir" id="status_hadir" class="form-control">
            @foreach($status as $stt)
            <option {{ $stt == $absensi->status_hadir ? 'selected' : '' }} value="{{ $stt }}">{{ $stt }}</option>
            @endforeach
        </select>

        @error('rfid')
        <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary">Submit</button>
</div>