<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailDesaBersinar extends Model
{
    use HasFactory;

    protected $table = 'detail_desa_bersinar';

    protected $fillable = [
        'desa_id',
        'kegiatan',
        'tanggal_kegiatan',
        'keterangan'
    ];

    public function desa()
    {
        return $this->belongsTo(DesaBersinar::class, 'desa_id');
    }
}