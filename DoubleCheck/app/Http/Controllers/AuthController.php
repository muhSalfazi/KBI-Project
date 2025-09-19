<?php

namespace App\Http\Controllers;

use App\Models\TblUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }


    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'job' => 'required'
        ]);

        $job = $request->input('job');

        // cari user
        $user = TblUser::where('username', $request->username)->first();

        if ($user) {
            Auth::login($user);

            if($job === 'admin') {
                return redirect()->route('scanAdmin');
            } elseif ($job === 'check-prepare') {
                return redirect()->route('scanLeader');
            } elseif ($job === 'check-sj') {
                return redirect()->route('checkSuratJalan');
            } elseif ($job === 'check-loading') {
                return redirect()->route('checkSuratJalan');
            } else {
                return redirect('https://delivery.jajaleun.com/SCAN/pages/Login.php');
            }
        }

        return redirect()->back()->with('error', 'User tidak terdaftar!');
    }

    public function destroy(Request $request)
    {
        session()->forget(['customer','cycle']);
        Auth::logout();
        return redirect()->route('login');
    }

    public function endSessionCustomer(Request $request)
    {
        $this->forgetSession($request);
        return redirect()->back();
    }

    public function forgetSession(Request $request)
    {
        session()->forget(['customer', 'route', 'cycle']);
    }

    public function getSessionAktif(Request $request) {
        $sessionAktif = session('customer');

        if(isset($sessionAktif)) {
            return response()->json([
                'success' => true,
                'message' => 'Session aktif',
                'data' => [
                    'customer' => session('customer'),
                    'cycle' => session('cycle'),
                    'route' => session('route')
                ]
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Session tidak aktif',
            ], 200);
        }
    }
}
