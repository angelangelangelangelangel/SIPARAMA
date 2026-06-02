<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TestUrine;

class PesertaTestUrine extends Model
{
    protected $table = 'peserta_test_urine';

    protected $fillable = [
        'test_urine_id',
        'nama_peserta',
        'jenis_kelamin',
        'riwayat_obat',
        'hasil',
        'status_kehadiran'
    ];

    public function testUrine()
    {
        return $this->belongsTo(TestUrine::class);
    }

    //
}
