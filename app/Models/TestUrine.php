<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PesertaTestUrine;
use App\Models\Dokumentasi;

class TestUrine extends Model
{
    protected $table ='test_urine';
   protected $fillable = [
    'tanggal_kegiatan',
    'nama_instansi',
    'slug',
    'jenis_instansi',
    'kategori_pendidikan',
    'sasaran',
    'tujuan_test',
    'jumlah_peserta',
    'jumlah_laki_laki',
    'jumlah_perempuan',
    'jumlah_positif',
    'jumlah_negatif',
    'keterangan'
];
    public function peserta()
    {
        return $this->hasMany(PesertaTestUrine::Class, 'test_urine_id');
    }

    public function dokumentasi()
    {
        return $this->hasMany(Dokumentasi::class);
    }
    //
}
