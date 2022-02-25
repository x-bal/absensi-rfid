<div class="form-group">
    <label for="username">Username</label>
    <input type="text" name="username" id="username" class="form-control" value="{{ $user->username ?? old('username') }}">

    @error('username')
    <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <label for="nama">Nama</label>
    <input type="text" name="nama" id="nama" class="form-control" value="{{ $user->nama ?? old('nama') }}">

    @error('nama')
    <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <label for="password">Password</label>
    <input type="password" name="password" id="password" class="form-control">

    @error('password')
    <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <label for="nik">Nik</label>
    <input type="number" name="nik" id="nik" class="form-control" value="{{ $user->nik ?? old('nik') }}">

    @error('nik')
    <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <label for="gender">Gender</label>
    <select name="gender" id="gender" class="form-control">
        <option disabled selected>-- Pilih gender --</option>
        <option {{ $user->gender == 'Laki - Laki' ? 'selected' : '' }} value="Laki - Laki">Laki - Laki</option>
        <option {{ $user->gender == 'Perempuan' ? 'selected' : '' }} value="Perempuan">Perempuan</option>
    </select>

    @error('gender')
    <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <label for="jabatan">Jabatan</label>
    <select name="jabatan" id="jabatan" class="form-control">
        <option disabled selected>-- Pilih Jabatan --</option>
        @foreach($jabatan as $jb)
        <option {{ $jb == $user->jabatan ? 'selected' : '' }} value="{{ $jb }}">{{ $jb }}</option>
        @endforeach
    </select>

    @error('jabatan')
    <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <label for="role">Role</label>
    <select name="role" id="role" class="form-control">
        <option disabled selected>-- Pilih role --</option>
        @foreach($roles as $role)
        <option {{ $user->id && $role->id == $user->roles()->first()->id ? 'selected' : '' }} value="{{ $role->id }}">{{ $role->name }}</option>
        @endforeach
    </select>

    @error('role')
    <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <label for="rfid">RFID</label>
    <input type="text" name="rfid" id="rfid" class="form-control" value="{{ $user->rfid ?? old('rfid') }}">

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