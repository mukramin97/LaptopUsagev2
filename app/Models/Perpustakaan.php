<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perpustakaan extends Model
{
    use HasFactory;

    protected $table = 'table_perpustakaan';
    protected $fillable = [
        'siswa_id', 'tanggal_masuk', 'tanggal_keluar', 'status'
    ];

    public function siswa(){
        return $this->belongsTo(Siswa::class);
    }
}
