<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PartController;
use App\Http\Controllers\StoController;
use App\Http\Controllers\DailyStockLogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ForecastController;
use App\Http\Controllers\DailyReportController;
use App\Http\Controllers\WorkDaysController;
use App\Http\Controllers\UserLogicController;
use App\Http\Controllers\BomController;
use App\Http\Controllers\PublicDashboardController;
use App\Models\ImportLog;

/*
|--------------------------------------------------------------------------
| Routes
|--------------------------------------------------------------------------
*/
// routes/web.php
Route::get('/import/progress/{id}', function ($id) {
    return response()->json(ImportLog::find($id));
});

Route::prefix('/')->controller(AuthController::class)->group(function () {
    Route::get('/', 'showAdmin')->name('admin.login');
    Route::get('/user/login', 'showUser')->name('user.login');
    Route::post('/admin/login', 'login')->name('admin.login.post');
    Route::post('/user/login', 'userLogin')->name('user.login.post');
    Route::post('/admin/logout', 'logout')->name('logout');
    Route::post('/user/logout', 'logoutUser')->name('logout.user');
});

// Public Dashboard Routes (No Authentication Required)
Route::get('/index', [PublicDashboardController::class, 'publicDashboard'])->name('public.dashboard');

Route::middleware(['auth','admin.only'])->group(function () {

    // dashboard
    Route::prefix('dashboard')->controller(DashboardController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard');
        Route::get('/sto-chart-data', 'getStoChartData');
        Route::get('/daily-stock-classification', 'getDailyStockClassification');
        Route::get('/get-categories', 'getCategories');
    });

    // bom
    Route::prefix('bom')->controller(BomController::class)->group(function () {
        Route::get('/', 'index')->name('bom.index');
        Route::post('/import', 'import')->name('bom.import');
        Route::get('/export', 'export')->name('bom.export');
        Route::delete('/delete', 'deleteMultiple')->name('bom.delete-multiple');
    });

    // work days
    Route::prefix('workdays')->controller(WorkDaysController::class)->group(function () {
        Route::get('/', 'index')->name('workdays.index');
        Route::get('{id}/edit', 'edit')->name('workdays.edit');
        Route::put('/{id}', 'update')->name('workdays.update');
        Route::post('/import', 'import')->name('workdays.import');
    });
    // forecast
    Route::prefix('forecast')->controller(ForecastController::class)->group(function () {
        Route::get('/', 'index')->name('forecast.index');
        Route::post('/generate', 'generate')->name('forecast.generate');
        Route::get('/create', 'create')->name('forecast.create');
        Route::post('/store', 'store')->name('forecast.store');
        Route::delete('/delete', 'deleteforecast')->name('forecast.destroy');
        Route::post('/import', 'import')->name('forecast.import');
        Route::get('/export', 'export')->name('forecast.export');
    });


    // user management
    Route::prefix('manangement')->controller(UserLogicController::class)->group(function () {
        Route::get('/', 'index')->name('users.index');
        Route::get('/create', 'create')->name('users.create');
        Route::post('/store', 'store')->name('users.store');
        Route::get('/{id}/edit', 'edit')->name('users.edit');
        Route::put('/{id}/update', 'update')->name('users.update');
        Route::delete('/delete/{id}', 'destroy')->name('users.destroy');
    });

    // part
    Route::prefix('parts')->controller(PartController::class)->group(function () {
        Route::get('/', 'indexAll')->name('parts.index');
        Route::get('/customer', 'indexCustomer')->name('parts.index.customer');
        Route::get('/supplier', 'indexSupplier')->name('parts.index.supplier');
        Route::post('/', 'store')->name('parts.store');
        Route::get('/{part}/edit', 'edit')->name('parts.edit');
        Route::put('/{part}', 'update')->name('parts.update');
        Route::post('/import', 'import')->name('parts.import');
        Route::get('/export', 'export')->name('part.export');
        Route::delete('/delete', 'deleteMultiple')->name('part.delete-multiple');
        Route::get('get-areas/{plantId}', 'getAreas')->name('parts.get-areas');
        Route::get('/all', 'indexAll')->name('parts.all');
    });

    // sto
    Route::prefix('sto')->controller(StoController::class)->group(function () {
        Route::get('/', 'index')->name('sto.index');
        Route::get('/create', 'create')->name('sto.create.get');
        Route::post('/store', 'store')->name('sto.store.admin');
        Route::post('/import', 'import')->name('sto.import');
        Route::get('/export', 'export')->name('sto.export');
        Route::get('/export/history', 'exportHistory')->name('esxportHistory');
        Route::delete('/destroy/', 'deleteSto')->name('sto.destroy');
    });

    // daily stock log
    Route::prefix('daily-stock')->controller(DailyStockLogController::class)->group(function () {
        Route::get('/', 'index')->name('daily-stock.index');
        Route::delete('/delete', 'deletedailystock')->name('reports.destroy');
        Route::get('/export', 'export')->name('daily-stock.export');
        Route::post('/import', 'import')->name('daily-stock.import');
        Route::post('/process', [DailyStockLogController::class, 'processImport'])->name('daily-stock.process');
        Route::get('cancel-import', [DailyStockLogController::class, 'cancelImport'])->name('daily-stock.cancel-import');
    });
});


Route::middleware(['auth', 'user.only'])->group(function () {

    Route::prefix('dailyReport')->controller(DailyReportController::class)->group(function () {
        Route::get('/', 'index')->name('dailyreport.index');
        Route::post('/scan', 'scan')->name('sto.scan');
        Route::get('/search', 'search')->name('sto.search');
        Route::get('/print/{id}', 'printReport')->name('reports.print');
        Route::post('/{inventory}', 'storecreate')->name('sto.store');
        Route::get('/edit/{inventory_id}', 'form')->name('sto.edit.report');
        Route::put('/update-log/{id}', 'updateLog')->name('sto.updateLog');
        // Print content
        Route::get('/print-content/{id}', 'getPrintData')->name('reports.print-content');
        Route::get('/clear-session', 'clearReportSession')->name('report.clear-session');
    });

    Route::get('/sto/edit-log/{id}', [DailyReportController::class, 'editLog'])->name('sto.edit.log');
    // Tambahkan route untuk sinkronisasi data offline
    Route::post('/api/offline-data', [DailyReportController::class, 'processOfflineData'])
        ->name('reports.sync-offline-data');

    // Endpoint untuk sinkronisasi data offline
    Route::post('/api/sync-offline-data', [DailyReportController::class, 'syncOfflineData'])
        ->name('api.sync-offline-data');

    // Route untuk clear session report setelah print
    Route::get('/reports/clear-session', [DailyReportController::class, 'clearReportSession'])
        ->name('reports.clear-session');
});

Route::get('/keep-alive', function () {
    return response()->json(['status' => 'alive']);
})->name('keep-alive');