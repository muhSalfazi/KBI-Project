<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // method show get show data
    public function index()
    {
        // Ambil semua pengguna dengan role user, viewer, dan admin
        $users = User::whereIn('role', ['user', 'viewer','admin'])
                     ->orderBy('created_at', 'desc')
                     ->get();

        return view('User.index', compact('users'));
    }

    //method show create
    public function create()
    {
        return view('User.create');
    }
    // method post create user
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_card_number' => 'required|string|max:100|unique:users',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'username' => 'nullable|string|max:50',
            'role' => 'required|in:admin,user,viewer',
            'password' => 'nullable|string|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Gunakan password default jika kosong
        // $password = $request->filled('password') ? bcrypt($request->password) : bcrypt('default123');

         $hashedPassword = Hash::make($request->password);
        User::create([
            'id_card_number' => $request->id_card_number,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'role' => $request->role,
            'password' => $hashedPassword,
            'username' => $request->username,
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }


    // method post delete user
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }


    // UserController.php
public function editPassword(User $user)
{
    // Pastikan hanya role viewer yang bisa diakses
    if ($user->role !== 'viewer') {
        return redirect()->route('users.index')->with('error', 'Hanya pengguna dengan role viewer yang dapat mengubah password.');
    }

    return view('User.edit-password', compact('user'));
}

public function updatePassword(Request $request, User $user)
{
    // Validasi input
    $request->validate([
        'password' => 'required|string|min:8|confirmed',
    ]);

    // Update password
    $user->update([
        'password' => bcrypt($request->input('password')),
    ]);

    return redirect()->route('users.index')->with('success', 'Password berhasil diperbarui.');
}

}