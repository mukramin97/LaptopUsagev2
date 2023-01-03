<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laptop extends Model
{
    use HasFactory;

    protected $table = 'table_laptop';

    protected $fillable = [
        'merk', 'spesifikasi',
    ];

    public function siswa(){
        return $this->hasOne(Siswa::class);
    }

}
