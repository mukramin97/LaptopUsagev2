<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penggunaan extends Model
{
    use HasFactory;

    protected $table = 'table_penggunaan';
    protected $fillable = [
        'siswa_id', 'tanggal_pinjam', 'tanggal_kembali', 'status'
    ];

    public function siswa(){
        return $this->belongsTo(Siswa::class);
    }
}
