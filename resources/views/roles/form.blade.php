<div class="form-group">
    <label for="name">Name</label>
    <input type="text" name="name" id="name" class="form-control" value="{{ $role->name ?? old('name') }}">

    @error('name')
    <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <label for="permission">Permission</label>
    <select name="permission[]" id="permission" class="form-control" multiple>
        @foreach($permissions as $permission)
        <option @if(in_array($permission->id, $role->permissions()->pluck('permission_id')->toArray())) selected @endif value="{{ $permission->id }}">{{ $permission->name }}</option>
        @endforeach
    </select>

    @error('permission')
    <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary">Submit</button>
</div>