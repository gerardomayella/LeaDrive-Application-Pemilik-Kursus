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
        'id_user',
        'jenis_kendaraan',
        'latitude',
        'longitude',
    ];

    public $timestamps = false;

    protected $casts = [
        'jenis_kendaraan' => 'array',
    ];

    /**
     * Relasi ke tabel User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    /**
     * Relasi ke tabel DokumenKursus
     */
    public function dokumenKursus()
    {
        return $this->hasOne(DokumenKursus::class, 'id_request', 'id_request');
    }

    /**
     * Relasi ke tabel PaketKursus
     */
    public function paketKursus()
    {
        return $this->hasMany(PaketKursus::class, 'id_request', 'id_request');
    }
}
