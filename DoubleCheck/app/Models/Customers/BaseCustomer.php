<?php

namespace App\Models\Customers;

use App\Models\TblKbndelivery;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Database\Factories\CustomerFactory;
use Carbon\Carbon;

abstract class BaseCustomer extends Model
{
    protected $tableName;
    protected $logChannel;
    abstract public function getTableName(): string;
    abstract protected function getLogChannel(): string;
    abstract public function getTableMasterparts(): string;
    abstract public function vwTblKbn(): string;
    abstract public function vwTblData(): string;

    // ambil data manifest pada cycle yg ditentukan
    public function checkManifestCustomer($cycle, $route) {
        $normalizedRoute = str_replace(['-', ' '], '', $route);
        $datas = DB::table($this->getTableName())
                ->where('cycle', $cycle)
                ->whereRaw("REPLACE(REPLACE(plan, '-', ''), ' ', '') = ?", [$normalizedRoute])
                ->orderBy('tanggal_order', 'asc')
                ->get();

        return $datas;
    }

    public function getDataManifest($manifest_id, $process, $cycle){
        $manifest = DB::table($this->getTableName())
                    ->where('cycle', $cycle)
                    ->where('dn_no', $manifest_id)
                    ->first();

        if(!$manifest) {
            return false;
        }

        $check = $this->tableLogCheck($manifest_id, 'OK', $process);

        if($check === true) {
            return true;
        };

        return $manifest;
    }

    public function checkManifestCustomerSJ($cycle, $manifest_id, $date) {
        $datas = DB::table($this->getTableName())
                ->where('dn_no', $manifest_id)
                ->where('cycle', $cycle)
                ->where('tanggal_order', $date)
                ->get();

        if($datas) {
            return $datas;
        } else {
            return null;
        }
    }

    public function checkAllPostSJ($datas, $manifest_id) {
        $statusAll = $this->manifestWithSuratJalan($datas);

        $firstKey = $statusAll->keys()->first();

        if($firstKey === null) {
            return null;
        }
        $statusAdmin = $statusAll[$firstKey][0]->scan_admin ?? null;
        $statusMember =$statusAll[$firstKey][0]->prep_member ?? null;
        $statusLeader = $statusAll[$firstKey][0]->check_leader ?? null;

        if($statusAdmin === "OK" && $statusMember === "Close" && $statusLeader !== null) {
            $check = $this->tblSjCheck($manifest_id, $datas ? 1 :0);
            if($check === true) {
                return false;
            }
        } else {
            return null;
        }
        return true;
    }

    public function checkManifestLoading($manifest_id, $cycle) {
        $datas = DB::table($this->getTableName())
                ->where('dn_no', $manifest_id)
                ->where('cycle', $cycle)
                ->get();

        if($datas) {
            $check = $this->tblCheckLoading($manifest_id, $datas ? 1 : 0);
            if($check === false) {
                return false;
            }
        } else {
            return null;
        }
        return $datas;
    }

    public function tblCheckLoading($dn, $status) {
        $data = DB::table('tbl_check_sj')
            ->where('dn_no', $dn)
            ->where('table_name', $this->getTableName())
            ->where('check_loading', null)
            ->first();

        if ($data) {
            DB::table('tbl_check_sj')
                ->where('dn_no', $dn)
                ->where('table_name', $this->getTableName())
                ->update(['check_loading' => $status,
                    'checked_at' => now(),
            ]);
        } else {
            return false;
        }
    }

    public function tblSjCheck($dn, $status) {
        // nama fungsinya still, ganti nama table aja
        $data = DB::table('tbl_kbndelivery')
            ->where('dn_no', $dn)
            ->where('check_sj', true)
            ->first();

        if ($data) {
            return true;
        } else {
            DB::table('tbl_kbndelivery')
                ->where('dn_no', $dn)
                ->update([
                    'check_sj' => true,
                    'time_sj' => now()
                ]);
        }

    }

    public function tableLogCheck ($manifest_id, $status, $process) {
        // check log
        $check = DB::table('tb_input_log')
            ->where('customer_tbl', $this->getTableName())
            ->where('no_dn', $manifest_id);

        if ($check->exists()) {
            return true;
        }
        DB::table('tb_input_log')
            ->insert([
                'no_dn' => $manifest_id,
                'status' => $status,
                'process' => $process,
                'customer_tbl' => $this->getTableName(),
                'scanned_by' => auth()->user()->id_user,
                'created_at' => now(),
                'updated_at' => now()
            ]);
    }

    // ambil data di tabel log
    public function getLatestStatus($manifest_id) {
        return DB::table('tb_input_log')
            ->where('customer_tbl', $this->getTableName())
            ->where('file_number', $manifest_id)
            ->latest('scan_timestamp')
            ->value('status');
    }

    // satukan data manifest dan log
    public function getAllWithStatus($filteredData) {

        if (!$filteredData instanceof \Illuminate\Support\Collection) {
            $filteredData = collect($filteredData);
        }

        $fileNumbers = $filteredData->pluck('dn_no')->unique()->filter()->values();

        // ambil status terakhir untuk setiap manifest
        if ($fileNumbers->isEmpty()) {
            return $filteredData->map(function ($item) {
                $item->status = null;
                return $item;
            });
        }

        $statuses = DB::table('tb_input_log')
            ->where('customer_tbl', $this->getTableName())
            ->whereIn('no_dn', $fileNumbers)
            ->select('no_dn', 'status')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('no_dn')
            ->map(function ($logs) {
                return $logs->first()->status;
            });

        return $filteredData->map(function ($customer) use ($statuses) {
            $customer->status = $statuses[$customer->dn_no] ?? null;
            return $customer;
        });
    }

    // ambil data manifest yg OK
    public function getOkManifest ($filteredData) {
    }


    public function getMasterparts ($manifest, $date) {
        $datas = DB::table($this->vwTblKbn())
            ->where('tanggal_order', $date)
            ->where('dn_no', $manifest)
            ->get();

        $invIds = $datas->pluck('InvId')->toArray();
        $dnNos = $datas->pluck('dn_no')->toArray();

        $qty = DB::table($this->vwTblData())
            ->select('qty_pcs', 'PartNo', 'dn_no', 'InvId', 'QtyPerKbn', 'countP')
            ->whereIn('dn_no', $dnNos)
            ->whereIn('InvId', $invIds)
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->dn_no . '|' . $item->InvId => $item];
            });

        $datas = $datas->map(function ($data) use ($qty) {
            $key = $data->dn_no . '|' . $data->InvId;
            if (isset($qty[$key])) {
                $data->qty_pcs = $qty[$key]->qty_pcs;
                $data->PartNo = $qty[$key]->PartNo;
                $data->QtyPerKbn = $qty[$key]->QtyPerKbn;
                $data->countP = $qty[$key]->countP;
            } else {
                $data->qty_pcs = null;
                $data->PartNo = null;
                $data->QtyPerKbn = null;
                $data->countP = null;
            }
            return $data;
        });

        // grup data berdasarkan inv id
        Log::debug('basecust', [$datas, $qty]);
        $datas = $datas
            ->groupBy('InvId')
            ->map( function ($item, $invId){
                return [
                    'inv_id' => $invId,
                    'total_label' => $item->count(),
                    'total_checked' => $item->where('check_leader', 1)->count(),
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
        return $datas;
    }

    public function getDataLabel($labelNo) {
        $data = DB::table('tbl_kbndelivery')
            ->where('kbndn_no', $labelNo)
            ->first();

        if($data) {
            $check = $this->checkDataLabel($labelNo, $data ? true : false);
            if($check === false) {
                return false;
            };
        }
        return $data;
    }

    public function checkDataLabel($labelNo, $status) {
        $check = DB::table('tbl_kbndelivery')
            ->where('kbndn_no', $labelNo)
            ->where('check_leader', null)
            ->get();

        if($check->isEmpty()) {
            return false;
        } else {
            DB::table('tbl_kbndelivery')
            ->where('kbndn_no', $labelNo)
            ->where('check_leader', null)
            ->update([
                'check_leader' => $status,
                'checked_by' => auth()->user()->id_user,
                'checked_at' => now()
            ]);
        }


    }

    public function dailyCheck($date = null) {
        $date = $date ? Carbon::parse($date) : Carbon::today();
        $formatedDate = $date ->format('d-m-Y');

        $manifests = DB::table($this->vwTblData())
            ->where('tanggal_order', $formatedDate)
            ->select('dn_no', 'job_no', 'tanggal_order', 'qty_pcs', 'QtyPerKbn', 'sequence', 'countP', 'status_label', 'cycle', 'customerpart_no')
            ->get();

        if($manifests->isEmpty()) {
            return collect([]);
        }

        $manifestNumber = $manifests->pluck('dn_no')->unique()->values();

        $status = DB::table('tb_input_log')
            ->whereIn('no_dn', $manifestNumber)
            ->select('no_dn', 'status')
            ->get()
            ->groupBy('no_dn')
            ->map(function ($logs) {
                return $logs->first()->status;
            });
            // gabungkan data manifest dengan status
            $data = $manifests->map(function ($manifest) use ($status) {
                $manifest->status = $status[$manifest->dn_no] ?? null;
                return $manifest;
            });
        return $data;
    }

    public function getTodayManifest($date = null) {
        $date = $date ? Carbon::parse($date) : Carbon::today();
        $formatedDate = $date->format('d-m-Y');

        $manifests = DB::table($this->vwTblData())
            ->where('tanggal_order', $formatedDate)
            ->select('dn_no', 'job_no', 'tanggal_order', 'qty_pcs', 'QtyPerKbn', 'sequence', 'countP', 'status_label', 'cycle', 'customerpart_no' )
            ->get();

        return $manifests;
    }

    public function dataDashboardChecked($date = null) {
        $data = $this->getTodayManifest($date);
        $manifestNumber = $data->pluck('dn_no')->unique()->values();
        $jobNumber = $data->pluck('job_no')->unique()->values();

        $checkLeader = TblKbndelivery::query()
            ->whereIn('kbndn_no', $manifestNumber)
            ->whereIn('job_no', $jobNumber)
            ->select('kbndn_no', 'job_no', 'check_leader', 'checked_by')
            ->with('checker')
            ->get()
            ->groupBy('kbndn_no')
            ->map(function ($logs) {
                return $logs->first();
            });

        // gabungkan data
        $datas = $data->map(function ($manifest) use ($checkLeader) {
            $status = $checkLeader[$manifest->dn_no] ?? null;
            $manifest->check_leader = $status ? $status->check_leader : null;
            $manifest->checked_by = $status ? $status->checked_by: null;
            return $manifest;
        });

        return $datas;
    }

    public function manifestWithSuratJalan($filteredData) {
        $dnNumbers = $filteredData->pluck('dn_no')->toArray();
        $result = DB::table($this->vwTblData() . ' AS m')
            ->leftJoin('tb_input_log AS il', function($join) {
                $join->on('m.dn_no', '=', 'il.no_dn')
                    ->where('il.customer_tbl', $this->getTableName());
            })
            ->leftJoin('tbl_kbndelivery AS kbn', 'm.dn_no', '=', 'kbn.dn_no')
            ->whereIn('m.dn_no', $dnNumbers)
            ->select(
                'm.tanggal_order',
                'm.dn_no',
                'il.status AS scan_admin',
                'm.status_label AS prep_member',
                'kbn.check_leader',
                'kbn.check_loading',
                'kbn.check_sj'
            )
            ->get();
        $result = collect($result)->groupBy('dn_no');

        return $result;
    }

    public function parseCustomerLabel($label) {
        $reduction = $this->getReduction();

        // cek panjang label/inputan
        if (strlen($label) <= $reduction) {
            return $label;
        }

        $hasil = substr($label, 0, $reduction);
        return $hasil;
    }
}
