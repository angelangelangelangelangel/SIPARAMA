<?php

namespace App\Exports;

use App\Models\TestUrine;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TestUrineExport implements
    FromCollection,
    WithHeadings,
    ShouldAutoSize,
    WithEvents
{
    protected $search;
    protected $bulan;
    protected $tahun;

    public function __construct($search = null, $bulan = null, $tahun = null)
    {
        $this->search = $search;
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Nama Instansi',
            'Jenis Instansi',
            'Sasaran',
            'Jumlah Peserta',
            'Reaktif',
            'Non Reaktif',
        ];
    }

    public function collection()
    {
        $query = TestUrine::with('peserta');

        if ($this->search) {
            $query->where(
                'jenis_instansi',
                'like',
                '%' . $this->search . '%'
            );
        }

        if ($this->bulan) {
            $query->whereMonth(
                'tanggal_kegiatan',
                $this->bulan
            );
        }

        if ($this->tahun) {
            $query->whereYear(
                'tanggal_kegiatan',
                $this->tahun
            );
        }

        $data = $query->get();

        return $data->map(function ($item, $index) {

            return [

                $index + 1,

                $item->tanggal_kegiatan,

                $item->nama_instansi,

                $item->jenis_instansi,

                $item->sasaran,

                $item->peserta->count(),

                $item->peserta
                    ->where('hasil', 'reaktif')
                    ->count(),

                $item->peserta
                    ->where('hasil', 'non_reaktif')
                    ->count(),

            ];

        });
    }

    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();

                // Tambah ruang judul
                $sheet->insertNewRowBefore(1, 4);

                // Judul
                $sheet->mergeCells('A1:H1');
                $sheet->setCellValue(
                    'A1',
                    'BADAN NARKOTIKA NASIONAL PROVINSI KALIMANTAN SELATAN'
                );

                $sheet->mergeCells('A2:H2');
                $sheet->setCellValue(
                    'A2',
                    'BIDANG PENCEGAHAN DAN PEMBERDAYAAN MASYARAKAT'
                );

                $sheet->mergeCells('A3:H3');
                $sheet->setCellValue(
                    'A3',
                    'LAPORAN KEGIATAN TEST URINE'
                );

                $sheet->mergeCells('A4:H4');
                $sheet->setCellValue(
                    'A4',
                    'PERIODE TAHUN ' . ($this->tahun ?: date('Y'))
                );

                // Style Judul
                $sheet->getStyle('A1:H4')->getFont()->setBold(true);

                $sheet->getStyle('A1:H4')
                    ->getAlignment()
                    ->setHorizontal(
                        \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
                    );

                $sheet->getStyle('A1')->getFont()->setSize(16);
                $sheet->getStyle('A2')->getFont()->setSize(14);
                $sheet->getStyle('A3')->getFont()->setSize(14);
                $sheet->getStyle('A4')->getFont()->setSize(12);

                // Header tabel
                $sheet->getStyle('A5:H5')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'fill' => [
                        'fillType' =>
                        \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => 'D9EAF7',
                        ],
                    ],
                ]);

                // Border tabel
                $lastRow = $sheet->getHighestRow();

                $sheet->getStyle('A5:H' . $lastRow)
                    ->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' =>
                                \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => [
                                    'rgb' => '000000',
                                ],
                            ],
                        ],
                    ]);

                // Total
                $queryTotal = TestUrine::with('peserta');

                if ($this->search) {
                    $queryTotal->where(
                        'jenis_instansi',
                        'like',
                        '%' . $this->search . '%'
                    );
                }

                if ($this->bulan) {
                    $queryTotal->whereMonth(
                        'tanggal_kegiatan',
                        $this->bulan
                    );
                }

                if ($this->tahun) {
                    $queryTotal->whereYear(
                        'tanggal_kegiatan',
                        $this->tahun
                    );
                }

                $dataTotal = $queryTotal->get();

                $totalPeserta = $dataTotal->sum(function ($item) {
                    return $item->peserta->count();
                });

                $totalReaktif = $dataTotal->sum(function ($item) {
                    return $item->peserta
                        ->where('hasil', 'reaktif')
                        ->count();
                });

                $totalNonReaktif = $dataTotal->sum(function ($item) {
                    return $item->peserta
                        ->where('hasil', 'non_reaktif')
                        ->count();
                });

                $totalRow = $lastRow + 1;

                $sheet->mergeCells('A'.$totalRow.':E'.$totalRow);

                $sheet->setCellValue(
                    'A'.$totalRow,
                    'TOTAL'
                );

                $sheet->setCellValue(
                    'F'.$totalRow,
                    $totalPeserta
                );

                $sheet->setCellValue(
                    'G'.$totalRow,
                    $totalReaktif
                );

                $sheet->setCellValue(
                    'H'.$totalRow,
                    $totalNonReaktif
                );

                $sheet->getStyle(
                    'A'.$totalRow.':H'.$totalRow
                )->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'fill' => [
                        'fillType' =>
                        \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => 'FFF2CC',
                        ],
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' =>
                            \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ]);

                $sheet->getStyle(
                    'A'.$totalRow.':H'.$totalRow
                )->getAlignment()->setHorizontal(
                    \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
                );

                // Rata tengah kolom angka
                $sheet->getStyle('A5:A'.$totalRow)
                    ->getAlignment()
                    ->setHorizontal(
                        \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
                    );

                $sheet->getStyle('F5:H'.$totalRow)
                    ->getAlignment()
                    ->setHorizontal(
                        \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
                    );
            },

        ];
    }
}