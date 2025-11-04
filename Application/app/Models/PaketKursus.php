<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketKursus extends Model
{
    use HasFactory;

    protected $table = 'paketKursus';
    protected $primaryKey = 'id_paket';

    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'jenis_mobil',
        'durasi',
        'id_kursus',
        'deskripsi',
    ];

    
}

