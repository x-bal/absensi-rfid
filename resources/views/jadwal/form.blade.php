<div class="form-group">
    <label for="nama">Nama Staff / Guru</label>
    <select name="guru" id="guru" class="form-control">
        <option disabled selected>-- Pilih Staff --</option>
        @foreach($users as $user)
        <option {{ $jadwal->user_id == $user->id ? 'selected' : '' }} value="{{ $user->id }}">{{ $user->nama }} - {{ $user->nik }}</option>
        @endforeach
    </select>

    @error('guru')
    <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group row">
    <div class="col-md-6">
        <label for="monday">Monday</label>
        <input type="text" name="monday" id="monday" class="form-control" placeholder="00:00 - 00:00" value="{{ $jadwal->monday ?? '00:00 - 00:00' }}">

        @error('monday')
        <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="tuesday">Tuesday</label>
        <input type="text" name="tuesday" id="tuesday" class="form-control" placeholder="00:00 - 00:00" value="{{ $jadwal->tuesday ?? '00:00 - 00:00' }}">

        @error('tuesday')
        <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>

<div class="form-group row">
    <div class="col-md-6">
        <label for="wednesday">Wednesday</label>
        <input type="text" name="wednesday" id="wednesday" class="form-control" placeholder="00:00 - 00:00" value="{{ $jadwal->wednesday ?? '00:00 - 00:00' }}">

        @error('wednesday')
        <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="thursday">Thursday</label>
        <input type="text" name="thursday" id="thursday" class="form-control" placeholder="00:00 - 00:00" value="{{ $jadwal->thursday ?? '00:00 - 00:00' }}">

        @error('thursday')
        <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>

<div class="form-group row">
    <div class="col-md-6">
        <label for="friday">Friday</label>
        <input type="text" name="friday" id="friday" class="form-control" placeholder="00:00 - 00:00" value="{{ $jadwal->friday ?? '00:00 - 00:00' }}">

        @error('friday')
        <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="saturday">Saturday</label>
        <input type="text" name="saturday" id="saturday" class="form-control" placeholder="00:00 - 00:00" value="{{ $jadwal->saturday ?? '00:00 - 00:00' }}">

        @error('saturday')
        <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>

<div class="form-group">
    <button type="submit" class="btn btn-danger">Submit</button>
</div>