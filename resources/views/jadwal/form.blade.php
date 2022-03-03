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
        <div class="form-check">
            <label class="form-check-label">
                <input class="form-check-input" type="checkbox" value="1" name="monday" {{ $jadwal->monday == 1 ? 'checked' : '' }}>
                <span class="form-check-sign">Monday</span>
            </label>
        </div>

        @error('monday')
        <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-md-6">
        <div class="form-check">
            <label class="form-check-label">
                <input class="form-check-input" type="checkbox" value="1" name="tuesday" {{ $jadwal->tuesday == 1 ? 'checked' : '' }}>
                <span class="form-check-sign">Tuesday</span>
            </label>
        </div>

        @error('tuesday')
        <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>

<div class="form-group row">
    <div class="col-md-6">
        <div class="form-check">
            <label class="form-check-label">
                <input class="form-check-input" type="checkbox" value="1" name="wednesday" {{ $jadwal->wednesday == 1 ? 'checked' : '' }}>
                <span class="form-check-sign">Wednesday</span>
            </label>
        </div>

        @error('wednesday')
        <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-md-6">
        <div class="form-check">
            <label class="form-check-label">
                <input class="form-check-input" type="checkbox" value="1" name="thursday" {{ $jadwal->thursday == 1 ? 'checked' : '' }}>
                <span class="form-check-sign">Thursday</span>
            </label>
        </div>

        @error('thursday')
        <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>

<div class="form-group row">
    <div class="col-md-6">
        <div class="form-check">
            <label class="form-check-label">
                <input class="form-check-input" type="checkbox" value="1" name="friday" {{ $jadwal->friday == 1 ? 'checked' : '' }}>
                <span class="form-check-sign">Friday</span>
            </label>
        </div>

        @error('friday')
        <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-md-6">
        <div class="form-check">
            <label class="form-check-label">
                <input class="form-check-input" type="checkbox" value="1" name="saturday" {{ $jadwal->saturday == 1 ? 'checked' : '' }}>
                <span class="form-check-sign">Saturday</span>
            </label>
        </div>

        @error('saturday')
        <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>

<div class="form-group">
    <button type="submit" class="btn btn-danger">Submit</button>
</div>