<?php

namespace App\Http\Controllers;

use App\Models\PesertaTestUrine;
use App\Models\TestUrine;
use Illuminate\Http\Request;

class PesertaTestUrineController extends Controller
{

    public function storeGlobal(Request $request)
    {
        $request->validate([
            'test_urine_id'     => 'required',
            'nama_peserta'      => 'required',
            'jenis_kelamin'     => 'required',
            'status_kehadiran'  => 'required',
            'hasil'             => 'required',
        ]);

        PesertaTestUrine::create([
            'test_urine_id'     => $request->test_urine_id,
            'nama_peserta'      => $request->nama_peserta,
            'jenis_kelamin'     => $request->jenis_kelamin,
            'status_kehadiran'  => $request->status_kehadiran,
            'hasil'             => $request->hasil, // reaktif / non_reaktif
            'riwayat_obat'      => $request->riwayat_obat,
        ]);

        return redirect('/test-urine/' . $request->test_urine_id . '/detail');
    }

    /* UPDATE PESERTA */
    public function update(Request $request, $id)
    {
        $data = PesertaTestUrine::findOrFail($id);

        $request->validate([
            'nama_peserta'      => 'required',
            'jenis_kelamin'     => 'required',
            'status_kehadiran'  => 'required',
            'hasil'             => 'required',
        ]);

        $data->update([
            'nama_peserta'      => $request->nama_peserta,
            'jenis_kelamin'     => $request->jenis_kelamin,
            'status_kehadiran'  => $request->status_kehadiran,
            'hasil'             => $request->hasil, 
            'riwayat_obat'      => $request->riwayat_obat,
        ]);

       return redirect('/test-urine/' . $data->test_urine_id . '/detail');
    }

    /* HAPUS PESERTA */
    public function destroy($id)
    {
        $data = PesertaTestUrine::findOrFail($id);

        $testUrineId = $data->test_urine_id;

        $data->delete();

        return redirect('/test-urine/' . $data->test_urine_id . '/detail');
    }
}