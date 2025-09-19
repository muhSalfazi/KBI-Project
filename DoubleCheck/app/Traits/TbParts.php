<?php

namespace App\Traits;
use Database\Factories\CustomerFactory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

trait TbParts {
    public function manifestSuratJalan($customer, $route, $cycle, $date) {
        try{
            $object = CustomerFactory::createCustomerInstance($customer);
            $manifests = $object->checkManifestCustomer($cycle, $route);
            if ($date) {
                $manifests = $manifests->filter(function ($item) use ($date) {
                    return Carbon::parse($item->tanggal_order)->toDateString() === $date;
                });
            }
            $statusSJ = $object->manifestWithSuratJalan($manifests)
                ->map(function ($rows, $dn_no) {
                    return [
                        'dn_no'          => $dn_no,
                        'tanggal_order'  => $rows->first()->tanggal_order,
                        'prep_member'    => $rows->contains(fn($r) => $r->prep_member === 'Open') ? 'Open' : 'Close',
                        'scan_admin'    => $rows->contains(fn($r) => is_null($r->scan_admin)) ? null : 'OK',
                        'check_leader'   => $rows->contains(fn($r) => is_null($r->check_leader)) ? null : 1,
                        'check_loading'  => $rows->contains(fn($r) => is_null($r->check_loading)) ? null : 1,
                        'check_sj'       => $rows->contains(fn($r) => !$r->check_sj) ? null : 1,
                    ];
                })
                ->values();
            Log::debug('tb parts', [$statusSJ]);
            return $statusSJ;
        } catch (\Throwable $e) {
            Log::error('Traits TbParts Error' . $e->getMessage());
            return response()->json(['error' => 'Server error'], 500);
        }
    }

    public function partsSuratJalan($customer, $route, $cycle, $date) {
        $data = $this->manifestSuratJalan($customer, $route, $cycle, $date);
        $dn = $data->pluck('dn_no');

        $tbName = [
            'hpm' => 'vw_kbndelivery_hpm',
            'adm' => 'vw_kbndelivery_adm',
            'hino' => 'vw_kbndelivery_hino',
            'tmmin' => 'vw_kbndelivery_tmmin',
            'mmki' => 'vw_kbndelivery_mmki',
            'suzuki' => 'vw_kbndelivery_suzuki'
        ];

        $customer = $tbName[$customer];

        $kbnDel = DB::table($customer)
            ->whereIn('dn_no', $dn)
            ->where('check_sj', 1)
            ->select('dn_no', 'InvId', 'PartNo', 'PartName', 'QtyPerKbn', 'qty_pcs', 'check_loading', 'countP')
            ->get();
        $invId = $kbnDel->pluck('InvId');
        $datas = $kbnDel
            ->groupBy('InvId')
            ->map( function ($item, $invId){
                return [
                    'InvId' => $invId,
                    'total_label' => $item->count(),
                    'total_checked' => $item->where('check_loading', 1)->count(),
                    'part_name' => $item->first()->PartName ?? null,
                    'part_no' => $item->first()->PartNo ?? null,
                    'status_label' => $item->first()->status_label ?? null,
                    'qty_pcs' => $item->first()->qty_pcs ?? null,
                    'QtyPerKbn' => $item->first()->QtyPerKbn ?? null,
                    'countP' => $item->first()->countP ?? null,
                    'qty_loading_check' => $item->where('check_loading', 1)->count(),
                ];
            })
            ->values();

        $datas = $datas->values()->map(function ($item) {
            return (object) $item;
        });


        return $datas;
    }
}
?>
