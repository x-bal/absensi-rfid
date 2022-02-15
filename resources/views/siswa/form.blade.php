<div class="form-group">
    <label for="nisn">Nisn</label>
    <input type="text" name="nisn" id="nisn" class="form-control" value="{{ $siswa->nisn ?? old('nisn') }}">

    @error('nisn')
    <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <label for="nama">Nama</label>
    <input type="text" name="nama" id="nama" class="form-control" value="{{ $siswa->nama ?? old('nama') }}">

    @error('nama')
    <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <label for="gender">Gender</label>
    <select name="gender" id="gender" class="form-control">
        <option disabled selected>-- Pilih gender --</option>
        <option {{ $siswa->gender == 'Laki - Laki' ? 'selected' : '' }} value="Laki - Laki">Laki - Laki</option>
        <option {{ $siswa->gender == 'Perempuan' ? 'selected' : '' }} value="Perempuan">Perempuan</option>
    </select>

    @error('gender')
    <small class="text-danger">{{ $message }}</small>
    @enderror
</div>


<div class="form-group">
    <label for="kelas">Kelas</label>
    <select name="kelas" id="kelas" class="form-control">
        <option disabled selected>-- Pilih Kelas --</option>
        @foreach($kelas as $kls)
        <option {{ $siswa->id && $kls->id == $siswa->kelas->id ? 'selected' : '' }} value="{{ $kls->id }}">{{ $kls->nama}}</option>
        @endforeach
    </select>

    @error('kelas')
    <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <label for="rfid">Rfid</label>
    <input type="text" name="rfid" id="rfid" class="form-control" value="{{ $siswa->rfid ?? old('rfid') }}">

    @error('rfid')
    <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <label for="foto">Foto</label>
    <input type="file" name="foto" id="foto" class="form-control">

    @error('foto')
    <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary">Submit</button>
</div>