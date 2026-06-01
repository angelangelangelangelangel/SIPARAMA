<?php

namespace App\Http\Controllers;
use App\Exports\DesaBersinarExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\DesaBersinar;
use App\Models\DetailDesaBersinar;
use Illuminate\Support\Str;
use App\Models\Dokumentasi;
use Illuminate\Http\Request;

class DesaBersinarController extends Controller
{
    /* INDEX */
    public function index(Request $request)
    {
        $search = $request->search;
        $rows   = $request->rows ?? 10;

        $query = DesaBersinar::withCount('detail')
                    ->with('detail');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_desa', 'like', "%$search%")
                  ->orWhere('satker', 'like', "%$search%")
                  ->orWhere('kab_kota', 'like', "%$search%")
                  ->orWhere('jenis_wilayah', 'like', "%$search%")
                  ->orWhere('status_kerawanan', 'like', "%$search%");
            });
        }

        $data = $query->latest()
                    ->paginate($rows)
                    ->withQueryString();

        return view('desa_bersinar.index', compact(
            'data',
            'search',
            'rows'
        ));
    }

    /* STORE */
    public function store(Request $request)
    {
        $request->validate([
            'satker'           => 'required',
            'kab_kota'         => 'required',
            'nama_desa'        => 'required',
            'jenis_wilayah'    => 'required',
            'status_kerawanan' => 'required',
        ]);

       $desa = DesaBersinar::create([
        'satker'             => $request->satker,
        'kab_kota'           => $request->kab_kota,
        'nama_desa'          => $request->nama_desa,
        'nama_desa' => $request->nama_desa,
        'slug' => Str::slug(str_replace('.', ' ', $request->nama_desa)),
        'jenis_wilayah'      => $request->jenis_wilayah,
        'status_kerawanan'   => $request->status_kerawanan,
        'alasan_perhitungan' => $request->alasan_perhitungan,
        'keterangan'         => $request->keterangan,
    ]);

        logActivity(
            'Desa Bersinar',
            'Menambahkan data desa bersinar ' . $desa->nama_desa
        );

        return redirect('/desa-bersinar')
            ->with('success', 'Data berhasil ditambahkan');
    }

    /* UPDATE */
    public function update(Request $request, $id)
    {
        $request->validate([
            'satker'           => 'required',
            'kab_kota'         => 'required',
            'nama_desa'        => 'required',
            'jenis_wilayah'    => 'required',
            'status_kerawanan' => 'required',
        ]);

        $data = DesaBersinar::findOrFail($id);

        $data->update([
            'satker'             => $request->satker,
            'kab_kota'           => $request->kab_kota,
            'nama_desa'          => $request->nama_desa,
           'slug' => Str::slug(str_replace('.', ' ', $request->nama_desa)),
            'jenis_wilayah'      => $request->jenis_wilayah,
            'status_kerawanan'   => $request->status_kerawanan,
            'alasan_perhitungan' => $request->alasan_perhitungan,
            'keterangan'         => $request->keterangan,
        ]);

        logActivity(
            'Desa Bersinar',
            'Memperbarui data desa bersinar ' . $data->nama_desa
        );

        return redirect('/desa-bersinar')
            ->with('success', 'Data berhasil diupdate');
    }

    /* DELETE */
    public function destroy($id)
    {
        $data = DesaBersinar::with('detail')->findOrFail($id);

        $namaDesa = $data->nama_desa;

        foreach ($data->detail as $detail) {
            Dokumentasi::where('modul', 'desa-bersinar')
                ->where('kegiatan_id', $detail->id)
                ->delete();

            $detail->delete();
        }

        $data->delete();

        logActivity(
            'Desa Bersinar',
            'Menghapus data desa bersinar ' . $namaDesa
        );

        return redirect('/desa-bersinar')
            ->with('success', 'Data berhasil dihapus');
    }

    /* DETAIL */
   public function detail($slug)
    {
    $data = DesaBersinar::with('detail')
        ->where('slug', $slug)
        ->firstOrFail();

    return view( 'desa_bersinar.detail',compact('data'));
    }

    /* SIMPAN KEGIATAN */
    public function storeKegiatan(Request $request, $id)
    {
        $request->validate([
            'kegiatan'         => 'required',
            'tanggal_kegiatan' => 'required|date',
        ]);

        DetailDesaBersinar::create([
            'desa_id'          => $id,
            'kegiatan'         => $request->kegiatan,
            'tanggal_kegiatan' => $request->tanggal_kegiatan,
            'keterangan'       => $request->keterangan,
        ]);

        $desa = DesaBersinar::findOrFail($id);

        return redirect('/desa-bersinar/detail/' . $desa->slug);
}

    /* UPDATE KEGIATAN */
    public function updateKegiatan(Request $request, $id)
    {
        $request->validate([
            'tanggal_kegiatan' => 'required|date',
            'kegiatan'         => 'required',
        ]);

        $data = DetailDesaBersinar::findOrFail($id);

        $data->update([
            'tanggal_kegiatan' => $request->tanggal_kegiatan,
            'kegiatan'         => $request->kegiatan,
            'keterangan'       => $request->keterangan,
        ]);

        $desa = DesaBersinar::findOrFail($data->desa_id);

    return redirect('/desa-bersinar/detail/' . $desa->slug);
    }

    /* HAPUS KEGIATAN */
    public function destroyKegiatan($id)
    {
        $data = DetailDesaBersinar::findOrFail($id);

        $desa_id = $data->desa_id;

        Dokumentasi::where('modul', 'desa-bersinar')
            ->where('kegiatan_id', $id)
            ->delete();

        $data->delete();

        $desa = DesaBersinar::findOrFail($desa_id);

    return redirect('/desa-bersinar/detail/' . $desa->slug);
    }

    /* REKAP */
    public function rekap()
    {
        $data = DesaBersinar::withCount('detail')
                    ->latest()
                    ->get();

        return view('desa_bersinar.rekap', compact('data'));
    }

    /* LAPORAN */
    public function laporan(Request $request)
    {
        $search = $request->search;
        $bulan  = $request->bulan;
        $tahun  = $request->tahun;

        $query = DesaBersinar::with([
            'detail' => function ($q) use ($bulan, $tahun) {
                if ($bulan) {
                    $q->whereMonth('tanggal_kegiatan', $bulan);
                }

                if ($tahun) {
                    $q->whereYear('tanggal_kegiatan', $tahun);
                }
            }
        ]);

        if ($search) {
            $query->where('jenis_wilayah', 'like', "%$search%");
        }

        if ($bulan || $tahun) {
            $query->whereHas('detail', function ($q) use ($bulan, $tahun) {
                if ($bulan) {
                    $q->whereMonth('tanggal_kegiatan', $bulan);
                }

                if ($tahun) {
                    $q->whereYear('tanggal_kegiatan', $tahun);
                }
            });
        }

        $data = $query->latest()->get();

        return view('laporan.desa_bersinar', compact('data'));
    }

    /* PRINT */
    public function print(Request $request)
    {
        $search = $request->search;
        $bulan  = $request->bulan;
        $tahun  = $request->tahun;

        $query = DesaBersinar::with([
            'detail' => function ($q) use ($bulan, $tahun) {
                if ($bulan) {
                    $q->whereMonth('tanggal_kegiatan', $bulan);
                }

                if ($tahun) {
                    $q->whereYear('tanggal_kegiatan', $tahun);
                }
            }
        ]);

        if ($search) {
            $query->where('jenis_wilayah', 'like', "%$search%");
        }

        if ($bulan || $tahun) {
            $query->whereHas('detail', function ($q) use ($bulan, $tahun) {
                if ($bulan) {
                    $q->whereMonth('tanggal_kegiatan', $bulan);
                }

                if ($tahun) {
                    $q->whereYear('tanggal_kegiatan', $tahun);
                }
            });
        }

        $data = $query->latest()->get();

       return view('laporan.desa_bersinar_print',[
        'data' => $data,
        'isPdf' => false
    ]);
    }

    /* EXPORT CSV */
    public function exportExcel(Request $request)
{
    return Excel::download(
        new DesaBersinarExport(
            $request->search,
            $request->bulan,
            $request->tahun
        ),
        'laporan_desa_bersinar.xlsx'
    );
}

    /* EXPORT PDF */
   public function exportPdf(Request $request)
{
    $search = $request->search;
    $bulan  = $request->bulan;
    $tahun  = $request->tahun;

    $query = DesaBersinar::with([
        'detail' => function ($q) use ($bulan, $tahun) {

            if ($bulan) {
                $q->whereMonth(
                    'tanggal_kegiatan',
                    $bulan
                );
            }

            if ($tahun) {
                $q->whereYear(
                    'tanggal_kegiatan',
                    $tahun
                );
            }

        }
    ]);

    if ($search) {
        $query->where(
            'jenis_wilayah',
            'like',
            "%$search%"
        );
    }

    $data = $query->latest()->get();

    $pdf = Pdf::loadView(
        'laporan.desa_bersinar_pdf',
        [
            'data' => $data,
            'isPdf' => true
        ]
    );

    $pdf->setPaper('A4', 'landscape');

    return $pdf->stream( 'laporan_desa_bersinar.pdf' );
    }
}