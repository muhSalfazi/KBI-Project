<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Planning;
use Carbon\Carbon;

class OrderControllerApi extends Controller
{
    //
    public function __construct()
    {
        // Middleware untuk memastikan pengguna sudah login dengan token
        $this->middleware('auth:sanctum');
    }

    /**
     * Menampilkan semua data Order
     */
    public function index()
    {
        $orders = Order::leftJoin('tbl_parts', 'tbl_parts.id', '=', 'tbl_orders.id_part')
            ->leftJoin('tbl_customer', 'tbl_orders.customer_id', '=', 'tbl_customer.id')
            ->select('tbl_orders.*', 'tbl_customer.name as Customer', 'tbl_parts.P_Name as PartName', 'tbl_parts.P_No as PartNumber')
            ->orderBy('tbl_orders.created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $orders,
        ]);
    }
}
