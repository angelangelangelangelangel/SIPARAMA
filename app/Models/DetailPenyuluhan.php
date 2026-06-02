<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPenyuluhan extends Model
{
    use HasFactory;

    protected $table = 'detail_penyuluhan';

    protected $fillable = [

        'penyuluhan_id',
        'jenis_media',
        'jenis_kegiatan',
        'jumlah_paket'

    ];


    /* RELASI KE PENYULUHAN */
    public function penyuluhan()
    {

        return $this->belongsTo(
            Penyuluhan::class,
            'penyuluhan_id'
        );

    }


    /* RELASI DOKUMENTASI */
    public function dokumentasi()
    {

        return $this->hasMany(
            Dokumentasi::class,
            'kegiatan_id'
        )->where('modul', 'penyuluhan');

    }

}