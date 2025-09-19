<?php

namespace App\Http\Controllers;

use App\Models\TblKbndelivery;
use App\Services\UserSecurityServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Database\Factories\CustomerFactory;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Traits\TbParts;
use Illuminate\Support\Facades\Auth;


class CustomerLabelController extends Controller
{
    use TbParts;
    public $user;
    public function __construct() {
        $this->user = auth()->user();
    }

    public function getPartsData (Request $request, UserSecurityServices $userServices) {
        $customer = strtolower(session('customer'));
        $cycle = session('cycle');
        $route = session('route');

        $manifest = $request->input('manifest');
        $date = Carbon::parse($request->input('date'))->format('d-m-Y');

        $objekCustomer = CustomerFactory::createCustomerInstance($customer);

        // check dan parsing manifest
        $manifestParse = $objekCustomer->parseCustomerLabel($manifest);

        // check all post untuk req loading
        if($request->input('loading')) {
            $dataTable = $this->manifestSuratJalan($customer, $route, $cycle, $request->input('date'));
            $check = $dataTable->where('dn_no', $manifestParse)->first();
            if(is_null($check)) {
                return response()
                ->json([
                    'success' => false,
                    'type' => 'error',
                    'message' => 'Data manifest tidak sesuai!'
                ], 200);
            }
            $checkLeader = $dataTable->firstWhere('dn_no', $manifestParse)['check_leader'];
            $checkMember = $dataTable->firstWhere('dn_no', $manifestParse)['prep_member'];
            if($checkLeader === null || $checkMember === "Open") {
                return response()
                    ->json([
                        'success' => false,
                        'type' => 'error',
                        'message' => 'Manifest belum check semua post!'
                    ]);
            }
        }

        $dataParts =$objekCustomer->getMasterparts($manifestParse, $date);
        Log::debug('getPartsData', [$dataParts]);
        // untuk parameter suara scan parts
        $totalRow = $dataParts->sum('total_label');

        if($dataParts->count() > 0) {
            return response()
                ->json([
                    'success' => true,
                    'type' => 'success',
                    'message' => 'Data manifest sesuai!',
                    'html' => view('partials.table-parts', compact('dataParts'))->render(),
                    'totalRow' => $totalRow
                ], 200);
        } else {
            return response()
                ->json([
                    'success' => false,
                    'type' => 'error',
                    'message' => 'Data manifest tidak sesuai!'
                ], 200);
        }
    }

    public function checkPartData(Request $request, UserSecurityServices $userServices) {
        $request->validate([
            'parts' => 'required'
        ]);

        $customer = strtolower(session('customer'));

        $label = $request->input('parts');
        $date = Carbon::parse($request->input('date'))->format('d-m-Y');

        $objekCust = CustomerFactory::createCustomerInstance($customer);
        $checkedLabel = $objekCust->getDataLabel($label);

        // untuk render table
        $manifestParse = $objekCust->parseCustomerLabel($label);
        $dataParts = $objekCust->getMasterparts($manifestParse, $date);

        // check semua close untuk leader
        $checkedAll = null;
        if($dataParts->sum('total_label') === $dataParts->sum('total_checked')){
            $checkedAll = true;

        }

        if($checkedLabel === false) {
            $userServices->handleResponse($this->user);
            return response()
                ->json([
                    'success' => false,
                    'type' => 'warning',
                    'message' => 'Label customer sudah dicheck!',
                ], 200);
        } else if($checkedLabel) {
            return response()
                ->json([
                    'success' => true,
                    'type' => 'success',
                    'message' => 'Label customer sesuai!',
                    'html' => view('partials.table-parts', compact('dataParts'))->render(),
                    'checkedAll' => $checkedAll
                ], 200);
        } else {
            $userServices->handleResponse($this->user);
            return response()
                ->json([
                    'success' => false,
                    'type' => 'error',
                    'message' => 'Member belum prepare!'
                ], 200);
        }
    }

    public function checkPartLoading(Request $request, UserSecurityServices $userServices) {
        $request->validate([
            'parts' => 'required'
        ]);

        $getData = DB::table('tbl_kbndelivery')
            ->where('kbndn_no', $request->input('parts'))
            ->first();
        // cek surat jalan di loading
        $checkSJ = TblKbndelivery::where('kbndn_no', $request->input('parts'))
            ->whereNot('check_sj', 0)
            ->first();
        if(is_null($getData) || is_null($checkSJ)) {
            Log::debug('checkPartLoading: tidak ada di database', [$getData]);
            Log::debug('checkPartLoading: belum check surat jalan', [$checkSJ]);
            $userServices->handleResponse($this->user);
            return response()
                ->json([
                    'success' => false,
                    'type' => 'error',
                    'message' => 'Label tidak sesuai! Belum check Surat Jalan'
                ], 200);
        }

        if($getData->check_loading === null) {
            DB::table('tbl_kbndelivery')
                ->where('kbndn_no', $request->input('parts'))
                ->update([
                    'check_loading' => 1,
                    'check_load_by' => Auth::user()->id_user
                ]);
            return response()
                ->json([
                    'success' => true,
                    'type' => 'success',
                    'message' => 'Label berhasil check loading!'
            ], 200);
        } else if($getData->check_loading === 1) {
            $userServices->handleResponse($this->user);
            return response()
                ->json([
                    'success' => false,
                    'type' => 'warning',
                    'message' => 'Label sudah dicheck!'
                ], 200);
        }

    }

    public function partLoading (Request $request) {
        $customer = strtolower(session('customer'));
        $cycle = session('cycle');
        $route = session('route');
        $date = $request->query('date');
        $checkedAll = false;

        $dataParts = $this->partsSuratJalan($customer, $route, $cycle, $date);
        if($dataParts->sum('total_checked') === $dataParts->sum('total_label')) {
            $checkedAll = true;
        };
        Log::debug('partLoading', [$dataParts]);
        return response()
            ->json([
                'success' => true,
                'type' => 'success',
                'html' => view('partials.parts-loading', compact('dataParts'))->render(),
                'checkedAll' => $checkedAll
        ], 200);
    }

}
