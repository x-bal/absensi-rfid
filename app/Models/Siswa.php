<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }
}
