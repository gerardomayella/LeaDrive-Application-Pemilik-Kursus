<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    protected $table = 'pemesanan';
    protected $primaryKey = 'id_pemesanan';
    public $timestamps = false;

    protected $fillable = [
        'id_paket',
        'tanggal_pemesanan',
        'status_pemesanan',
        'id_user',
        'latitude',
        'longitude',
    ];

    public function paket()
    {
        return $this->belongsTo(PaketKursus::class, 'id_paket', 'id_paket');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'id_pemesanan', 'id_pemesanan');
    }

    public function jadwal()
    {
        return $this->hasMany(JadwalKursus::class, 'id_pemesanan', 'id_pemesanan');
    }

    public function latestPembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_pemesanan', 'id_pemesanan')->latestOfMany('id_pembayaran');
    }
}
