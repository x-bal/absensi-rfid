<div class="form-group row">
    <div class="col-md-3">
        <label for="nama">Nama</label>
    </div>

    <div class="col-md-9">
        <input type="text" name="nama" id="nama" class="form-control" value="{{ $kela->nama ?? old('nama') }}" autofocus>

        @error('nama')
        <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary">Submit</button>
</div>