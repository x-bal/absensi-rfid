<div class="form-group">
    <label for="nama">Nama</label>
    <input type="text" name="nama" id="nama" class="form-control" value="{{ $device->nama ?? old('nama') }}" autofocus>

    @error('nama')
    <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <button type="submit" class="btn btn-danger">Submit</button>
</div>