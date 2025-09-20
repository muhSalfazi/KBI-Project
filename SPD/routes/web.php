<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PackingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminPackingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/keep-session-alive', function () {
    return response()->json(['status' => 'Session is alive'], 200);
})->middleware('auth')->name('keep.session.alive');



Route::get('/', [LoginController::class, 'loginUser'])->name('login')->middleware('guest');

Route::get('/admin', [LoginController::class, 'showLogin'])->name('login-admin')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->name('postlogin')->middleware('guest', 'throttle:5,1');

Route::post('/login/user', [LoginController::class, 'PostLoginUser'])->name('loginUser')->middleware('guest');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::fallback(function () {
    abort(404, 'Halaman yang Anda cari tidak ditemukan.');
});

// role ADMIN
Route::middleware(['auth', 'role:admin|superAdmin'])->group(function () {
    Route::post('/encrypt', function (Request $request) {
        // Hanya izinkan akses jika pengguna terautentikasi
        if (!auth()->check()) {

            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        return response()->json([
            'encrypted_start_date' => encrypt($request->input('start_date')),
            'encrypted_end_date' => encrypt($request->input('end_date')),
        ]);
    });
    // reportController
    Route::get('/report/closed', [ReportController::class, 'getClosedBarang'])->name('report.closed');
    Route::get('/report/delay', [ReportController::class, 'getDelayedBarang'])->name('report.delay');

    // logout
    Route::post('/logout/', [LoginController::class, 'logout'])->name('logout-admin');
    // dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // part
    Route::get('/parts/admin', [PartController::class, 'index'])->name('parts.index');
    Route::get('parts/{id}/edit', [PartController::class, 'updateshow'])->name('parts.edit');
    Route::get('/parts/create', [PartController::class, 'create'])->name('parts.create');
    Route::post('/parts/store', [PartController::class, 'store'])->name('parts.store');
    Route::put('/parts/{id}', [PartController::class, 'update'])->name('parts.update');
    Route::put('/parts/{id}/update-images', [PartController::class, 'updateImages'])->name('parts.updateImages');
    Route::delete('/parts/{id}', [PartController::class, 'destroy'])->name('parts.destroy');
    Route::post('/parts/import', [PartController::class, 'import'])->name('parts.import');
    Route::post('/parts/{id}/change-status', [PartController::class, 'changeStatus'])
        ->name('parts.changeStatus');

    // order
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::post('/orders/import', [OrderController::class, 'import'])->name('orders.import');
    Route::put('/orders/update-qty', [OrderController::class, 'updateQty'])->name('orders.update.qty');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::post('/orders/{id}/toggle-status', [OrderController::class, 'toggleStatus'])->name('orders.toggleStatus');
    //export excel
    Route::get('/export-deliveries', [AdminPackingController::class, 'exportDeliveries'])->name('export.deliveries');

    // packing
    Route::get('report/packing', [AdminPackingController::class, 'index'])->name('admin.packing');
    Route::get('report/delivery', [AdminPackingController::class, 'delivery'])->name('admin.delivery');
});

// role USER
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/packing', [PackingController::class, 'index'])->name('packing.form');
    Route::post('/packing/manage/{id_user}', [PackingController::class, 'manageInput'])->name('packing.manage');
    Route::get('/packing/po/{P_order}', [PackingController::class, 'showPo'])->name('packing.po');
    Route::get('/packing/index/{P_order}/{P_no_cus}', [PackingController::class, 'showIndex'])->name('packing.index');


    Route::post('/user/logout', [PackingController::class, 'autoLogout'])
        ->name('user.logout');
});

// role SUPERADMIN
Route::middleware(['auth', 'role:superAdmin'])->group(function () {
   // user
   Route::get('/users', [UserController::class, 'index'])->name('users.index');
   Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
   Route::post('/users', [UserController::class, 'store'])->name('users.store');
   Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
   Route::get('/users/{user}/edit-password', [UserController::class, 'editPassword'])->name('users.editPassword');
   Route::post('/users/{user}/update-password', [UserController::class, 'updatePassword'])->name('users.updatePassword');

});

// route VIEWER
Route::middleware(['auth', 'role:viewer'])->group(function () {

    Route::post('/view', function (Request $request) {
        // Hanya izinkan akses jika pengguna terautentikasi
        if (!auth()->check()) {

            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        return response()->json([
            'encrypted_start_date' => encrypt($request->input('start_date')),
            'encrypted_end_date' => encrypt($request->input('end_date')),
        ]);
    });
    Route::get('/dashboard/viewer', [DashboardController::class, 'index'])->name('dashboard.viewer');

    Route::get('/orders/viewer', [OrderController::class, 'index'])->name('orders.index.viewer');
    Route::get('/parts/viewer', [PartController::class, 'index'])->name('parts.index.viewer');

    // reportController
    Route::get('/report/closed/viewer', [ReportController::class, 'getClosedBarang'])->name('report.closed.viewer');
    Route::get('/report/delay/viewer', [ReportController::class, 'getDelayedBarang'])->name('report.delay.viewer');


    // logout
    Route::post('/logout/viewer', [LoginController::class, 'logout'])->name('logout-viewer');

    // packing
    Route::get('/view/packing', [AdminPackingController::class, 'index'])->name('viewer.packing');
    Route::get('/view/delivery', [AdminPackingController::class, 'delivery'])->name('viewer.delivery');


});