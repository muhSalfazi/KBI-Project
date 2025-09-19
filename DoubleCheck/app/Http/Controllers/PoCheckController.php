<?php

namespace App\Http\Controllers;

use App\Models\CheckSuratJalan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Database\Factories\CustomerFactory;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ScanWaitingPostController;
use Carbon\Carbon;
use App\Services\UserSecurityServices;

class PoCheckController extends BaseController
{
    private $user;

    public function __construct() {
        $this->user = auth()->user();
    }

    public function processScan(Request $request, UserSecurityServices $userServices) {
        $request->validate([
            'manifest' => 'required',
        ]);

        $manifest = request()->input('manifest');
        $process = 'check_po';
        $customer = strtolower(session('customer'));
        $cycle = session('cycle');

        $customer = CustomerFactory::createCustomerInstance($customer);
        $manifestParse = $customer->parseCustomerLabel($manifest);
        try {
            $result = $customer->getDataManifest($manifestParse, $process, $cycle);
            if ($result === true) {
                return response()
                    ->json([
                        'success' => false,
                        'type'    => 'warning',
                        'message' => 'Manifest sudah di check!'
                    ], 200);
            } elseif ($result) {
                Log::info('Data manifest sesuai');
                return response()
                    ->json([
                        'success' => true,
                        'type'    => 'success',
                        'message' => 'Data manifest sesuai!',
                    ], 200);
                } else {
                $userServices->handleResponse($this->user);
                return response()
                    ->json([
                        'success' => false,
                        'type'    => 'error',
                        'message' => 'Data manifest tidak sesuai!'
                    ], 200);
            }
        } catch (\Throwable $e) {
            Log::error('Error: '.$e->getMessage());
            return response()
                ->json([
                    'success' => false,
                    'type'    => 'error',
                    'message' => 'Terjadi kesalahan di server: ' . $e->getMessage(),
                ], 500);
        }

    }

    public function checkManifestSJ(Request $request, UserSecurityServices $userServices) {
        $request->validate([
            'manifest' => 'required',
            'date' => 'required'
        ]);

        $manifest = request()->input('manifest');
        $customer = strtolower(session('customer'));
        $cycle = session('cycle');
        $date = Carbon::parse($request->input('date'))->format('d-m-Y');

        $customer = CustomerFactory::createCustomerInstance($customer);
        $manifestParse = $customer->parseCustomerLabel($manifest);

        // proses input check apakah manifest ada atau tidak di tabel
        $result = $customer->checkManifestCustomerSJ($cycle, $manifestParse, $date);

        if($result->isNotEmpty()) {
            // check all post
            $checkedAll = $customer->checkAllPostSJ($result, $manifestParse);
            if($checkedAll === true) {
                return response()
                ->json([
                    'success' => true,
                    'type'    => 'success',
                    'message' => 'Manifest berhasil check SURAT JALAN'
                ], 200);
            } else if($checkedAll === false) {
                return response()
                    ->json([
                        'success' => true, //true supaya bisa lanjut tampil table
                        'type'    => 'warning',
                        'message' => 'Manifest sudah dicek'
                    ], 200);
            } else if($checkedAll === null) {
                $userServices->handleResponse($this->user);
                return response()
                ->json([
                    'success' => false,
                    'type'    => 'error',
                    'message' => 'Manifest belum check semua post!'
                ], 200);
            }

        } else {
            return response()
                ->json([
                    'success' => false,
                    'type'    => 'error',
                    'message' => 'Manifest tidak ada di tabel!'
                ], 200);
        }
    }

    public function checkLoading(Request $request, UserSecurityServices $userServices) {
        $request->validate([
            'manifest' => 'required',
        ]);
        $manifest = request()->input('manifest');
        $customer = strtolower(session('customer'));
        $cycle = session('cycle');

        $customer = CustomerFactory::createCustomerInstance($customer);
        $manifestParse = $customer->parseCustomerLabel($manifest);
        // check scan surat jalan
        $scanSJ = CheckSuratJalan::where('dn_no', $manifestParse)->first();

        if(is_null($scanSJ)) {
            return response()->json([
                'success' => false,
                'type'    => 'error',
                'message' => 'Belum Scan Surat Jalan!'
            ], 200);
        }

        $result = $customer->checkManifestLoading($manifestParse, $cycle);

        if($result) {
            return response()
                ->json([
                    'success' => true,
                    'type'    => 'success',
                    'message' => 'Data loading berhasil scan!',
                ], 200);
        } else if($result === false) {
            return response()
                ->json([
                    'success' => false,
                    'type'    => 'warning',
                    'message' => 'Manifest sudah dicek',
                ], 200);
        }
        else if ($result === null) {
            return response()
                ->json([
                    'success' => false,
                    'type'    => 'error',
                    'message' => 'Data loading tidak sesuai!'
                ], 200);
        }
    }
}
