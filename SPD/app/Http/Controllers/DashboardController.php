<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);

        // Total this month Delivery (Closed Orders)
        $deliveryThisMonth = Order::whereIn('id', function ($query) {
            $query->select('id_order')
                ->from('tbl_packing')
                ->groupBy('id_order')
                ->havingRaw('COUNT(*) = (SELECT Qty FROM tbl_orders WHERE tbl_orders.id = tbl_packing.id_order)');
        })
            ->whereMonth('delivery_date', $month)
            ->whereYear('delivery_date', $year)
            // ->where('delivery_date', '>=', Carbon::now()) // Pastikan tidak overdue
            ->count();

        // Total this month Overdue
        $overdueThisMonth = Order::where(function ($query) {
            $query->whereIn('id', function ($subquery) {
                $subquery->select('id_order')
                    ->from('tbl_packing')
                    ->groupBy('id_order')
                    ->havingRaw('COUNT(*) < (SELECT Qty FROM tbl_orders WHERE tbl_orders.id = tbl_packing.id_order)');
            })
                ->orWhereNotIn('id', function ($subquery) {
                    $subquery->select('id_order')->from('tbl_packing');
                }); // Ambil order yang belum memiliki packing sama sekali
        })
            ->whereMonth('delivery_date', $month)
            ->whereYear('delivery_date', $year)
            ->where('delivery_date', '<', Carbon::now()) // Pastikan overdue
            ->count();

        // Data untuk bar chart berdasarkan filter bulan dan tahun
        $data = DB::table('tbl_customer')
            ->leftJoin('tbl_orders', function ($join) use ($month, $year) {
                $join->on('tbl_customer.id', '=', 'tbl_orders.customer_id') // Perbaiki relasi
                    ->whereMonth('tbl_orders.delivery_date', $month)
                    ->whereYear('tbl_orders.delivery_date', $year);
            })
            ->select(
                'tbl_customer.name as customer', // Ganti username dengan name
                DB::raw('COUNT(DISTINCT CONCAT(tbl_orders.P_order, "-", tbl_orders.P_no_cus)) as total_order'),
                DB::raw('SUM(CASE
                    WHEN tbl_orders.Qty = (SELECT COUNT(*) FROM tbl_packing WHERE tbl_packing.id_order = tbl_orders.id)
                    THEN 1 ELSE 0 END) as total_closed'),
                DB::raw('SUM(CASE
                    WHEN tbl_orders.delivery_date < NOW()
                    AND (
                        tbl_orders.Qty > (SELECT COUNT(*) FROM tbl_packing WHERE tbl_packing.id_order = tbl_orders.id)
                        OR NOT EXISTS (SELECT 1 FROM tbl_packing WHERE tbl_packing.id_order = tbl_orders.id)
                    )
                    THEN 1 ELSE 0 END) as total_delay')
            )
            ->groupBy('tbl_customer.name') // Ganti username dengan name
            ->get();

        return view('Dashboard', [
            'deliveryThisMonth' => $deliveryThisMonth,
            'overdueThisMonth' => $overdueThisMonth,
            'data' => $data,
            'month' => $month,
            'year' => $year,
        ]);
    }
}