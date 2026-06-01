<?php

namespace App\Http\Controllers;
use App\Exports\PenyuluhanExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use App\Models\Penyuluhan;
use App\Models\DetailPenyuluhan;
use App\Models\Dokumentasi;
use Illuminate\Http\Request;


class PenyuluhanController extends Controller
{
    /* HALAMAN UTAMA */
    public function index(Request $request)
    {
        $rows   = $request->rows ?? 10;
        $search = $request->search;

        $query = Penyuluhan::withCount('detail')
                    ->with('detail');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_tempat', 'like', "%$search%")
                  ->orWhere('sasaran', 'like', "%$search%")
                  ->orWhere('jenis_instansi', 'like', "%$search%")
                  ->orWhere('kategori_pendidikan', 'like', "%$search%");
            });
        }

        $data = $query->latest()
                    ->paginate($rows)
                    ->withQueryString();

        $total_sekolah = Penyuluhan::where(
            'kategori_pendidikan',
            'Sekolah'
        )->count();

        $total_pt = Penyuluhan::where(
            'kategori_pendidikan',
            'Perguruan Tinggi'
        )->count();

        $total_pemerintah = Penyuluhan::where(
            'jenis_instansi',
            'Lingkungan Pemerintah'
        )->count();

        $total_swasta = Penyuluhan::where(
            'jenis_instansi',
            'Lingkungan Swasta'
        )->count();

        return view('penyuluhan.index', compact(
            'data',
            'rows',
            'search',
            'total_sekolah',
            'total_pt',
            'total_pemerintah',
            'total_swasta'
        ));
    }

    /* SIMPAN DATA */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_kegiatan' => 'required|date',
            'nama_tempat'      => 'required',
            'nama_tempat' => $request->nama_tempat,
            'slug' => Str::slug(str_replace('.', ' ', $request->nama_tempat)),
            'jenis_instansi'   => 'required',
            'sasaran'          => 'required',
            'jumlah_sebaran'   => 'required|numeric',
        ]);

        $penyuluhan = Penyuluhan::create([
            'tanggal_kegiatan'    => $request->tanggal_kegiatan,
            'nama_tempat'         => $request->nama_tempat,
            'jenis_instansi'      => $request->jenis_instansi,
            'kategori_pendidikan' => $request->kategori_pendidikan,
            'sasaran'             => $request->sasaran,
            'jumlah_sebaran'      => $request->jumlah_sebaran,
            'keterangan'          => $request->keterangan,
        ]);

        logActivity(
            'Penyuluhan',
            'Menambahkan data penyuluhan di ' . $penyuluhan->nama_tempat
        );

        return redirect('/penyuluhan')
            ->with('success', 'Data berhasil ditambahkan');
    }

    /* DETAIL */
   public function detail($slug)
    {
    $data = Penyuluhan::with('detail')
        ->where('slug', $slug)
        ->firstOrFail();

        return view('penyuluhan.detail', compact('data'));
    }

    /* UPDATE */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_kegiatan' => 'required|date',
            'nama_tempat'      => 'required',
            'slug' => Str::slug(str_replace('.', ' ', $request->nama_tempat)),
            'jenis_instansi'   => 'required',
            'sasaran'          => 'required',
            'jumlah_sebaran'   => 'required|numeric',
        ]);

        $data = Penyuluhan::findOrFail($id);

        $data->update([
            'tanggal_kegiatan'    => $request->tanggal_kegiatan,
            'nama_tempat'         => $request->nama_tempat,
            'jenis_instansi'      => $request->jenis_instansi,
            'kategori_pendidikan' => $request->kategori_pendidikan,
            'sasaran'             => $request->sasaran,
            'jumlah_sebaran'      => $request->jumlah_sebaran,
            'keterangan'          => $request->keterangan,
        ]);

        logActivity(
            'Penyuluhan',
            'Memperbarui data penyuluhan di ' . $data->nama_tempat
        );

        return redirect('/penyuluhan')
            ->with('success', 'Data berhasil diupdate');
    }

    /* HAPUS */
    public function destroy($id)
    {
        $data = Penyuluhan::with('detail')->findOrFail($id);

        $namaTempat = $data->nama_tempat;

        foreach ($data->detail as $detail) {
            Dokumentasi::where('modul', 'penyuluhan')
                ->where('kegiatan_id', $detail->id)
                ->delete();

            $detail->delete();
        }

        $data->delete();

        logActivity(
            'Penyuluhan',
            'Menghapus data penyuluhan di ' . $namaTempat
        );

        return redirect('/penyuluhan')
            ->with('success', 'Data berhasil dihapus');
    }

    /* SIMPAN DETAIL */
    public function storeDetail(Request $request, $id)
    {
        $request->validate([
            'jenis_media'    => 'required',
            'jenis_kegiatan' => 'required',
            'jumlah_paket'   => 'required|numeric',
        ]);

        DetailPenyuluhan::create([
            'penyuluhan_id'  => $id,
            'jenis_media'    => $request->jenis_media,
            'jenis_kegiatan' => $request->jenis_kegiatan,
            'jumlah_paket'   => $request->jumlah_paket,
        ]);

        return redirect('/penyuluhan/' . $id . '/detail')
            ->with('success', 'Detail berhasil ditambahkan');
    }

    /* UPDATE DETAIL */
    public function updateDetail(Request $request, $id)
    {
        $request->validate([
            'jenis_media'    => 'required',
            'jenis_kegiatan' => 'required',
            'jumlah_paket'   => 'required|numeric',
        ]);

        $detail = DetailPenyuluhan::findOrFail($id);

        $detail->update([
            'jenis_media'    => $request->jenis_media,
            'jenis_kegiatan' => $request->jenis_kegiatan,
            'jumlah_paket'   => $request->jumlah_paket,
        ]);

        return redirect('/penyuluhan/' . $detail->penyuluhan_id . '/detail')
            ->with('success', 'Detail berhasil diupdate');
    }

    /* HAPUS DETAIL */
    public function destroyDetail($id)
    {
        $detail = DetailPenyuluhan::findOrFail($id);

        $parent = $detail->penyuluhan_id;

        Dokumentasi::where('modul', 'penyuluhan')
            ->where('kegiatan_id', $detail->id)
            ->delete();

        $detail->delete();

        return redirect('/penyuluhan/' . $parent . '/detail')
            ->with('success', 'Detail berhasil dihapus');
    }

    /* LAPORAN */
    public function laporan(Request $request)
    {
        $search = $request->search;
        $bulan  = $request->bulan;
        $tahun  = $request->tahun;

        $query = Penyuluhan::with('detail');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_tempat', 'like', "%$search%")
                  ->orWhere('sasaran', 'like', "%$search%")
                  ->orWhere('jenis_instansi', 'like', "%$search%");
            });
        }

        if ($bulan) {
            $query->whereMonth('tanggal_kegiatan', $bulan);
        }

        if ($tahun) {
            $query->whereYear('tanggal_kegiatan', $tahun);
        }

        $data = $query->latest()->get();

        return view('laporan.penyuluhan', compact(
            'data',
            'search',
            'bulan',
            'tahun'
        ));
    }

    /* PRINT */
    public function print(Request $request)
    {
        $search = $request->search;
        $bulan  = $request->bulan;
        $tahun  = $request->tahun;

        $query = Penyuluhan::with('detail');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_tempat', 'like', "%$search%")
                  ->orWhere('sasaran', 'like', "%$search%")
                  ->orWhere('jenis_instansi', 'like', "%$search%");
            });
        }

        if ($bulan) {
            $query->whereMonth('tanggal_kegiatan', $bulan);
        }

        if ($tahun) {
            $query->whereYear('tanggal_kegiatan', $tahun);
        }

        $data = $query->latest()->get();

        return view('laporan.penyuluhan_print', compact('data'));
    }

    /* EXPORT xlx */
    public function exportExcel(Request $request)
{
    return Excel::download(
        new PenyuluhanExport(
            $request->search,
            $request->bulan,
            $request->tahun
        ),
        'laporan_penyuluhan.xlsx'
    );
}

    /* EXPORT PDF */
    public function exportPdf(Request $request)
{
    $search = $request->search;
    $bulan  = $request->bulan;
    $tahun  = $request->tahun;

    $query = Penyuluhan::with('detail');

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('nama_tempat', 'like', "%$search%")
              ->orWhere('sasaran', 'like', "%$search%")
              ->orWhere('jenis_instansi', 'like', "%$search%");
        });
    }

    if ($bulan) {
        $query->whereMonth('tanggal_kegiatan', $bulan);
    }

    if ($tahun) {
        $query->whereYear('tanggal_kegiatan', $tahun);
    }

    $data = $query->latest()->get();

    $pdf = Pdf::loadView(
    'laporan.penyuluhan_pdf',
    [
        'data' => $data,
        'isPdf' => true
    ]
);  

    $pdf->setPaper('A4', 'landscape');

    return $pdf->stream('laporan_penyuluhan.pdf');
}
}