<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HistoryLeaderExport implements FromCollection, WithHeadings
{
    protected $data;
    protected $segment;
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($data, $segment) {
        $this->data = $data;
        $this->segment = $segment;

    }
    public function collection()
    {
        return $this->data->map(function($d) {
            return [
                'ID'        => $d->dn_no,
                'Part name' => $d->part_name,
                'Part number' => $d->part_number,
                'Sequence' => $d->seq_no,
                'Tanggal'   => $d->checked_at,
                'Full Name' => $this->segment == 'loading'
                                ? ($d->loading->full_name ?? '-')
                                : ($d->checker->full_name ?? '-'),
            ];
        });
    }

    public function headings(): array{
        return [
            'No DN/Manifest',
            'Part Name',
            'Part Number',
            'Sequence',
            'Waktu',
            'User'
        ];
    }
}
