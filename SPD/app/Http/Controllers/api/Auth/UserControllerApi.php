<?php

namespace App\Http\Controllers\api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserControllerApi extends Controller
{
    //
    public function __construct()
    {
        // Middleware untuk memastikan pengguna terautentikasi
        $this->middleware('auth:sanctum');
    }

    /**
     * Tampilkan semua user dengan role "user"
     */
    public function index()
    {
        $users = User::where('role', 'user')->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $users,
        ]);
    }

    /**
     * Simpan user baru
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_card_number' => 'required|string|max:255|unique:users',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::create([
            'id_card_number' => $request->id_card_number,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'role' => 'user', // Default role adalah "user"
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User created successfully.',
            'data' => $user,
        ]);
    }

    /**
     * Hapus user berdasarkan ID
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.',
            ], 404);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully.',
        ]);
    }
}
