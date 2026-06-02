<?php

namespace App\Exports;

use App\Models\Penggiat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class PenggiatExport implements
    FromCollection,
    WithHeadings,
    ShouldAutoSize,
    WithEvents
{
    protected $search;
    protected $jenis_instansi;

    public function __construct(
        $search = null,
        $jenis_instansi = null
    ) {
        $this->search = $search;
        $this->jenis_instansi = $jenis_instansi;
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Penggiat',
            'Instansi',
            'Jabatan',
            'Jenis Instansi',
            'Kategori',
            'Keterangan'
        ];
    }

    public function collection()
    {
        $query = Penggiat::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nama_penggiat', 'like', '%' . $this->search . '%')
                  ->orWhere('instansi', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->jenis_instansi) {
            $query->where(
                'jenis_instansi',
                $this->jenis_instansi
            );
        }

        return $query->latest()->get()->map(function ($item, $index) {

            return [

                $index + 1,

                $item->nama_penggiat,

                $item->instansi,

                $item->jabatan ?? '-',

                $item->jenis_instansi,

                $item->kategori_pendidikan ?? '-',

                $item->keterangan ?? '-',

            ];
        });
    }

    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();

                $sheet->insertNewRowBefore(1, 4);

                $sheet->mergeCells('A1:G1');
                $sheet->setCellValue(
                    'A1',
                    'BADAN NARKOTIKA NASIONAL PROVINSI KALIMANTAN SELATAN'
                );

                $sheet->mergeCells('A2:G2');
                $sheet->setCellValue(
                    'A2',
                    'BIDANG PENCEGAHAN DAN PEMBERDAYAAN MASYARAKAT'
                );

                $sheet->mergeCells('A3:G3');
                $sheet->setCellValue(
                    'A3',
                    'LAPORAN DATA PENGGIAT'
                );

                $sheet->mergeCells('A4:G4');
                $sheet->setCellValue(
                    'A4',
                    'PERIODE TAHUN ' . date('Y')
                );

                $sheet->getStyle('A1:G4')
                    ->getFont()
                    ->setBold(true);

                $sheet->getStyle('A1:G4')
                    ->getAlignment()
                    ->setHorizontal(
                        \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
                    );

                $sheet->getStyle('A1')->getFont()->setSize(16);
                $sheet->getStyle('A2')->getFont()->setSize(14);
                $sheet->getStyle('A3')->getFont()->setSize(14);
                $sheet->getStyle('A4')->getFont()->setSize(12);

                $sheet->getStyle('A5:G5')
                    ->applyFromArray([
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

                $lastRow = $sheet->getHighestRow();

                $sheet->getStyle('A5:G' . $lastRow)
                    ->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' =>
                                \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            ],
                        ],
                    ]);

                $sheet->getStyle('A5:G' . $lastRow)
                    ->getAlignment()
                    ->setVertical(
                        \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
                    );

                $sheet->getStyle('A5:A' . $lastRow)
                    ->getAlignment()
                    ->setHorizontal(
                        \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
                    );

                $sheet->getStyle('D5:F' . $lastRow)
                    ->getAlignment()
                    ->setHorizontal(
                        \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
                    );
            }

        ];
    }
}