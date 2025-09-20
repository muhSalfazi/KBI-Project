<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;


class LoginController extends Controller
{
    // login user
    public function LoginUser()
    {
        return view('login-user');
    }

    public function PostLoginUser(Request $request)
    {
        // Validasi input id card number
        $request->validate([
            'id_card_number' => 'required'
        ]);

        // Cari user berdasarkan id_card_number
        $user = User::where('id_card_number', $request->id_card_number)->first();

        if ($user) {
            // Set user login
            Auth::login($user);

            // Set session ID user
            session(['id_user' => $user->id]);

            // Update last login time
            DB::table('users')->where('id', $user->id)->update(['last_login' => now()]);

            // Auto Remember Me
            $token = Str::random(60); // Generate random token

            // Simpan token di database (jika tabel remember_tokens digunakan)
            DB::table('remember_tokens')->insert([
                'user_id' => $user->id,
                'token' => hash('sha256', $token),
                'created_at' => now(),
            ]);

            // Simpan token dalam cookie
            Cookie::queue('remember_token', $token, 20160); // 14 hari

            // Periksa apakah user memiliki role 'user'
            if ($user->hasRole('user')) {
                // Redirect ke halaman dashboard atau halaman sesuai role
                return redirect()->route('packing.form')->with('success', 'Selamat!!Anda berhasil Login.');
            } else {
                Auth::logout(); // Log out the user if they don't have the required role
                return redirect()->back()->with('auth_error', 'Anda tidak memiliki akses ke halaman ini.');
            }
        } else {
            return redirect()->back()->with('error', 'ID card number tidak ditemukan.');
        }
    }


    // login admin
    public function showLogin()
    {
        return view('login');
    }
    public function login(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'username' => 'required|min:3',
            'password' => 'required|min:5',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $remember = $request->has('remember');

        if (Auth::attempt($request->only('username', 'password'))) {
            $user = Auth::user();

            // Perbarui waktu login terakhir
            $user->update(['last_login' => now()]);

            if ($remember) {
                $token = Str::random(60);

                // Simpan token Remember Me di database
                DB::table('remember_tokens')->insert([
                    'user_id' => $user->id,
                    'token' => hash('sha256', $token),
                    'created_at' => now(),
                ]);

                // Simpan token dalam cookie
                Cookie::queue('remember_token', $token, 20160); // 14 hari
            }

            // Alihkan berdasarkan role
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('dashboard')->with('success', 'Selamat datang, Admin!');
                 case 'superAdmin':
                        return redirect()->route('dashboard')->with('success', 'Selamat datang, Super Admin!');
                case 'user':
                    return redirect()->route('user.packing.user')->with('success', 'Selamat datang di halaman User!');
                case 'viewer':
                    return redirect()->route('dashboard.viewer')->with('success', 'Selamat datang di Dashboard Viewer!');
                default:
                    Auth::logout();
                    return redirect()->route('login')->with('error', 'Role tidak dikenali. Silakan hubungi admin.');
            }
        }

        return redirect()->back()->with('error', 'Username atau password salah.')->withInput();
    }
    // end login admin

    public function logout(Request $request)
    {
        $rememberToken = $request->cookie('remember_token');

        if ($rememberToken) {
            $hashedToken = hash('sha256', $rememberToken);
            DB::table('remember_tokens')->where('token', $hashedToken)->delete();
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Cookie::queue(Cookie::forget('remember_token'));

        return redirect()->route('login-admin')->with('success', 'Berhasil logout.');
    }

}