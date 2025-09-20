<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DeliveriesExport implements FromCollection, WithStyles, ShouldAutoSize
{
    protected $deliveries;

    public function __construct($deliveries)
    {
        // Pastikan nilai default diatur
        $this->deliveries = collect($deliveries)->map(function ($delivery) {
            return [
                'PO' => $delivery['PO'] ?? 'N/A',
                'Customer Part Number' => $delivery['Customer Part Number'] ?? 'N/A',
                'Customer' => $delivery['Customer'] ?? 'N/A',
                'Part Number' => $delivery['Part Number'] ?? 'N/A',
                'Part Name' => $delivery['Part Name'] ?? 'N/A',
                'Qty' => $delivery['Qty'] ?? 0,
                'Prepared' => $delivery['Prepared'] ?? 0,
                'Outstanding' => $delivery['Outstanding'] ?? 0,
                'Delivery Date' => $delivery['Delivery Date'] ?? 'N/A',
                'Overdue' => $delivery['Overdue'] ?? 0,
                'Status' => $delivery['Status'] ?? 'N/A',
            ];
        })->toArray();
    }

    public function collection()
    {
        // Tambahkan judul pada data yang diekspor
        $header = [
            ['Delivery Report'], // Judul
            [], // Baris kosong untuk memisahkan judul dengan header tabel
            [
                'PO',
                'Customer Part Number',
                'Customer',
                'Part Number',
                'Part Name',
                'Qty',
                'Prepared',
                'Outstanding',
                'Delivery Date',
                'Overdue',
                'Status'
            ], // Header tabel
        ];

        return collect(array_merge($header, $this->deliveries));
    }

    public function styles(Worksheet $sheet)
    {
        // Gaya untuk judul
        $sheet->mergeCells('A1:K1'); // Gabungkan sel untuk judul
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
                'color' => ['argb' => 'FFFFFF'], // Warna teks putih
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => '4CAF50'], // Warna hijau
            ],
        ]);

        // Tambahkan border ke seluruh tabel
        $sheet->getStyle('A2:K' . ($sheet->getHighestRow()))
            ->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'], // Hitam
                    ],
                ],
            ]);

        // Atur gaya header
        $sheet->getStyle('A2:K2')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFF'], // Warna teks putih
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => '000000'], // Hitam
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Rata tengah untuk kolom Customer
        $sheet->getStyle('C3:C' . $sheet->getHighestRow())->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Berikan warna latar belakang pada kolom Status
        $lastRow = $sheet->getHighestRow();
        for ($row = 3; $row <= $lastRow; $row++) { // Baris data dimulai dari baris ke-3
            $statusCell = 'K' . $row; // Kolom K untuk Status
            $statusValue = $sheet->getCell($statusCell)->getValue();

            // Warna berdasarkan nilai Status
            $styleArray = [];
            switch ($statusValue) {
                case 'Dalam Proses':
                    $styleArray = [
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'startColor' => ['argb' => '5DADE2'], // Latar belakang biru cerah
                        ],
                        'font' => ['color' => ['argb' => '154360']], // Warna teks biru tua
                    ];
                    break;

                case 'Belum Siap':
                    $styleArray = [
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'startColor' => ['argb' => 'F7DC6F'], // Latar belakang kuning lembut
                        ],
                        'font' => ['color' => ['argb' => '7D6608']], // Warna teks coklat tua
                    ];
                    break;

                case 'Close':
                    $styleArray = [
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'startColor' => ['argb' => '58D68D'], // Latar belakang hijau segar
                        ],
                        'font' => ['color' => ['argb' => '145A32']], // Warna teks hijau tua
                    ];
                    break;

                case 'Delay': // Tambahkan logika warna untuk "Delay"
                    $styleArray = [
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'startColor' => ['argb' => 'EC7063'],
                        ],
                        'font' => ['color' => ['argb' => '641E16']],
                    ];
                    break;
                    case 'Late Delivery':
                        $styleArray = [
                            'fill' => [
                                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                'startColor' => ['argb' => 'FFFF00'], // Latar belakang kuning cerah
                            ],
                            'font' => ['color' => ['argb' => '000000']], // Warna teks hitam
                        ];
                        break;
            }

            if (!empty($styleArray)) {
                $sheet->getStyle($statusCell)->applyFromArray($styleArray);
            }
        }     // Berikan warna merah pada kolom Overdue jika bernilai lebih dari 0
        $lastRow = $sheet->getHighestRow();
        for ($row = 3; $row <= $lastRow; $row++) { // Baris dimulai dari baris data pertama
            $overdueCell = 'J' . $row; // Kolom J untuk Overdue
            if ((int) $sheet->getCell($overdueCell)->getValue() > 0) {
                $sheet->getStyle($overdueCell)->applyFromArray([
                    'font' => [
                        'color' => ['argb' => 'FF0000'], // Warna merah
                    ],
                ]);
            }
        }
    }
}