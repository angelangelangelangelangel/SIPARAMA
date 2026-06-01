<?php

namespace App\Http\Controllers;
use App\Exports\PenggiatExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Penggiat;
use Illuminate\Http\Request;

class PenggiatController extends Controller
{
    /* HALAMAN UTAMA */
    public function index(Request $request)
    {
        $rows   = $request->rows ?? 10;
        $search = $request->search;

        $query = Penggiat::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_penggiat', 'like', "%$search%")
                  ->orWhere('instansi', 'like', "%$search%")
                  ->orWhere('jenis_instansi', 'like', "%$search%")
                  ->orWhere('kategori_pendidikan', 'like', "%$search%")
                  ->orWhere('keterangan', 'like', "%$search%");
            });
        }

        $data = $query->latest()
                    ->paginate($rows)
                    ->withQueryString();

        return view('penggiat.index', compact(
            'data',
            'rows',
            'search'
        ));
    }

    /* SIMPAN DATA */
    public function store(Request $request)
    {
        $request->validate([
            'nama_penggiat'   => 'required',
            'instansi'        => 'required',
            'jenis_instansi'  => 'required'
        ]);

        $penggiat = Penggiat::create([
            'nama_penggiat'       => $request->nama_penggiat,
            'instansi'            => $request->instansi,
            'jabatan'             => $request->jabatan,
            'jenis_instansi'      => $request->jenis_instansi,
            'kategori_pendidikan' => $request->kategori_pendidikan,
            'keterangan'          => $request->keterangan
        ]);

        logActivity(
            'Penggiat',
            'Menambahkan data penggiat ' . $penggiat->nama_penggiat
        );

        return redirect('/penggiat')
            ->with('success', 'Data berhasil disimpan');
    }

    /* UPDATE */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_penggiat'   => 'required',
            'instansi'        => 'required',
            'jenis_instansi'  => 'required'
        ]);

        $data = Penggiat::findOrFail($id);

       $data->update([
                    'nama_penggiat'       => $request->nama_penggiat,
                    'instansi'            => $request->instansi,
                    'jabatan'             => $request->jabatan,
                    'jenis_instansi'      => $request->jenis_instansi,
                    'kategori_pendidikan' => $request->kategori_pendidikan,
                    'keterangan'          => $request->keterangan
                ]);

        logActivity(
            'Penggiat',
            'Memperbarui data penggiat ' . $data->nama_penggiat
        );

        return redirect('/penggiat')
            ->with('success', 'Data berhasil diupdate');
    }

    /* HAPUS */
    public function destroy($id)
    {
        $data = Penggiat::findOrFail($id);

        $namaPenggiat = $data->nama_penggiat;

        $data->delete();

        logActivity(
            'Penggiat',
            'Menghapus data penggiat ' . $namaPenggiat
        );

        return redirect('/penggiat')
            ->with('success', 'Data berhasil dihapus');
    }

    /* LAPORAN */
    public function laporan(Request $request)
    {
        $query = Penggiat::query();

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_penggiat', 'like', '%' . $request->search . '%')
                  ->orWhere('instansi', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->jenis_instansi) {
            $query->where('jenis_instansi', $request->jenis_instansi);
        }

        $data = $query->latest()->get();

        return view('laporan.penggiat', compact('data'));
    }

    /* PRINT */
    public function print(Request $request)
    {
        $query = Penggiat::query();

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_penggiat', 'like', '%' . $request->search . '%')
                  ->orWhere('instansi', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->jenis_instansi) {
            $query->where('jenis_instansi', $request->jenis_instansi);
        }

        $data = $query->latest()->get();

       return view('laporan.penggiat_print', [
    'data' => $data,
    'isPdf' => false
    ]);
    }

    /* EXPORT XLX */
    public function exportExcel(Request $request)
    {
        return Excel::download(
            new PenggiatExport(
                $request->search,
                $request->jenis_instansi
            ),
            'laporan_penggiat.xlsx'
        );
    }

    /* EXPORT PDF */
    public function exportPdf(Request $request)
    {
        $query = Penggiat::query();

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_penggiat', 'like', '%' . $request->search . '%')
                  ->orWhere('instansi', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->jenis_instansi) {
            $query->where('jenis_instansi', $request->jenis_instansi);
        }
        if ($request->jenis_instansi) {
    $query->where('jenis_instansi', $request->jenis_instansi);
}

        $data = $query->latest()->get();

        $pdf = Pdf::loadView(
            'laporan.penggiat_pdf',
            [
                'data' => $data,
                'isPdf' => true
            ]
        );

        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream('laporan_penggiat.pdf');
    }
}