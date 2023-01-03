<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'table_siswa';

    protected $fillable = [
        'nama', 'kelas_id', 'laptop_id', 'NISN',
    ];

    public function laptop()
    {
        return $this->belongsTo(Laptop::class);
    }

    public function kelas(){
        return $this->belongsTo(Kelas::class);
    }

    public function penggunaan(){
        return $this->hasMany(Penggunaan::class);
    }

    
}
