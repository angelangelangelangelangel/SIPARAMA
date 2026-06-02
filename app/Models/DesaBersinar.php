<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DesaBersinar extends Model
{
    protected $table = 'desa_bersinar';

    protected $fillable = [
                'satker',
                'kab_kota',
                'nama_desa',
                'slug',
                'jenis_wilayah',
                'status_kerawanan',
                'alasan_perhitungan',
                'keterangan'
            ];

    public function detail()
    {
        return $this->hasMany(DetailDesaBersinar::class, 'desa_id');
    }
}
