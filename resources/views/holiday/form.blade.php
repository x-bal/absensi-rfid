<div class="form-group">
    <label for="nama">Nama</label>
    <input type="text" name="nama" id="nama" class="form-control" value="{{ $holiday->nama ?? old('nama') }}" autofocus>

    @error('nama')
    <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <label for="waktu">Waktu</label>
    <input type="date" name="waktu" id="waktu" class="form-control" value="{{ $holiday->waktu ?? old('waktu') }}" autofocus>

    @error('waktu')
    <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <button type="submit" class="btn btn-danger">Submit</button>
</div>