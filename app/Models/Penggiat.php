<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penggiat extends Model
{
    protected $table = 'penggiat';

   protected $fillable = [
    'nama_penggiat',
    'instansi',
    'jabatan',
    'jenis_instansi',
    'kategori_pendidikan',
    'keterangan'
];
}