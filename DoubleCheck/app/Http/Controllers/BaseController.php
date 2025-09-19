<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Database\Factories\CustomerFactory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

abstract class BaseController extends Controller
{
    /**
     * Mendapatkan data manifest berdasarkan siklus
     *
     * @param string $customerType Jenis customer (cust1, cust2, dst)
     * @param string $cycle Siklus yang dipilih
     * @return \Illuminate\Support\Collection
     */

    // ambil manifest dgn status
    public function dataIndex($date = null)
        {
            // ambil data manifest untuk tabel
            $customer = strtolower(session('customer'));
            $cycle = session('cycle');
            $route = session('route');

            $manifestCustomer = CustomerFactory::createCustomerInstance($customer);
            $dataManifest =$manifestCustomer->checkManifestCustomer($cycle, $route); //bentuk collection (hrs loop)

            if ($date) {
                $dataManifest = $dataManifest->filter(function ($item) use ($date) {
                    return Carbon::parse($item->tanggal_order)->toDateString() === $date;
                });
            }

            $manifests = $manifestCustomer->getAllWithStatus($dataManifest); //ada status dari tb_log

            return $manifests;
        }
}
