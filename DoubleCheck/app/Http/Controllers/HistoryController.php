<?php

namespace App\Http\Controllers;

use App\Models\TblInputLog;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\TblKbndelivery;
use App\Exports\HistoryExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\HistoryAdminExport;
use App\Exports\HistoryLeaderExport;

class HistoryController extends Controller
{
    public function admin(Request $request) {
        $historyData = TblInputLog::select('no_dn', 'created_at', 'scanned_by')
        ->with('scanByUser')
        ->orderBy('created_at', 'desc');

        if($request->filled('date_range')) {
            $dates = explode(' - ', $request->date_range);
            if(count($dates) === 2) {
            $start = Carbon::createFromFormat('m/d/Y', $dates[0])->startOfDay();
            $end   = Carbon::createFromFormat('m/d/Y', $dates[1])->endOfDay();

                $historyData->whereBetween('created_at', [$start, $end]);
            }
        }
        if($request->filled('export')) {
            return Excel::download(new HistoryAdminExport($historyData->get()), 'historyPosting.xlsx');
        }
        $historyData = $historyData->paginate(15);
        return view('pages.history',
            ['judul' => 'Riwayat Scan Posting Admin',
                    'data' => $historyData]);
    }
    public function leader(Request $request) {
        $historyData = TblKbndelivery::where('tbl_kbndelivery.check_leader', 1)
            ->select(
                'tbl_kbndelivery.kbndn_no',
                'tbl_kbndelivery.dn_no',
                'tbl_kbndelivery.checked_at',
                'tbl_kbndelivery.checked_by',
                'tbl_kbndelivery.invid',
                'tbl_kbndelivery.seq_no',
                DB::raw('COALESCE(
                    masterpart_hino.PartName,
                    masterpart_hpm.PartName,
                    masterpart_mmki.PartName,
                    masterpart_suzuki.PartName,
                    masterpart_tmmin.PartName
                ) as part_name'),
                 DB::raw('COALESCE(
                    masterpart_hino.PartNo,
                    masterpart_hpm.PartNo,
                    masterpart_mmki.PartNo,
                    masterpart_suzuki.PartNo,
                    masterpart_tmmin.PartNo
                ) as part_number')
            )
            ->with('checker')
            ->leftJoin('masterpart_hino', 'masterpart_hino.InvId', '=', 'tbl_kbndelivery.invid')
            ->leftJoin('masterpart_hpm', 'masterpart_hpm.InvId', '=', 'tbl_kbndelivery.invid')
            ->leftJoin('masterpart_mmki', 'masterpart_mmki.InvId', '=', 'tbl_kbndelivery.invid')
            ->leftJoin('masterpart_suzuki', 'masterpart_suzuki.InvId', '=', 'tbl_kbndelivery.invid')
            ->leftJoin('masterpart_tmmin', 'masterpart_tmmin.InvId', '=', 'tbl_kbndelivery.invid')
            ->orderBy('checked_at', 'desc');

            if($request->filled('date_range')) {
                $dates = explode(' - ', $request->date_range);
                if(count($dates) === 2) {
                    $start = Carbon::createFromFormat('m/d/Y', $dates[0])->startOfDay();
                    $end   = Carbon::createFromFormat('m/d/Y', $dates[1])->endOfDay();

                    $historyData->whereBetween('checked_at', [$start, $end]);
                }
            }

            if($request->filled('export')) {
                $segment = request()->segment(2);
                return Excel::download(new HistoryLeaderExport($historyData->get(), $segment), 'historyDoubleCheck.xlsx');
            }

            $historyData = $historyData->paginate(15);
        return view('pages.history', [
            'judul' => 'Riwayat Scan Check Leader',
            'data' => $historyData ]);
    }
    public function loading(Request $request) {
        $historyData = TblKbndelivery::where('tbl_kbndelivery.check_loading', 1)
            ->select(
                'tbl_kbndelivery.kbndn_no',
                'tbl_kbndelivery.dn_no',
                'tbl_kbndelivery.checked_at',
                'tbl_kbndelivery.check_load_by',
                'tbl_kbndelivery.invid',
                'tbl_kbndelivery.seq_no',
                DB::raw('COALESCE(
                    masterpart_hino.PartName,
                    masterpart_hpm.PartName,
                    masterpart_mmki.PartName,
                    masterpart_suzuki.PartName,
                    masterpart_tmmin.PartName
                ) as part_name'),
                 DB::raw('COALESCE(
                    masterpart_hino.PartNo,
                    masterpart_hpm.PartNo,
                    masterpart_mmki.PartNo,
                    masterpart_suzuki.PartNo,
                    masterpart_tmmin.PartNo
                ) as part_number')
            )
            ->with('loading')
            ->leftJoin('masterpart_hino', 'masterpart_hino.InvId', '=', 'tbl_kbndelivery.invid')
            ->leftJoin('masterpart_hpm', 'masterpart_hpm.InvId', '=', 'tbl_kbndelivery.invid')
            ->leftJoin('masterpart_mmki', 'masterpart_mmki.InvId', '=', 'tbl_kbndelivery.invid')
            ->leftJoin('masterpart_suzuki', 'masterpart_suzuki.InvId', '=', 'tbl_kbndelivery.invid')
            ->leftJoin('masterpart_tmmin', 'masterpart_tmmin.InvId', '=', 'tbl_kbndelivery.invid')
            ->orderBy('checked_at', 'desc');

            if($request->filled('date_range')) {
                $dates = explode(' - ', $request->date_range);
                if(count($dates) === 2) {
                    $start = Carbon::createFromFormat('m/d/Y', $dates[0])->startOfDay();
                    $end   = Carbon::createFromFormat('m/d/Y', $dates[1])->endOfDay();

                    $historyData->whereBetween('checked_at', [$start, $end]);
                }
            }

            if($request->filled('export')) {
                $segment = request()->segment(2);
                return Excel::download(new HistoryLeaderExport($historyData->get(), $segment), 'historyLoading.xlsx');
            }

            $historyData = $historyData->paginate(15);

        return view('pages.history', ['judul' => 'Riwayat Scan Check Loading'], ['data' => $historyData]);
    }

    public function adminExport(Request $request) {
        $historyData = TblInputLog::select('no_dn', 'created_at', 'scanned_by')
        ->with('scanByUser')
        ->orderBy('created_at', 'desc');

        if($request->filled('date_range')) {
            $dates = explode(' to ', $request->date_range);
            if(count($dates) === 2) {
                $start = $dates[0];
                $end   = $dates[1];

                $historyData->whereBetween('created_at', [$start, $end]);
            }
        }

        $historyData = $historyData->get();
        return Excel::download(new HistoryExport($historyData), 'history.xlsx');
    }

    public function leaderExport(Request $request) {
        $historyData = TblKbndelivery::where('tbl_kbndelivery.check_leader', 1)
            ->select(
                'tbl_kbndelivery.kbndn_no',
                'tbl_kbndelivery.dn_no',
                'tbl_kbndelivery.checked_at',
                'tbl_kbndelivery.checked_by',
                'tbl_kbndelivery.invid',
                'tbl_kbndelivery.seq_no',
                DB::raw('COALESCE(
                    masterpart_hino.PartName,
                    masterpart_hpm.PartName,
                    masterpart_mmki.PartName,
                    masterpart_suzuki.PartName,
                    masterpart_tmmin.PartName
                ) as part_name'),
                 DB::raw('COALESCE(
                    masterpart_hino.PartNo,
                    masterpart_hpm.PartNo,
                    masterpart_mmki.PartNo,
                    masterpart_suzuki.PartNo,
                    masterpart_tmmin.PartNo
                ) as part_number')
            )
            ->with('checker')
            ->leftJoin('masterpart_hino', 'masterpart_hino.InvId', '=', 'tbl_kbndelivery.invid')
            ->leftJoin('masterpart_hpm', 'masterpart_hpm.InvId', '=', 'tbl_kbndelivery.invid')
            ->leftJoin('masterpart_mmki', 'masterpart_mmki.InvId', '=', 'tbl_kbndelivery.invid')
            ->leftJoin('masterpart_suzuki', 'masterpart_suzuki.InvId', '=', 'tbl_kbndelivery.invid')
            ->leftJoin('masterpart_tmmin', 'masterpart_tmmin.InvId', '=', 'tbl_kbndelivery.invid')
            ->orderBy('checked_at', 'desc');

            if($request->filled('date_range')) {
                $dates = explode(' to ', $request->date_range);
                if(count($dates) === 2) {
                    $start = $dates[0];
                    $end   = $dates[1];

                    $historyData->whereBetween('checked_at', [$start, $end]);
                }
            }

            $historyData = $historyData->get();
            return Excel::download(new HistoryExport($historyData), 'history.xlsx');
    }

    public function loadingExport(Request $request) {
        $historyData = TblKbndelivery::where('tbl_kbndelivery.check_loading', 1)
            ->select(
                'tbl_kbndelivery.kbndn_no',
                'tbl_kbndelivery.dn_no',
                'tbl_kbndelivery.checked_at',
                'tbl_kbndelivery.check_load_by',
                'tbl_kbndelivery.invid',
                'tbl_kbndelivery.seq_no',
                DB::raw('COALESCE(
                    masterpart_hino.PartName,
                    masterpart_hpm.PartName,
                    masterpart_mmki.PartName,
                    masterpart_suzuki.PartName,
                    masterpart_tmmin.PartName
                ) as part_name'),
                 DB::raw('COALESCE(
                    masterpart_hino.PartNo,
                    masterpart_hpm.PartNo,
                    masterpart_mmki.PartNo,
                    masterpart_suzuki.PartNo,
                    masterpart_tmmin.PartNo
                ) as part_number')
            )
            ->with('loading')
            ->leftJoin('masterpart_hino', 'masterpart_hino.InvId', '=', 'tbl_kbndelivery.invid')
            ->leftJoin('masterpart_hpm', 'masterpart_hpm.InvId', '=', 'tbl_kbndelivery.invid')
            ->leftJoin('masterpart_mmki', 'masterpart_mmki.InvId', '=', 'tbl_kbndelivery.invid')
            ->leftJoin('masterpart_suzuki', 'masterpart_suzuki.InvId', '=', 'tbl_kbndelivery.invid')
            ->leftJoin('masterpart_tmmin', 'masterpart_tmmin.InvId', '=', 'tbl_kbndelivery.invid')
            ->orderBy('checked_at', 'desc');

            if($request->filled('date_range')) {
                $dates = explode(' to ', $request->date_range);
                if(count($dates) === 2) {
                    $start = $dates[0];
                    $end   = $dates[1];

                    $historyData->whereBetween('checked_at', [$start, $end]);
                }
            }

            $historyData = $historyData->get();
            return Excel::download(new HistoryExport($historyData), 'history.xlsx');
    }
}
