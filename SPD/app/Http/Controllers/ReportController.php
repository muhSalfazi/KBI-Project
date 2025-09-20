<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    // Menampilkan barang yang sudah close berdasarkan Qty dan jumlah record di tbl_packing
    public function getClosedBarang(Request $request)
    {
        // Periksa parameter filter
        $startDateEncrypted = $request->input('start_date');
        $endDateEncrypted = $request->input('end_date');
        $status = $request->input('status');
    
        // Validasi parameter tanggal
        if ((!$startDateEncrypted && $endDateEncrypted) || ($startDateEncrypted && !$endDateEncrypted)) {
            return redirect()->back()->with('error', 'Harap isi kedua filter: start date dan end date.');
        }
    
        // Dekripsi parameter tanggal jika ada
        try {
            $startDate = $startDateEncrypted ? decrypt($startDateEncrypted) : null;
            $endDate = $endDateEncrypted ? decrypt($endDateEncrypted) : null;
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan pada parameter tanggal.');
        }
    
        // Query data barang closed
        $closedBarang = Order::whereIn('id', function ($query) {
                $query->select('id_order')
                    ->from('tbl_packing')
                    ->groupBy('id_order')
                    ->havingRaw('COUNT(*) >= (SELECT Qty FROM tbl_orders WHERE tbl_orders.id = tbl_packing.id_order)');
            })
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('delivery_date', [$startDate, $endDate]);
            })
            ->when($status, function ($query) use ($status) {
                if ($status === 'Late Delivery') {
                    $query->whereColumn('delivery_date', '<', 'created_at'); // Late Delivery
                } elseif ($status === 'ontime') {
                    $query->whereColumn('delivery_date', '>=', 'created_at'); // On-Time Delivery
                }
            })
            ->get();
    
        return view('report.close', compact('closedBarang', 'startDate', 'endDate', 'status'));
    }
    
    
   public function getDelayedBarang(Request $request)
{
    // Periksa parameter filter tanggal
    $startDateEncrypted = $request->input('start_date');
    $endDateEncrypted = $request->input('end_date');

    // Validasi parameter tanggal
    if ((!$startDateEncrypted && $endDateEncrypted) || ($startDateEncrypted && !$endDateEncrypted)) {
        return redirect()->back()->with('error', 'Harap isi kedua filter: start date dan end date.');
    }

    // Dekripsi parameter tanggal
    try {
        $startDate = $startDateEncrypted ? decrypt($startDateEncrypted) : null;
        $endDate = $endDateEncrypted ? decrypt($endDateEncrypted) : null;
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan pada parameter tanggal.');
    }

    // Query data barang delayed
    $delayedBarang = Order::with(['customer'])
        ->select(
            'tbl_orders.*',
            DB::raw('(SELECT COUNT(*) FROM tbl_packing WHERE tbl_packing.id_order = tbl_orders.id) as qty_scanned'),
            DB::raw('(tbl_orders.Qty - (SELECT COUNT(*) FROM tbl_packing WHERE tbl_packing.id_order = tbl_orders.id)) as qty_unscanned')
        )
        ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
            $query->whereBetween('delivery_date', [$startDate, $endDate]);
        })
        ->whereRaw('(SELECT COUNT(*) FROM tbl_packing WHERE tbl_packing.id_order = tbl_orders.id) < tbl_orders.Qty') // Belum selesai diprepare
        ->where('delivery_date', '<', now()) // Sudah terlambat
        ->get();

    return view('report.delay', compact('delayedBarang', 'startDate', 'endDate'));
}


}