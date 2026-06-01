<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyuluhan extends Model
{
    use HasFactory;

    protected $table = 'penyuluhan';

    protected $fillable = [

        'tanggal_kegiatan',
        'nama_tempat',
        'slug',
        'jenis_instansi',
        'kategori_pendidikan',
        'sasaran',
        'jumlah_sebaran',
        'keterangan'

    ];


    /* RELASI DETAIL */
    public function detail()
    {

        return $this->hasMany(
            DetailPenyuluhan::class,
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