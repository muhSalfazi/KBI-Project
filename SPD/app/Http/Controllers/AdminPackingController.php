<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Part;
use App\Models\Planning;
use App\Exports\DeliveriesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class AdminPackingController extends Controller
{
    public function index()
    {
        // Mengambil data Planning beserta Order dan Part yang terkait
        $plannings = Planning::with(['user', 'order', 'part'])->orderBy('created_at', 'desc')->get();
        return view('Packing.admin', compact('plannings'));
    }

    public function delivery(Request $request)
    {
        $startDateEncrypted = $request->input('start_date');
        $endDateEncrypted = $request->input('end_date');
        $status = $request->input('status'); // Ambil parameter status

        // Validasi: Tanggal filter harus berpasangan
        if ((!$startDateEncrypted && $endDateEncrypted) || ($startDateEncrypted && !$endDateEncrypted)) {
            return redirect()->back()->with('error', 'Harap isi kedua filter: start date dan end date.');
        }

        // Dekripsi tanggal jika ada
        try {
            $startDate = $startDateEncrypted ? decrypt($startDateEncrypted) : null;
            $endDate = $endDateEncrypted ? decrypt($endDateEncrypted) : null;
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan pada parameter tanggal.');
        }

        // Query dengan filter berdasarkan delivery_date
        $orders = Order::with('part', 'customer')
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('delivery_date', [$startDate, $endDate]);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Map data orders menjadi deliveries
        $deliveries = $orders->map(function ($order) {
            $qty = $order->Qty;
            $prepared = Planning::where('id_order', $order->id)->count();
            $outstanding = $qty - $prepared;

            $delivery_date = \Carbon\Carbon::parse($order->delivery_date);
            $now = \Carbon\Carbon::now();

            $daysOverdue = $now->greaterThan($delivery_date) ? $now->diffInDays($delivery_date) : 0;
            $isLate = $delivery_date->isPast();

            // Tentukan status
            $status = match (true) {
                $prepared == $qty && $isLate => "Late Delivery", // Tambahkan kondisi untuk Late Delivery
                $isLate && $prepared < $qty => "Delay",
                $prepared == 0 => "Belum Siap",
                $prepared < $qty => "Dalam Proses",
                $prepared == $qty => "Close",
                default => "N/A"
            };

            return (object) [
                'qty' => $qty,
                'prepared' => $prepared,
                'outstanding' => $outstanding,
                'overdue' => $isLate ? $daysOverdue : 0,
                'status' => $status,
                'part_name' => $order->part->P_Name ?? 'N/A',
                'part_number' => $order->part->P_No ?? 'N/A',
                'delivery_date' => $delivery_date->format('d M Y'),
                'customer_part_number' => $order->part->cust_part_no ?? 'N/A',
                'customer' => $order->customer->username ?? 'N/A',
                'PO' => $order->P_order ?? 'N/A',
            ];
        });

        // Filter hasil berdasarkan status
        if ($status) {
            $deliveries = $deliveries->filter(function ($delivery) use ($status) {
                return $delivery->status === $status;
            });
        }

        return view('Packing.delivery', compact('deliveries', 'startDate', 'endDate', 'status'));
    }


    public function exportDeliveries(Request $request)
    {
        $startDateEncrypted = $request->input('start_date');
        $endDateEncrypted = $request->input('end_date');
    
        // Validasi: Jika salah satu parameter kosong, kembalikan dengan pesan error
        if ((!$startDateEncrypted && $endDateEncrypted) || ($startDateEncrypted && !$endDateEncrypted)) {
            return redirect()->back()->with('error', 'Harap isi kedua filter: start date dan end date.');
        }
    
        // Dekripsi parameter jika keduanya ada
        try {
            $startDate = $startDateEncrypted ? decrypt($startDateEncrypted) : null;
            $endDate = $endDateEncrypted ? decrypt($endDateEncrypted) : null;
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan pada parameter tanggal.');
        }
    
        // Ambil data dengan relasi
        $orders = Order::with('part.customer')
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('delivery_date', [$startDate, $endDate]);
            })
            ->orderBy('created_at', 'desc')
            ->get();
    
        // Map data
        $deliveries = $orders->map(function ($order) {
            $qty = $order->Qty ?? 0;
            $prepared = Planning::where('id_order', $order->id)->count() ?? 0; // Jika null, default 0
            $deliveryDate = $order->delivery_date ? \Carbon\Carbon::parse($order->delivery_date) : null;
    
            // Hitung outstanding
            $outstanding = $qty - $prepared;
    
            // Hitung overdue jika tanggal ada
            $now = \Carbon\Carbon::now();
            $overdue = $deliveryDate && $now->greaterThan($deliveryDate)
                ? $now->diffInDays($deliveryDate)
                : 0;
    
            // Tentukan status
            $status = match (true) {
                $prepared == $qty && $deliveryDate && $now->greaterThan($deliveryDate) => "Late Delivery", // Close tetapi telat
                $deliveryDate && $now->greaterThan($deliveryDate) && $prepared < $qty => "Delay",
                !$deliveryDate || $prepared == 0 => "Belum Siap",
                $outstanding == 0 && $prepared == $qty => "Close",
                $prepared < $qty && $outstanding > 0 => "Dalam Proses",
                default => "N/A",
            };
    
            return [
                'PO' => $order->P_order ?? 'N/A',
                'Customer Part Number' => $order->part->cust_part_no ?? 'N/A',
                'Customer' => $order->customer->username ?? 'N/A',
                'Part Number' => $order->part->P_No ?? 'N/A',
                'Part Name' => $order->part->P_Name ?? 'N/A',
                'Qty' => $qty,
                'Prepared' => $prepared ?? 'N/A',
                'Outstanding' => $outstanding,
                'Delivery Date' => $deliveryDate ? $deliveryDate->format('d M Y') : 'N/A',
                'Overdue' => $overdue ?? 0,
                'Status' => $status,
            ];
        })->toArray();
    
        // Validasi jika data kosong
        if (empty($deliveries)) {
            return back()->with('error', 'Tidak ada data untuk diekspor.');
        }
    
        // Ekspor file Excel
        $file = Excel::download(new DeliveriesExport($deliveries), 'deliveries.xlsx')->getFile();
    
        return Response::make(file_get_contents($file), 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="deliveries.xlsx"',
        ]);
    }
    
}