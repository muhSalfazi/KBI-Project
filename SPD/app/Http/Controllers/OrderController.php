<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Part;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\OrdersImport;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $startDateEncrypted = $request->input('start_date');
        $endDateEncrypted = $request->input('end_date');
        $status = $request->input('status');
    
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
    
        // Query data dengan filter status
        $orders = Order::withTrashed()
            ->leftJoin('tbl_parts', 'tbl_parts.id', '=', 'tbl_orders.id_part')
            ->leftJoin('tbl_customer', 'tbl_orders.customer_id', '=', 'tbl_customer.id')
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('tbl_orders.delivery_date', [$startDate, $endDate]);
            })
            ->when($status, function ($query) use ($status) {
                if ($status === 'canceled') {
                    $query->whereNotNull('tbl_orders.deleted_at');
                } elseif ($status === 'open') {
                    $query->whereNull('tbl_orders.deleted_at');
                }
            })
            ->select('tbl_orders.*', 'tbl_customer.name as Customer')
            ->get();
    
        return view('Order.index', compact('orders', 'startDate', 'endDate', 'status'));
    }
    

    public function create()
    {
        $parts = Part::whereNotNull('P_No')->where('status', 1)->get();
        return view('Order.created', compact('parts'));
    }

    public function store(Request $request)
{
    $validatedData = $request->validate([
        'id_part' => 'required|exists:tbl_parts,id',
        'P_order' => 'required|numeric',
        'Qty' => 'required|numeric|min:1',
        'ETA_WH_NEW' => 'required|date',
        'catatan' => 'nullable|string|max:20',
        'customer_id' => 'required|exists:tbl_customer,id',
    ]);

    // Ambil data part
    $part = Part::with(['innerPart', 'outerPart'])->findOrFail($request->id_part);

    // Cek apakah kombinasi P_order dan P_no_cus sudah ada
    $existingOrder = Order::where('P_order', $request->P_order)
        ->where('P_no_cus', $part->cust_part_no)
        ->first();

    if ($existingOrder) {
        return redirect()->back()->withInput()->with('error', 'Order dengan kombinasi PO dan Part Number Customer ini sudah ada.');
    }

    // Ambil ID inner dan outer part dari relasi
    $innerPartId = $part->innerPart ? $part->innerPart->id : null;
    $outerPartId = $part->outerPart ? $part->outerPart->id : null;

    try {
        // Simpan data order
        Order::create([
            'id_part' => $part->id,
            'id_inner_part' => $innerPartId,
            'id_outer_part' => $outerPartId,
            'P_order' => $request->P_order,
            'P_no_cus' => $part->cust_part_no,
            'Qty' => $request->Qty,
            'delivery_date' => $request->ETA_WH_NEW,
            'customer_id' => $request->customer_id,
            'catatan' => $request->catatan ?? 'tidak ada',
            'status' => 'open',
        ]);

        return redirect()->route('orders.index')->with('success', 'Order berhasil dibuat!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Gagal menyimpan order: ' . $e->getMessage());
    }
}

public function updateQty(Request $request)
{
    $request->validate([
        'order_id' => 'required|exists:tbl_orders,id',
        'qty' => 'sometimes|integer|min:1',
        'eta_wh_new' => 'nullable|date',
        'catatan' => 'nullable|string|max:20',
    ]);

    // Ambil data order, termasuk yang soft deleted
    $order = Order::withTrashed()->find($request->order_id);

    // Jika order tidak ditemukan atau sudah dibatalkan/soft delete
    if (!$order || $order->status === 'canceled' || $order->trashed()) {
        return redirect()->back()->with('error', 'Order tidak dapat diperbarui karena telah dibatalkan. Silakan aktifkan kembali status order untuk melakukan pembaruan.');
    }

    // Lanjutkan jika valid
    if ($request->filled('qty')) {
        $order->Qty = $request->qty;
    }

    if ($request->filled('eta_wh_new')) {
        $order->delivery_date = $request->eta_wh_new;
    }

    if ($request->filled('catatan')) {
        $order->catatan = $request->catatan;
    }

    $order->save();

    return redirect()->back()->with('success', 'Quantity, Delivery Date, atau Catatan Berhasil diperbarui.');
}
    // public function destroy($id)
    // {
    //     $order = Order::find($id);

    //     if (!$order) {
    //         return redirect()->route('orders.index')->with('error', 'Order tidak ditemukan!');
    //     }

    //     $order->delete();

    //     return redirect()->route('orders.index')->with('success', 'Order berhasil dihapus!');
    // }

    public function import(Request $request)
    {
        // Validasi file input
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048', // Maksimal ukuran file 2MB
        ]);

        try {
            // Inisialisasi OrdersImport
            $import = new OrdersImport;

            // Lakukan impor file
            Excel::import($import, $request->file('file'));

            // Ambil data error dan berhasil
            $errorRows = $import->getErrorRows();
            $successfulRows = $import->getSuccessfulRows();

            // Siapkan pesan untuk ditampilkan
            $messages = [];

            if (!empty($successfulRows)) {
                $messages[] = count($successfulRows) . ' orders berhasil diimpor.';
            }

            if (!empty($errorRows)) {
                $messages[] = count($errorRows) . ' orders gagal diimpor karena duplikat, part tidak aktif, atau data tidak valid.';
            }

            // Redirect dengan pesan
            if (!empty($messages)) {
                return redirect()->route('orders.index')->with('success', implode(' | ', $messages));
            } else {
                return redirect()->route('orders.index')->with('error', 'Tidak ada data yang berhasil diimpor.');
            }
        } catch (\Exception $e) {
            // Log error jika terjadi kegagalan fatal
            Log::error('Gagal mengimpor file orders: ' . $e->getMessage());

            return redirect()->route('orders.index')->with('error', 'Terjadi kesalahan saat mengimpor file. Silakan coba lagi.');
        }
    }

    public function toggleStatus($id)
{
    $order = Order::withTrashed()->find($id);

    if (!$order) {
        return redirect()->route('orders.index')->with('error', 'Order tidak ditemukan!');
    }

    if ($order->trashed()) {
        // Aktifkan kembali order
        $order->restore();
        $order->status = 'open'; // Atur status menjadi open
    } else {
        // Cancel order
        $order->status = 'canceled';
        $order->delete(); // Masukkan ke soft delete
    }

    $order->save();

    $message = $order->trashed()
        ? 'Order berhasil dibatalkan.'
        : 'Order berhasil diaktifkan kembali.';

    return redirect()->route('orders.index')->with('success', $message);
}


}