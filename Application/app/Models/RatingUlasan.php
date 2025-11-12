<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatingUlasan extends Model
{
    use HasFactory;

    protected $table = 'rating_ulasan';
    protected $primaryKey = 'id_ulasan';
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'tanggal',
        'id_instruktur',
        'komentar',
        'rating',
        'id_kursus',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function instruktur()
    {
        return $this->belongsTo(Instruktur::class, 'id_instruktur', 'id_instruktur');
    }

    public function kursus()
    {
        return $this->belongsTo(Kursus::class, 'id_kursus', 'id_kursus');
    }
}
