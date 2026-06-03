<?php

namespace App\Http\Controllers;

use App\Models\TestUrine;
use App\Models\Penyuluhan;
use App\Models\Penggiat;
use App\Models\DesaBersinar;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
{
    /* SUMMARY */
    $total_test_urine = TestUrine::count();
    $total_penyuluhan = Penyuluhan::count();
    $total_penggiat = Penggiat::count();
    $total_desa_bersinar = DesaBersinar::count();

    /* REKAP TEST URINE */
    $testUrineAll = TestUrine::with('peserta')->get();

    $total_diperiksa = 0;
    $total_positif = 0;
    $total_negatif = 0;

    foreach ($testUrineAll as $item) {
        $total_diperiksa += $item->peserta->count();
        $total_positif += $item->peserta->where('hasil', 'reaktif')->count();
        $total_negatif += $item->peserta->where('hasil', 'non_reaktif')->count();
    }

    $total_hasil = $total_positif + $total_negatif;

    if ($total_hasil > 0) {
        $persen_positif = round(($total_positif / $total_hasil) * 100);
        $persen_negatif = round(($total_negatif / $total_hasil) * 100);
    } else {
        $persen_positif = 0;
        $persen_negatif = 0;
    }

    /* KEGIATAN TERBARU */
    $recent_activities = collect();

    $testUrineRecent = TestUrine::latest('tanggal_kegiatan')
        ->take(3)
        ->get();

    foreach ($testUrineRecent as $item) {
        $recent_activities->push([
            'modul' => 'Test Urine',
            'nama' => $item->nama_instansi,
            'tanggal' => $item->tanggal_kegiatan,
            'sasaran' => $item->sasaran,
        ]);
    }

    $penyuluhanRecent = Penyuluhan::latest('tanggal_kegiatan')
        ->take(3)
        ->get();

    foreach ($penyuluhanRecent as $item) {
        $recent_activities->push([
            'modul' => 'Penyuluhan',
            'nama' => $item->nama_tempat,
            'tanggal' => $item->tanggal_kegiatan,
            'sasaran' => $item->sasaran,
        ]);
    }

    $desaRecent = DesaBersinar::latest()
        ->take(3)
        ->get();

    foreach ($desaRecent as $item) {
        $recent_activities->push([
            'modul' => 'Desa Bersinar',
            'nama' => $item->nama_desa,
            'tanggal' => $item->created_at,
        ]);
    }

    $recent_activities = $recent_activities
        ->sortByDesc('tanggal')
        ->take(6);

    /* ACTIVITY SYSTEM */
    $system_logs = collect();

    if (auth()->user()->role->name == 'Admin') {
       $system_logs = ActivityLog::with('user')
            ->latest()
            ->take(8)
            ->get();
    }

    return view('dashboard', compact(
        'total_test_urine',
        'total_penyuluhan',
        'total_penggiat',
        'total_desa_bersinar',

        'total_diperiksa',
        'total_positif',
        'total_negatif',
        'persen_positif',
        'persen_negatif',

        'recent_activities',
        'system_logs'
    ));
}
    /* ANALYTICS */
    public function analytics()
    {
        // SUMMARY CARD
        $total_test_urine = TestUrine::count();
        $total_penyuluhan = Penyuluhan::count();
        $total_penggiat = Penggiat::count();

        $total_desa = DesaBersinar::where('jenis_wilayah', 'Desa')->count();
        $total_kelurahan = DesaBersinar::where('jenis_wilayah', 'Kelurahan')->count();

        $total_desa_bersinar = $total_desa + $total_kelurahan;

        // HASIL TEST URINE
        $testUrineAll = TestUrine::with('peserta')->get();

        $total_positif = 0;
        $total_negatif = 0;

        foreach ($testUrineAll as $item) {
            $total_positif += $item->peserta->where('hasil', 'reaktif')->count();
            $total_negatif += $item->peserta->where('hasil', 'non_reaktif')->count();
        }

        $total_hasil = $total_negatif + $total_positif;

        if ($total_hasil > 0) {
            $persen_negatif = round(($total_negatif / $total_hasil) * 100);
            $persen_positif = round(($total_positif / $total_hasil) * 100);
        } else {
            $persen_negatif = 0;
            $persen_positif = 0;
        }

        // GRAFIK TEST URINE BULANAN
        $testUrine = TestUrine::with('peserta')->get();

        $bulanData = [];

        foreach ($testUrine as $item) {

            $bulan = date('n', strtotime($item->tanggal_kegiatan));

            if (!isset($bulanData[$bulan])) {
                $bulanData[$bulan] = [
                    'kegiatan' => 0,
                    'peserta' => 0
                ];
            }

            $bulanData[$bulan]['kegiatan'] += 1;
            $bulanData[$bulan]['peserta'] += $item->peserta->count();
        }

        $namaBulan = [
            1  => 'Jan',
            2  => 'Feb',
            3  => 'Mar',
            4  => 'Apr',
            5  => 'Mei',
            6  => 'Jun',
            7  => 'Jul',
            8  => 'Agu',
            9  => 'Sep',
            10 => 'Okt',
            11 => 'Nov',
            12 => 'Des',
        ];

        $labels_test_urine = [];
        $data_total_kegiatan = [];
        $data_total_peserta = [];

        ksort($bulanData);

        foreach ($bulanData as $bulan => $item) {
            $labels_test_urine[] = $namaBulan[$bulan];
            $data_total_kegiatan[] = $item['kegiatan'];
            $data_total_peserta[] = $item['peserta'];
        }

        // GRAFIK TEST URINE INSTANSI
        $testUrineKategori = TestUrine::with('peserta')->get();

        $kategoriData = [
            'Sekolah' => [
                'kegiatan' => 0,
                'peserta' => 0
            ],
            'Perguruan Tinggi' => [
                'kegiatan' => 0,
                'peserta' => 0
            ],
            'Swasta/Perusahaan' => [
                'kegiatan' => 0,
                'peserta' => 0
            ],
            'Pemerintah' => [
                'kegiatan' => 0,
                'peserta' => 0
            ],
            'Masyarakat' => [
                'kegiatan' => 0,
                'peserta' => 0
            ],
        ];

        foreach ($testUrineKategori as $item) {

            $jumlahPeserta = $item->peserta->count();

            if ($item->jenis_instansi == 'Lingkungan Pendidikan') {

                if ($item->kategori_pendidikan == 'Sekolah') {
                    $kategoriData['Sekolah']['kegiatan'] += 1;
                    $kategoriData['Sekolah']['peserta'] += $jumlahPeserta;
                }

                if ($item->kategori_pendidikan == 'Perguruan Tinggi') {
                    $kategoriData['Perguruan Tinggi']['kegiatan'] += 1;
                    $kategoriData['Perguruan Tinggi']['peserta'] += $jumlahPeserta;
                }

            } elseif ($item->jenis_instansi == 'Lingkungan Swasta/Perusahaan') {

                $kategoriData['Swasta/Perusahaan']['kegiatan'] += 1;
                $kategoriData['Swasta/Perusahaan']['peserta'] += $jumlahPeserta;

            } elseif ($item->jenis_instansi == 'Lingkungan Pemerintah') {

                $kategoriData['Pemerintah']['kegiatan'] += 1;
                $kategoriData['Pemerintah']['peserta'] += $jumlahPeserta;

            } elseif ($item->jenis_instansi == 'Lingkungan Masyarakat') {

                $kategoriData['Masyarakat']['kegiatan'] += 1;
                $kategoriData['Masyarakat']['peserta'] += $jumlahPeserta;
            }
        }

        $labels_instansi = [];
        $data_instansi = [];
        $data_kegiatan_instansi = [];

        foreach ($kategoriData as $nama => $item) {
            $labels_instansi[] = $nama;
            $data_instansi[] = $item['peserta'];
            $data_kegiatan_instansi[] = $item['kegiatan'];
        }
        // GRAFIK PENYULUHAN BULANAN
        $penyuluhanBulanan = Penyuluhan::all();

        $bulanPenyuluhan = [];

        foreach ($penyuluhanBulanan as $item) {

            $bulan = date('n', strtotime($item->tanggal_kegiatan));

            if (!isset($bulanPenyuluhan[$bulan])) {
                $bulanPenyuluhan[$bulan] = [
                    'kegiatan' => 0,
                    'sebaran' => 0
                ];
            }

            $bulanPenyuluhan[$bulan]['kegiatan'] += 1;
            $bulanPenyuluhan[$bulan]['sebaran'] += (int) $item->jumlah_sebaran;
        }

        $labels_penyuluhan = [];
        $data_kegiatan_penyuluhan = [];
        $data_sebaran_penyuluhan = [];

        ksort($bulanPenyuluhan);

        foreach ($bulanPenyuluhan as $bulan => $item) {
            $labels_penyuluhan[] = $namaBulan[$bulan];
            $data_kegiatan_penyuluhan[] = $item['kegiatan'];
            $data_sebaran_penyuluhan[] = $item['sebaran'];
        }

        // GRAFIK PENYULUHAN JENIS INSTANSI
        $penyuluhanInstansi = Penyuluhan::all();

        $kategoriPenyuluhan = [
            'Sekolah' => [
                'kegiatan' => 0,
                'sebaran' => 0
            ],
            'Perguruan Tinggi' => [
                'kegiatan' => 0,
                'sebaran' => 0
            ],
            'Swasta/Perusahaan' => [
                'kegiatan' => 0,
                'sebaran' => 0
            ],
            'Pemerintah' => [
                'kegiatan' => 0,
                'sebaran' => 0
            ],
            'Masyarakat' => [
                'kegiatan' => 0,
                'sebaran' => 0
            ],
        ];

        foreach ($penyuluhanInstansi as $item) {

            if ($item->jenis_instansi == 'Lingkungan Pendidikan') {

                if ($item->kategori_pendidikan == 'Sekolah') {
                    $kategoriPenyuluhan['Sekolah']['kegiatan'] += 1;
                    $kategoriPenyuluhan['Sekolah']['sebaran'] += (int) $item->jumlah_sebaran;
                }

                if ($item->kategori_pendidikan == 'Perguruan Tinggi') {
                    $kategoriPenyuluhan['Perguruan Tinggi']['kegiatan'] += 1;
                    $kategoriPenyuluhan['Perguruan Tinggi']['sebaran'] += (int) $item->jumlah_sebaran;
                }

            } elseif ($item->jenis_instansi == 'Lingkungan Swasta/Perusahaan') {

                $kategoriPenyuluhan['Swasta/Perusahaan']['kegiatan'] += 1;
                $kategoriPenyuluhan['Swasta/Perusahaan']['sebaran'] += (int) $item->jumlah_sebaran;

            } elseif ($item->jenis_instansi == 'Lingkungan Pemerintah') {

                $kategoriPenyuluhan['Pemerintah']['kegiatan'] += 1;
                $kategoriPenyuluhan['Pemerintah']['sebaran'] += (int) $item->jumlah_sebaran;

            } elseif ($item->jenis_instansi == 'Lingkungan Masyarakat') {

                $kategoriPenyuluhan['Masyarakat']['kegiatan'] += 1;
                $kategoriPenyuluhan['Masyarakat']['sebaran'] += (int) $item->jumlah_sebaran;
            }
        }

        $labels_instansi_penyuluhan = [];
        $data_kegiatan_instansi_penyuluhan = [];
        $data_sebaran_instansi_penyuluhan = [];

        foreach ($kategoriPenyuluhan as $nama => $item) {
            $labels_instansi_penyuluhan[] = $nama;
            $data_kegiatan_instansi_penyuluhan[] = $item['kegiatan'];
            $data_sebaran_instansi_penyuluhan[] = $item['sebaran'];
        }

        // DONUT JENIS MEDIA
        $mediaData = DB::table('detail_penyuluhan')
            ->select('jenis_media', DB::raw('SUM(jumlah_paket) as total'))
            ->groupBy('jenis_media')
            ->pluck('total', 'jenis_media');

        $labels_media = [
            'Konvensional',
            'Cetak',
            'Penyiaran',
            'Online'
        ];

        $data_media = [
            (int) ($mediaData['Konvensional'] ?? 0),
            (int) ($mediaData['Cetak'] ?? 0),
            (int) ($mediaData['Penyiaran'] ?? 0),
            (int) ($mediaData['Online'] ?? 0),
        ];

        // GRAFIK PENGGIAT
        $total_relawan = Penggiat::where('jenis_instansi', 'Lingkungan Masyarakat')
            ->where('kategori_pendidikan', 'Relawan')
            ->count();

        $total_pemerintah_penggiat = Penggiat::where('jenis_instansi', 'Lingkungan Pemerintah')
            ->where('kategori_pendidikan', 'Pemerintah')
            ->count();

        $total_sekolah_penggiat = Penggiat::where('jenis_instansi', 'Lingkungan Pendidikan')
            ->where('kategori_pendidikan', 'Sekolah')
            ->count();

        $total_pt_penggiat = Penggiat::where('jenis_instansi', 'Lingkungan Pendidikan')
            ->where('kategori_pendidikan', 'Perguruan Tinggi')
            ->count();

        $total_swasta_penggiat = Penggiat::where('jenis_instansi', 'Lingkungan Swasta')
            ->where('kategori_pendidikan', 'Swasta')
            ->count();

            // RETURN VIEW ANALYTICS
        return view('analytics', compact(
            'total_test_urine',
            'total_penyuluhan',
            'total_penggiat',
            'total_desa_bersinar',

            'labels_test_urine',
            'data_total_kegiatan',
            'data_total_peserta',

            'labels_instansi',
            'data_instansi',
            'data_kegiatan_instansi',

            'labels_penyuluhan',
            'data_kegiatan_penyuluhan',
            'data_sebaran_penyuluhan',

            'labels_instansi_penyuluhan',
            'data_kegiatan_instansi_penyuluhan',
            'data_sebaran_instansi_penyuluhan',

            'labels_media',
            'data_media',

            'total_negatif',
            'total_positif',
            'persen_negatif',
            'persen_positif',

            'total_relawan',
            'total_pemerintah_penggiat',
            'total_sekolah_penggiat',
            'total_pt_penggiat',
            'total_swasta_penggiat',

            'total_desa',
            'total_kelurahan'
        ));
    }
}
