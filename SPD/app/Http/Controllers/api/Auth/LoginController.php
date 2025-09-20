<?php

namespace App\Http\Controllers\api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class LoginController extends Controller
{
    /**
     * API: User Login
     */
    public function loginUser(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'id_card_number' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Cari user berdasarkan ID card number
        $user = User::where('id_card_number', $request->id_card_number)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.',
            ], 404);
        }

        // Cek token aktif dari database
        $activeToken = $this->checkActiveToken($user);

        if ($activeToken) {
            // Perbarui last_used_at jika token masih valid
            $activeToken->update(['last_used_at' => Carbon::now()]);

            return response()->json([
                'success' => true,
                'message' => 'Token is still valid.',
                'token' => $activeToken->plainTextToken,
                'expires_at' => Carbon::parse($activeToken->expires_at)->format('d-m-Y H:i:s'), // Format dari database
            ], 200);
        }

        // Jika token tidak valid atau tidak ada, buat token baru
        $tokenName = $user->first_name . ' ' . $user->last_name;
        $token = $user->createToken($tokenName, ['*'])->plainTextToken;

        // Simpan expires_at di tabel tokens
        $user->tokens()->where('name', $tokenName)->update([
            'last_used_at' => Carbon::now(),
            'expires_at' => Carbon::now()->addHour(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Login successful.',
            'token' => $token,
            'expires_at' => Carbon::now()->addHour()->format('d-m-Y H:i:s'),
            'user' => $user,
        ], 200);
    }

    /**
     * API: Admin Login
     */
    public function loginAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|min:3',
            'password' => 'required|min:5',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        if (!Auth::attempt($request->only('username', 'password'))) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials.',
            ], 401);
        }

        $user = Auth::user();

        if (!$user->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied. Admin role required.',
            ], 403);
        }

        // Cek token aktif dari database
        $activeToken = $this->checkActiveToken($user);

        if ($activeToken) {
            // Perbarui last_used_at jika token masih valid
            $activeToken->update(['last_used_at' => Carbon::now()]);

            return response()->json([
                'success' => true,
                'message' => 'Token is still valid.',
                'token' => $activeToken->plainTextToken,
                'expires_at' => Carbon::parse($activeToken->expires_at)->format('d-m-Y H:i:s'), // Format dari database
            ], 200);
        }

        // Jika token tidak valid atau tidak ada, buat token baru
        $tokenName = $user->first_name . ' ' . $user->last_name;
        $token = $user->createToken($tokenName, ['*'])->plainTextToken;

        // Simpan expires_at di tabel tokens
        $user->tokens()->where('name', $tokenName)->update([
            'last_used_at' => Carbon::now(),
            'expires_at' => Carbon::now()->addHour(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Admin login successful.',
            'token' => $token,
            'expires_at' => Carbon::now()->addHour()->format('d-m-Y H:i:s'),
            'user' => $user,
        ], 200);
    }


    /**
     * API: Logout
     */
    public function logout(Request $request)
    {
        try {
            $user = $request->user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid or missing token. Please login again.',
                ], 401);
            }

            // Hapus semua token user
            $user->tokens()->delete();

            return response()->json([
                'success' => true,
                'message' => 'Logout successful.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    private function checkActiveToken($user)
    {
        return $user->tokens()
            ->where('expires_at', '>', Carbon::now()) // Token belum expired
            ->first();
    }

}
