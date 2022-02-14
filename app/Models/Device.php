<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }

    public function history()
    {
        return $this->hasMany(History::class);
    }
}
