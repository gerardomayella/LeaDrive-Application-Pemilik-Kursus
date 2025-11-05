<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kursus extends Model
{
    use HasFactory;

    // Nama tabel sesuai di database Supabase
    protected $table = 'kursus';

    // Primary key tabel
    protected $primaryKey = 'id_kursus';

    // Karena id_kursus adalah bigint (int8)
    protected $keyType = 'int';
    public $incrementing = true;

    // Kolom yang bisa diisi melalui mass assignment
    protected $fillable = [
        'nama_kursus',
        'lokasi',
        'jam_buka',
        'jam_tutup',
        'status',
        'foto_profil',
        'nama_pemilik',
        'email',
        'password',
        'longitude',
        'latitude',
    ];

    // Menggunakan kolom created_at & updated_at sesuai schema
    public $timestamps = true;

    /**
     * Relasi ke tabel Instruktur
     * (Satu kursus memiliki banyak instruktur)
     */
    public function instrukturs()
    {
        return $this->hasMany(Instruktur::class, 'id_kursus', 'id_kursus');
    }
}

