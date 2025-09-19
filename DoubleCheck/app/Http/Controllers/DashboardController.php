<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\TblUser;
use App\Services\DashboardServices;
use Database\Factories\CustomerFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\TblKbndelivery;

class DashboardController extends Controller
{
    protected $filters = [];

    public function hero(Request $request, DashboardServices $dashboardServices) {
        // versi
        $version = '1.1.0';

        $customer = null;
        if($request->input('customer') !== "all") {
            $customer = $request->input('customer');
        }
        $this->filters = [
            'customer' => $customer,
            'tanggal_order' => Carbon::parse($request->input('date'))->format('d-m-Y') ?? null
        ];

        // Simpan ke session
        session(['dashboard_filters' => $this->filters]);

        $dataAll = $dashboardServices->dataToday2($this->filters);


        $planDN = $dataAll
            ->groupBy('dn_no')
            ->count();
        $planPcs = $dataAll
            ->sum( function ($i) {
                return $i->qty_pcs;
            });


        // menghitung actual
        $actualAdmin = $dataAll
            ->where('status_admin', "OK")
            ->groupBy('dn_no')
            ->count();
        $actualMember = $dataAll
            ->where('status_label', "Close")
            ->sum (function ($i) {
                return $i->QtyPerKbn * $i->countP;
            });

        $actualLeader = $dataAll
            ->where('check_leader', '>',  0)->sum (function ($i) {
                return $i->QtyPerKbn * $i->check_leader;
            });


        // dokumen === surat jalan
        $actualDocument = $dataAll
            ->where('check_sj', '>', 0)
            ->groupBy('dn_no')
            ->count();
        $actualLoad = $dataAll
            ->where('check_loading', '>', 0)
            ->sum (function ($i) {
                return $i->QtyPerKbn * $i->check_loading;
            });

        $charts = $this->calculatePlanByCycle($dataAll);
        $dataActual = [
            'admin' =>$actualAdmin,
            'prepare' => $actualMember,
            'leader' => $actualLeader,
            'document' => $actualDocument,
            'load' => $actualLoad
        ];
        $dataPlan = [
            'planDN' => $planDN,
            'planPcs' => $planPcs
        ];

        $lastUpdate = TblKbndelivery::latest('datetime_input')->first()?->datetime_input;

        return view('welcome',[
            'version' => $version,
            'charts' => $charts,
            'dataActual' => $dataActual,
            'dataPlan' => $dataPlan,
            'lastUpdate' => $lastUpdate
        ]);
    }

    public function calculatePlanByCycle($dataAll) {
        // 1. Dapatkan daftar siklus unik (labels)
        $uniqueCycles = $dataAll->pluck('cycle')->unique()->sort()->values()->toArray();

        // 2. Inisialisasi struktur data untuk chart
        $initialDataArray = array_fill(0, count($uniqueCycles), 0);

        $charts = [
            'labels' => $uniqueCycles,
            'order' => ['actual' => $initialDataArray],
            'prepare' => ['actual' => $initialDataArray],
            'leaderCheck' => ['actual' => $initialDataArray],
            'docCheck' => ['actual' => $initialDataArray],
            'loading' => ['actual' => $initialDataArray]
        ];

        // 3. Kelompokkan data berdasarkan cycle dan hitung nilai actual
        $groupedByCycle = $dataAll->groupBy('cycle');

        foreach ($groupedByCycle as $cycle => $data) {
            $cycleIndex = array_search($cycle, $uniqueCycles);

            if ($cycleIndex !== false) {
                // actual untuk Order, Document Check, dan Loading adalah jumlah item
                $charts['order']['actual'][$cycleIndex] = $data ->where('status_admin', "OK")->groupBy('dn_no')->count();
                $charts['docCheck']['actual'][$cycleIndex] = $data->where('check_sj', '>', 0)->groupBy('dn_no')->count();

                // actual untuk Prepare dan Leader Check adalah total QtyPerKbn * countP
                $actualMember = $data
                        ->where('status_label', "Close")
                        ->sum (function ($i) {
                            return $i->QtyPerKbn * $i->countP;
                        });
                $actualLeader = $data
                        ->where('check_leader', '>', 0)
                        ->sum (function ($i) {
                            return $i->QtyPerKbn * $i->check_leader;
                        });
                $actualLoading = $data
                        ->where('check_loading', '>', 0)
                        ->sum(function ($i) {
                            return $i->QtyPerKbn * $i->check_loading;
                        });
                $charts['prepare']['actual'][$cycleIndex] = $actualMember;
                $charts['leaderCheck']['actual'][$cycleIndex] = $actualLeader;
                $charts['loading']['actual'][$cycleIndex] = $actualLoading; //hitungan loading pcs



                // Plan untuk Order, Document Check, dan Loading adalah jumlah item
                $charts['order']['plan'][$cycleIndex] = $data->groupBy('dn_no')->count();
                $charts['docCheck']['plan'][$cycleIndex] = $data->groupBy('dn_no')->count();

                // plan untuk Prepare dan Leader Check
                $PlanMember = $data->sum('qty_pcs');
                $PlanLeader = $data->sum('qty_pcs');
                $PlanLoading = $data->sum('qty_pcs');
                $charts['prepare']['plan'][$cycleIndex] = $PlanMember;
                $charts['leaderCheck']['plan'][$cycleIndex] = $PlanLeader;
                $charts['loading']['plan'][$cycleIndex] = $PlanLoading;

            }
        }
        return $charts;
    }

    public function scanAdmin() {

        $user = Auth::user();
        if(in_array($user->id_role, [1, 2, 4])) {
            return view('pages.admin',
            [
                'judul' => 'Scan Admin',
            ])->with('success', 'Login berhasil!');
        } else {
            return redirect()->back()->with('error', 'User tidak memiliki akses untuk melakukan job!');
        }
    }

    public function scanLeader() {
        if(in_array(Auth::user()->id_role, [1, 2, 3])) {
            return view('pages.leader',
            [
                'judul' => 'Scan Checking Leader',
            ])->with('success', 'Login berhasil!');
        } else {
            return redirect()->back()->with('error', 'User tidak memiliki akses untuk melakukan job!');

        }
    }
    public function checkSuratJalan() {
        return view('pages.sj-loading',
        [
            'judul' => 'Check Surat Jalan',
        ]);
    }
    public function checkPartsLoading() {
        $customers = [
            'HPM' => 'vw_kbndelivery_hpm',
            'ADM' => 'vw_kbndelivery_adm',
            'HINO' => 'vw_kbndelivery_hino',
            'MMKI' => 'vw_kbndelivery_mmki',
            'SUZUKI' => 'vw_kbndelivery_suzuki',
            'TMMIN' => 'vw_kbndelivery_tmmin',
        ];
        return view('pages.loading-parts',[
            'judul' => 'Check Loading Parts',
            'customers' => $customers
        ]);
    }

    public function messages() {
        return view('errors.503');
    }

    public function tableModal(Request $request, DashboardServices $dashboardServices) {
        $filter = session('dashboard_filters');
        $dataAll = $dashboardServices->dataModal($filter, $request);

        return response()->json(array_values($dataAll->toArray()));
    }
}
