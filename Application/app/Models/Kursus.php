<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kursus extends Model
{
    use HasFactory;

    protected $table = 'kursus';

    protected $primaryKey = 'id_kursus';

    protected $keyType = 'int';
    public $incrementing = true;

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
        'nomor_hp',
    ];

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

