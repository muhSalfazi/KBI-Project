<?php

namespace App\Imports;

use App\Models\TblDeliveryhpm;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\Log;
use App\Models\TblDeliveryadm;

class UsersImport implements ToModel
{
    protected $target;

    // constructor untuk tentukan target tabel
    public function __construct($target)
    {
        $this->target = $target;
    }
    public function model(array $row)
    {
        try {
            // Skip baris kosong
            if (empty($row[0]) && empty($row[1])) {
                return null;
            }

            // Konversi tanggal order (kolom 4)
            $tanggal_order = null;
            if (!empty($row[4])) {
                if (is_numeric($row[4])) {
                    $tanggal_order = Date::excelToDateTimeObject($row[4])->format('Y-m-d');
                } else {
                    $tanggal_order = date('d-m-Y', strtotime($row[4]));
                }
            }

            // Konversi ETA (kolom 7) ke format H:i:s
            $eta = null;
            if (!empty($row[7])) {
                if (is_numeric($row[7])) {
                    $eta = Date::excelToDateTimeObject($row[7])->format('H:i:s');
                } else {
                    $eta = date('H:i:s', strtotime($row[7]));
                }
            }

        if ($this->target === 'hpm') {
            return $this->ImportHPM($row, $tanggal_order, $eta);
        } else if ($this->target === 'adm') {
            return $this->ImportADM($row, $tanggal_order, $eta);
        }

        } catch (\Exception $e) {
            Log::error('Error importing excel row: ' . json_encode($row) . ' | Error: ' . $e->getMessage());
            return null; // supaya tidak menggagalkan semua proses
        }
    }

    protected function ImportHPM($row, $tanggal_order, $eta) {
            return new TblDeliveryhpm([
                'dn_no'           => trim($row[0]),
                'job_no'          => trim($row[1]),
                'customerpart_no' => trim($row[2]),
                'qty_pcs'         => (int)$row[3],
                'tanggal_order'   => $tanggal_order,
                'plan'            => trim($row[5]),
                'status'          => "Open",
                'ETA'             => $eta,
                'cycle'           => (int)$row[6],
                'user'            => null,
                'count_process'   => null,
                'datetime_input'  => now(),
            ]);
    }

        protected function ImportADM($row, $tanggal_order, $eta) {
            return new TblDeliveryadm([
                'dn_no'           => trim($row[0]),
                'job_no'          => trim($row[1]),
                'customerpart_no' => trim($row[2]),
                'qty_pcs'         => (int)$row[3],
                'tanggal_order'   => $tanggal_order,
                'plan'            => trim($row[5]),
                'status'          => "Open",
                'ETA'             => $eta,
                'cycle'           => (int)$row[6],
                'user'            => null,
                'count_process'   => null,
                'datetime_input'  => now(),
            ]);
    }
}
