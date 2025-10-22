<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Request extends Model
{
    use HasFactory;

    // Nama tabel di supabase
    protected $table = 'request_akun';
    protected $primaryKey = 'id_request';

    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'waktu',
        'nama_kursus',
        'lokasi',
        'jam_buka',
        'jam_tutup',
    ];

    public $timestamps = false;

    
}
