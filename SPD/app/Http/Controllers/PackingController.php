<?php

namespace App\Http\Controllers;

use App\Models\Planning;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class PackingController extends Controller
{
    public function index()
    {
        if (session('packing_user_id') && session('packing_user_id') !== Auth::id()) {
            return $this->autoLogout(request());
        }

        $token = Str::random(5);
        session(['packing_access_token' => $token, 'packing_user_id' => Auth::id()]);

        $user = Auth::user();
        return view('Packing.form', compact('user'));
    }

    public function manageInput(Request $request, $id_user)
    {
        // Validasi input
        $request->validate(['part_number' => 'required|string']);

        // Jika input adalah ID Card
        $user = User::where('id_card_number', $request->part_number)->first();
        if ($user) {
            return $this->handleIdCardScan($request, $id_user);
        }

        // Jika input adalah P_order
        $order = Order::where('P_order', $request->part_number)->first();
        if ($order) {
            session(['P_order' => $order->P_order]);
            session()->forget(['customer_part_no']);
            return redirect()->route('packing.po', $order->P_order)
                ->with('success', 'PO valid. Data ditampilkan.');
        }

        // Jika input adalah P_no_cus
        $customerPartNo = Order::where('P_no_cus', $request->part_number)->first();
        if ($customerPartNo) {
            return $this->processCustomerPartNo($request, $id_user);
        }

        // Jika input tidak cocok dengan ID Card, P_order, atau P_no_cus
        session()->forget('notfound');
        return redirect()->back()->with('notfound', 'Order tidak ditemukan atau telah dibatalkan. Hubungi admin.');
    }

    protected function processCustomerPartNo(Request $request, $id_user)
    {
        // Periksa apakah P_order ada di sesi
        $P_order = session('P_order');
        if (!$P_order) {
            session()->forget('notfound');
            return redirect()->route('packing.form')->with('notfound', 'Silakan masukkan PO terlebih dahulu.');
        }
    
        // Cari order berdasarkan P_order dan part_number
        $order = Order::where('P_order', $P_order)
            ->where('P_no_cus', $request->part_number)
            ->first();
    
        if (!$order) {
            session()->forget('notfound');
            return redirect()->back()->with('notfound', 'Customer Part No tidak valid.');
        }
    
        // Periksa apakah sesi customer_part_no ada dan cocok dengan input
        $sessionPartNo = session('customer_part_no');
        if ($sessionPartNo && $sessionPartNo !== $order->P_no_cus) {
            return redirect()->route('packing.index', [$order->P_order, $sessionPartNo])
                ->with('bedacust', 'Customer Part No berbeda. Tidak dapat diproses.');
        }
    
        // Jika sesi belum ada, set customer_part_no ke sesi
        if (!$sessionPartNo) {
            session(['customer_part_no' => $order->P_no_cus]);
            return redirect()->route('packing.index', [$order->P_order, $order->P_no_cus])
                ->with('success', 'Detail ditemukan. Silakan scan lagi untuk membuat Prepare.');
        }
    
        // Hitung total qty yang sudah diprepare untuk id_order ini
        $qtyPrepared = Planning::where('id_order', $order->id)->count();
    
        // Jika total qty sudah sama dengan order qty, dianggap selesai
        if ($qtyPrepared >= $order->Qty) {
            session()->forget(['sudahall']);
            return redirect()->route('packing.index', [$order->P_order, $order->P_no_cus])
                ->with('sudahall', 'Semua order telah selesai diprepare. Silakan scan kembali.');
        }
    
        // Jika belum selesai, tambahkan ke tbl_packing
        Planning::create(['id_user' => $id_user, 'id_order' => $order->id]);
    
        // Tambahkan qtyPrepared untuk sesi saat ini
        $qtyPrepared += 1;
        $outstanding = $order->Qty - $qtyPrepared;
    
        session()->forget(['berhasil']);
        return redirect()->route('packing.index', [$order->P_order, $order->P_no_cus])
            ->with('berhasil', 'Berhasil dibuat. Outstanding: ' . $outstanding . ' pcs.');
    }
    


    public function showPo($P_order)
    {
        $orders = Order::where('P_order', $P_order)
        ->with('part.customer')
        ->get()
        ->map(function ($order) {
            // Hitung jumlah yang sudah diprepare
            $order->prepared_qty = Planning::where('id_order', $order->id)->count();
            return $order;
        });
        
        if ($orders->isEmpty()) {
            session()->forget('notfound');
            return redirect()->route('packing.form')->with('notfound', 'PO tidak ditemukan.');
        }
        $user = Auth::user();
        return view('Packing.po', compact('orders', 'user'));
    }

    public function showIndex($P_order, $P_no_cus)
    {
        $order = Order::with(['innerPart', 'outerPart', 'part.customer'])->where('P_order', $P_order)->where('P_no_cus', $P_no_cus)->first();

        if (!$order) {
            session()->forget('notfound');
            return redirect()->route('packing.form')->with('notfound', 'Data tidak ditemukan.');
        }

        $orderDetails = [
            'order' => $order,
            'qtyPrepared' => Planning::where('id_order', $order->id)->count(),
        ];
        $user = Auth::user();
        return view('Packing.index', compact('orderDetails', 'user'));
    }

    protected function handleIdCardScan(Request $request, $id_user)
    {
        $user = User::where('id_card_number', $request->part_number)->first();
    
        if (!$user) {
            return redirect()->route('packing.form')->with('gagal', 'ID Card tidak ditemukan.');
        }
    
        // Hapus token Remember Me jika ada
        $rememberToken = $request->cookie('remember_token');
    
        if ($rememberToken) {
            $hashedToken = hash('sha256', $rememberToken);
            DB::table('remember_tokens')->where('token', $hashedToken)->delete();
        }
    
        // Logout pengguna
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        // Hapus cookie Remember Me
        Cookie::queue(Cookie::forget('remember_token'));
    
        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }
    
}