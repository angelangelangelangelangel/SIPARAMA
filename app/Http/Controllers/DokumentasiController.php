<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokumentasi;
use App\Models\TestUrine;
use App\Models\Penyuluhan;
use App\Models\DetailPenyuluhan;
use App\Models\DesaBersinar;
use App\Models\DetailDesaBersinar;

class DokumentasiController extends Controller
{
            /* TEST URINE */
            public function testUrine()
            {
                $data = Dokumentasi::with('testUrine')
                    ->where('modul', 'test-urine')
                    ->latest()
                    ->get();

                return view('dokumentasi.index', [
                    'data' => $data,
                    'modul' => 'test-urine'
                ]);
            }                                                                                   

            /* PENYULUHAN */
            public function penyuluhan()
            {
                $data = Dokumentasi::with('penyuluhan')
                    ->where('modul', 'penyuluhan')
                    ->latest()
                    ->get();

                return view('dokumentasi.index', [
                    'data' => $data,
                    'modul' => 'penyuluhan'
                ]);
            }

            /* DESA BERSINAR */
            public function desaBersinar()
            {
                $data = DesaBersinar::withCount('detail')
                    ->latest()
                    ->get();
                return view('dokumentasi.desa', compact('data'));
            }

            /* DETAIL DESA */
            public function detailDesaBersinar($id)
            {
                $desa = DesaBersinar::findOrFail($id);

                $detailIds = DetailDesaBersinar::where('desa_id', $id)
                    ->pluck('id');

                $data = Dokumentasi::with('detailDesa.desa')
                    ->where('modul', 'desa-bersinar')
                    ->whereIn('kegiatan_id', $detailIds)
                    ->latest()
                    ->get();

                return view('dokumentasi.index', [
                    'data' => $data,
                    'modul' => 'desa-bersinar',
                    'desa' => $desa
                ]);
            }

            /* AUTOCOMPLETE */
            public function searchKegiatan(Request $request)
            {
                $keyword = $request->keyword;
                $modul   = $request->modul;
                if ($modul == 'test-urine') {

            $query = TestUrine::query();

            if (!empty($keyword)) {
                $query->where(
                    'nama_instansi',
                    'like',
                    "%{$keyword}%"
                );
            }

            $data = $query
                ->latest()
                ->limit(50)
                ->get()
                ->map(function ($item) {

                    return [
                        'id' => $item->id,
                        'label' => $item->nama_instansi . ' - ' .
                            date(
                                'd M Y',
                                strtotime($item->tanggal_kegiatan)
                            ),
                    ];

                });

        }
                elseif ($modul == 'penyuluhan') {

    $data = DetailPenyuluhan::with('penyuluhan')
        ->where('jenis_kegiatan', 'like', "%{$keyword}%")
        ->latest()
        ->limit(10)
        ->get()
        ->map(function ($item) {

            return [
                'id' => $item->penyuluhan_id,
                'label' =>
                    $item->jenis_kegiatan . ' - ' .
                    $item->penyuluhan->nama_tempat . ' - ' .
                    date(
                        'd M Y',
                        strtotime(
                            $item->penyuluhan->tanggal_kegiatan
                        )
                    ),
            ];

        });

}
 elseif ($modul == 'desa-bersinar') {

                    $desaId = $request->desa_id;

                    $query = DetailDesaBersinar::with('desa')
                        ->where('kegiatan', 'like', "%{$keyword}%");

                    if ($desaId) {
                        $query->where('desa_id', $desaId);
                    }
                    $data = $query->latest()
                        ->limit(10)
                        ->get()
                        ->map(function ($item) {
                            return [
                                'id' => $item->id,
                                'label' => $item->kegiatan . ' - ' .
                                        $item->desa->nama_desa . ' - ' .
                                        date('d M Y', strtotime($item->tanggal_kegiatan)),
                            ];
                        });
                } else {
                    $data = []; }
                return response()->json($data);
            }

            /* STORE */
            public function store(Request $request)
            {
                $request->validate([
                    'modul' => 'required',
                    'kegiatan_id' => 'required',
                    'file' => 'required|file|mimes:jpg,jpeg,png,webp,pdf,doc,docx|max:5120',
                ]);
                $file = $request->file('file');

                $folder = public_path('uploads');

                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                }

                $namaFile = time() . '_' . $file->getClientOriginalName();

                $file->move($folder, $namaFile);

                Dokumentasi::create([
                    'modul' => $request->modul,
                    'kegiatan_id' => $request->kegiatan_id,
                    'file' => $namaFile,
                ]);
                return back()->with('success', 'Dokumentasi berhasil diupload');
            }

    /* EDIT/UPDATE */
    public function update(Request $request, $id)
        {
            $data = Dokumentasi::findOrFail($id);
            $request->validate([
                'kegiatan_id' => 'required',
            ]);
            $update = [
                'kegiatan_id' => $request->kegiatan_id
            ];
            if ($request->hasFile('file')) {

            $file = $request->file('file');

            $folder = public_path('uploads');

            if (!file_exists($folder)) {
                mkdir($folder, 0777, true);
            }

            $namaFile = time() . '_' . $file->getClientOriginalName();

            $file->move($folder, $namaFile);

            if ($data->file && file_exists(public_path('uploads/' . $data->file))) {
                unlink(public_path('uploads/' . $data->file));
            }

            $update['file'] = $namaFile;
        }
            $data->update($update);
            return redirect()->back()
                ->with('success', 'Dokumentasi berhasil diupdate');
        }

            /* DELETE */
            public function destroy($id)
            {
                $data = Dokumentasi::findOrFail($id);
                $path = public_path('uploads/' . $data->file);
                if (file_exists($path)) {
                    unlink($path);
                }
                $data->delete();
                return back()->with('success', 'Dokumentasi berhasil dihapus');
            }
}