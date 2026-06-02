<?php

namespace App\Http\Controllers;
use App\Exports\TestUrineExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\TestUrine;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class TestUrineController extends Controller
{
    /* INDEX */
    public function index(Request $request)
    {
        $search = $request->search;
        $rows   = $request->rows ?? 10;

        $query = TestUrine::with('peserta');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_instansi', 'like', "%$search%")
                  ->orWhere('jenis_instansi', 'like', "%$search%")
                  ->orWhere('kategori_pendidikan', 'like', "%$search%")
                  ->orWhere('sasaran', 'like', "%$search%");
            });
        }

        $data = $query->latest()
                    ->paginate($rows)
                    ->withQueryString();

        $total_kegiatan = $data->total();

        $total_peserta = $data->sum(function ($item) {
            return $item->peserta->count();
        });

        $total_positif = $data->sum(function ($item) {
            return $item->peserta->where('hasil', 'reaktif')->count();
        });

        $total_negatif = $data->sum(function ($item) {
            return $item->peserta->where('hasil', 'non_reaktif')->count();
        });

        return view('test_urine.index', compact(
            'data',
            'search',
            'total_kegiatan',
            'total_peserta',
            'total_positif',
            'total_negatif'
        ));
    }

    /* CREATE */
    public function create()
    {
        return view('test_urine.create');
    }

    /* STORE */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_kegiatan' => 'required',
            'nama_instansi'    => 'required',
            'jenis_instansi'   => 'required',
        ]);

        $testUrine = TestUrine::create([
            'tanggal_kegiatan'    => $request->tanggal_kegiatan,
            'nama_instansi'       => $request->nama_instansi,
            'slug' => Str::slug(str_replace('.', ' ', $request->nama_instansi)),
            'jenis_instansi'      => $request->jenis_instansi,
            'kategori_pendidikan' => $request->kategori_pendidikan ?? '-',
            'sasaran'             => $request->sasaran,
            'tujuan_test'         => $request->tujuan_test,
            'jumlah_peserta'      => $request->jumlah_peserta ?? 0,
            'jumlah_laki_laki'    => $request->jumlah_laki_laki ?? 0,
            'jumlah_perempuan'    => $request->jumlah_perempuan ?? 0,
            'jumlah_positif'      => $request->jumlah_positif ?? 0,
            'jumlah_negatif'      => $request->jumlah_negatif ?? 0,
            'keterangan'          => $request->keterangan,
        ]);

        logActivity(
            'Test Urine',
            'Menambahkan data test urine di ' . $testUrine->nama_instansi
        );

        return redirect('/test-urine')
            ->with('success', 'Data berhasil disimpan');
    }

    /* DETAIL */
    public function detail($slug)
        {
            $data = TestUrine::with('peserta')
                ->where('slug', $slug)
                ->firstOrFail();

            return view('test_urine.detail', compact('data'));
        }

    /* EDIT */
    public function edit($id)
    {
        $data = TestUrine::findOrFail($id);

        return view('test_urine.edit', compact('data'));
    }

    /* UPDATE */
    public function update(Request $request, $id)
    {
        $data = TestUrine::findOrFail($id);

        $data->update([
            'tanggal_kegiatan'    => $request->tanggal_kegiatan,
            'nama_instansi'       => $request->nama_instansi,
            'slug' => Str::slug(str_replace('.', ' ', $request->nama_instansi)),
            'jenis_instansi'      => $request->jenis_instansi,
            'kategori_pendidikan' => $request->kategori_pendidikan ?? '-',
            'sasaran'             => $request->sasaran,
            'tujuan_test'         => $request->tujuan_test,
            'keterangan'          => $request->keterangan,
        ]);

        logActivity(
            'Test Urine',
            'Memperbarui data test urine di ' . $data->nama_instansi
        );

        return redirect('/test-urine')
            ->with('success', 'Data berhasil diupdate');
    }

    /* DELETE */
    public function destroy($id)
    {
        $data = TestUrine::findOrFail($id);

        $namaInstansi = $data->nama_instansi;

        $data->delete();

        logActivity(
            'Test Urine',
            'Menghapus data test urine di ' . $namaInstansi
        );

        return redirect('/test-urine')
            ->with('success', 'Data berhasil dihapus');
    }

    /* LAPORAN */
    public function laporan(Request $request)
    {
        $query = TestUrine::with('peserta');

        if ($request->search) {
            $query->where(
                'jenis_instansi',
                'like',
                '%' . $request->search . '%'
            );
        }

        if ($request->bulan) {
            $query->whereMonth('tanggal_kegiatan', $request->bulan);
        }

        if ($request->tahun) {
            $query->whereYear('tanggal_kegiatan', $request->tahun);
        }

        $allData = $query->latest()->get();

        $pemerintah = $allData->where(
            'jenis_instansi',
            'Lingkungan Pemerintah'
        );

        $swasta = $allData->where(
            'jenis_instansi',
            'Lingkungan Swasta'
        );

        $pendidikan = $allData->where(
            'jenis_instansi',
            'Lingkungan Pendidikan'
        );

        $masyarakat = $allData->where(
            'jenis_instansi',
            'Lingkungan Masyarakat'
        );

        $totalKegiatan = $allData->count();

        $totalPeserta = $allData->sum(function ($item) {
            return $item->peserta->count();
        });

        $totalReaktif = $allData->sum(function ($item) {
            return $item->peserta->where('hasil', 'reaktif')->count();
        });

        $totalNonReaktif = $allData->sum(function ($item) {
            return $item->peserta->where('hasil', 'non_reaktif')->count();
        });

        return view('laporan.test_urine', compact(
            'pemerintah',
            'swasta',
            'pendidikan',
            'masyarakat',
            'totalKegiatan',
            'totalPeserta',
            'totalReaktif',
            'totalNonReaktif'
        ));
    }

    /* PRINT */
    public function print(Request $request)
{
    $query = TestUrine::with('peserta');

    if ($request->search) {
        $query->where(
            'jenis_instansi',
            'like',
            '%' . $request->search . '%'
        );
    }

    if ($request->bulan) {
        $query->whereMonth('tanggal_kegiatan', $request->bulan);
    }

    if ($request->tahun) {
        $query->whereYear('tanggal_kegiatan', $request->tahun);
    }

    $allData = $query->latest()->get();

    $pemerintah = $allData->where(
        'jenis_instansi',
        'Lingkungan Pemerintah'
    );

    $swasta = $allData->where(
        'jenis_instansi',
        'Lingkungan Swasta'
    );

    $pendidikan = $allData->where(
        'jenis_instansi',
        'Lingkungan Pendidikan'
    );

    $masyarakat = $allData->where(
        'jenis_instansi',
        'Lingkungan Masyarakat'
    );

    $totalKeseluruhan = $allData->sum(function ($item) {
        return $item->peserta->count();
    });

   return view(
    'laporan.test_urine_print',
    [
        'pemerintah'       => $pemerintah,
        'swasta'           => $swasta,
        'pendidikan'       => $pendidikan,
        'masyarakat'       => $masyarakat,
        'totalKeseluruhan' => $totalKeseluruhan,
        'isPdf'            => false
    ]
);
}

    /* EXPORT xlx*/
    public function exportExcel(Request $request)
{
    return Excel::download(
    new TestUrineExport(
        $request->search,
        $request->bulan,
        $request->tahun
    ),
    'laporan_test_urine.xlsx'
);
}

   /* EXPORT PDF */
    public function exportPdf(Request $request)
{
    $query = TestUrine::with('peserta');

    if ($request->search) {
        $query->where(
            'jenis_instansi',
            'like',
            '%' . $request->search . '%'
        );
    }

    if ($request->bulan) {
        $query->whereMonth('tanggal_kegiatan', $request->bulan);
    }

    if ($request->tahun) {
        $query->whereYear('tanggal_kegiatan', $request->tahun);
    }

    $allData = $query->latest()->get();

    $pemerintah = $allData->where(
        'jenis_instansi',
        'Lingkungan Pemerintah'
    );

    $swasta = $allData->where(
        'jenis_instansi',
        'Lingkungan Swasta'
    );

    $pendidikan = $allData->where(
        'jenis_instansi',
        'Lingkungan Pendidikan'
    );

    $masyarakat = $allData->where(
        'jenis_instansi',
        'Lingkungan Masyarakat'
    );

    $totalKeseluruhan = $allData->sum(function ($item) {
        return $item->peserta->count();
    });

   $pdf = Pdf::loadView(
    'laporan.test_urine_pdf',
    [
        'pemerintah'       => $pemerintah,
        'swasta'           => $swasta,
        'pendidikan'       => $pendidikan,
        'masyarakat'       => $masyarakat,
        'totalKeseluruhan' => $totalKeseluruhan,
        'isPdf'            => true
    ]
)->setPaper('a4', 'landscape');

    return $pdf->stream('laporan_test_urine.pdf');
}
}