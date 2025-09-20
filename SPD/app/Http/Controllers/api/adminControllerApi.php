<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Planning;
use Carbon\Carbon;

class adminControllerApi extends Controller
{
    public function __construct()
    {
        // Middleware untuk memastikan token valid
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        $plannings = Planning::with(['user', 'order', 'part'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $plannings,
        ]);
    }

    public function delivery(Request $request)
    {
        // Ambil semua data order tanpa filter tanggal
        $orders = Order::with('part', 'customer')
            ->orderBy('created_at', 'desc')
            ->get();
    
        // Map data orders ke dalam format yang sesuai dengan nomor urut
        $deliveries = $orders->map(function ($order, $index) {
            $qty = $order->Qty ?? 0;
            $prepared = Planning::where('id_order', $order->id)->count() ?? 0;
            $outstanding = $qty - $prepared;
    
            $delivery_date = $order->delivery_date ? Carbon::parse($order->delivery_date) : null;
            $now = Carbon::now();
    
            $status = match (true) {
                $delivery_date && $now->greaterThan($delivery_date) && $prepared < $qty => "Terlambat",
                $prepared == 0 => "Belum Siap",
                $prepared < $qty => "Dalam Proses",
                $prepared == $qty => "Siap untuk Delivery",
                default => "N/A"
            };
    
            return [
                'order_number' => 'Order ' . ($index + 1), // Tambahkan penanda urutan
                'qty' => $qty,
                'prepared' => $prepared,
                'outstanding' => $outstanding,
                'status' => $status,
                'part_name' => $order->part->P_Name ?? 'N/A',
                'part_number' => $order->part->P_No ?? 'N/A',
                'delivery_date' => $delivery_date ? $delivery_date->format('d-m-Y') : 'N/A',
                'customer_part_number' => $order->part->cust_part_no ?? 'N/A',
                'customer' => $order->customer->username ?? 'N/A',
                'PO' => $order->P_order ?? 'N/A',
            ];
        });
    
        return response()->json([
            'success' => true,
            'data' => $deliveries,
        ]);
    }
    
}
