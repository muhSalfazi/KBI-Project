<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HistoryAdminExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data) {
        $this->data = $data;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->data->map(function($d) {
            return [
                'ID'        => $d->no_dn,
                'Tanggal'   => $d->created_at->format('Y-m-d H:i:s'),
                'Full Name' => $d->scanByUser->full_name ?? '-',
            ];
        });
    }

    public function headings():array{
        return [
            'No DN',
            'Tanggal Scan',
            'Scan By'
        ];
    }
}
