<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TestUrine;
use App\Models\Penyuluhan;
use App\Models\DetailDesaBersinar;

class Dokumentasi extends Model
{
    use HasFactory;

    protected $table = 'dokumentasi';

    protected $fillable = [
        'modul',
        'kegiatan_id',
        'file',
    ];

    /* RELASI TEST URINE */
    public function testUrine()
    {
        return $this->belongsTo(TestUrine::class,'kegiatan_id'
        );
    }

    /* RELASI PENYULUHAN */
    public function penyuluhan()
    {
        return $this->belongsTo(Penyuluhan::class,'kegiatan_id'
        );
    }

    /* RELASI DESA BERSINAR */
    public function detailDesa()
    {
        return $this->belongsTo(DetailDesaBersinar::class,'kegiatan_id'
        );
    }
}