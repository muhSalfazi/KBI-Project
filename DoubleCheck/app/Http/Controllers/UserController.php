<?php

namespace App\Http\Controllers;

use App\Models\TblUser;
use Illuminate\Http\Request;
use App\Services\UserSecurityServices;

class UserController extends Controller
{
    public function userManagement(Request $request) {
        $search = $request->input('search');
        $data = TblUser::with('role');
        if($search) {
            $data = TblUser::search($search);
        }

        $data = $data->paginate(15);
        return view('pages.users',
        [
            'judul' => 'Manajemen User',
            'data' => $data
        ]);
    }

    public function unblockUser($id, UserSecurityServices $userServices) {
        $user = TblUser::findOrFail($id);
        $userServices->unBlock($user);

        return redirect()->back()->with('success', 'Berhasil membuka blokir user '. $user->full_name);
    }
}
