<?php

namespace App\Exports;

use App\Models\DesaBersinar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class DesaBersinarExport implements
    FromCollection,
    WithHeadings,
    ShouldAutoSize,
    WithEvents
{
    protected $search;
    protected $bulan;
    protected $tahun;

    public function __construct(
        $search = null,
        $bulan = null,
        $tahun = null
    ){
        $this->search = $search;
        $this->bulan  = $bulan;
        $this->tahun  = $tahun;
    }

    public function headings(): array
    {
        return [
            'No',
            'Satker',
            'Nama Desa',
            'Kab/Kota',
            'Jenis Wilayah',
            'Status Kerawanan',
            'Jumlah Kegiatan',
            'Daftar Kegiatan'
        ];
    }

    public function collection()
    {
        $query = DesaBersinar::with([
            'detail' => function ($q) {

                if ($this->bulan) {
                    $q->whereMonth(
                        'tanggal_kegiatan',
                        $this->bulan
                    );
                }

                if ($this->tahun) {
                    $q->whereYear(
                        'tanggal_kegiatan',
                        $this->tahun
                    );
                }
            }
        ]);

        if ($this->search) {
            $query->where(
                'jenis_wilayah',
                'like',
                '%' . $this->search . '%'
            );
        }

        $data = $query->latest()->get();

        $rows = collect();
        $nomor = 1;

        foreach ($data as $item) {

            $kegiatan = '';

            foreach ($item->detail as $detail) {

                $kegiatan .=
                    $detail->kegiatan . "\n";

            }

            $rows->push([
                $nomor++,
                $item->satker,
                $item->nama_desa,
                $item->kab_kota,
                $item->jenis_wilayah,
                $item->status_kerawanan,
                $item->detail->count(),
                trim($kegiatan)
            ]);
        }

        return $rows;
    }

    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();

                $sheet->insertNewRowBefore(1, 4);

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
                    'LAPORAN DESA BERSINAR'
                );

                $sheet->mergeCells('A4:H4');
                $sheet->setCellValue(
                    'A4',
                    'PERIODE TAHUN ' .
                    ($this->tahun ?: date('Y'))
                );

                $sheet->getStyle('A1:H4')
                    ->getFont()
                    ->setBold(true);

                $sheet->getStyle('A1:H4')
                    ->getAlignment()
                    ->setHorizontal(
                        \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
                    );

                $sheet->getStyle('A1')->getFont()->setSize(16);
                $sheet->getStyle('A2')->getFont()->setSize(14);
                $sheet->getStyle('A3')->getFont()->setSize(14);
                $sheet->getStyle('A4')->getFont()->setSize(12);

                $sheet->getStyle('A5:H5')
                    ->applyFromArray([
                        'font' => [
                            'bold' => true
                        ],
                        'fill' => [
                            'fillType' =>
                            \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'startColor' => [
                                'rgb' => 'D9EAF7'
                            ]
                        ]
                    ]);

                $lastRow = $sheet->getHighestRow();

                $sheet->getStyle(
                    'A5:H'.$lastRow
                )->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' =>
                            \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                        ]
                    ]
                ]);

                $sheet->getStyle(
                    'A5:H'.$lastRow
                )->getAlignment()
                 ->setVertical(
                    \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
                 );

                $sheet->getStyle(
                    'A5:A'.$lastRow
                )->getAlignment()
                 ->setHorizontal(
                    \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
                 );

                $sheet->getStyle(
                    'G5:G'.$lastRow
                )->getAlignment()
                 ->setHorizontal(
                    \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
                 );

                $sheet->getStyle(
                    'H6:H'.$lastRow
                )->getAlignment()
                 ->setWrapText(true);
            }

        ];
    }
}