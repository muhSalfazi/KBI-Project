<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\CustomerLabelController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\PoCheckController;
use App\Http\Controllers\ScanWaitingPostController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImportControler;

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'index')->name('login');
    Route::post('/login-store', 'login')->name('login-process');
    Route::post('/logout', 'destroy')->name('logout');
    Route::post('/close-scan','endSessionCustomer')->name('scan.end-session');
    Route::get('/session-aktif', 'getSessionAktif')->name('session-aktif');
});

Route::controller(DashboardController::class)
->group(function () {
        Route::get('/', 'hero')->name('hero');
        Route::get('modalTable', 'tableModal')->name('modalTable');



        Route::get('tes', 'tes')->name('tes'); // For testing purposes
});

Route::middleware(['auth', 'blocked.user'])->group(function () {
    Route::controller(DashboardController::class)
        ->group(function () {
            Route::get('/system/dasboard', 'index')->name('dashboard');
            // halaman di sidebar
            Route::get('scan-admin', 'scanAdmin')->name('scanAdmin');
            Route::get('scan-leader', 'scanLeader')->name('scanLeader');
            Route::get('check-surat-jalan', 'checkSuratJalan')->name('checkSuratJalan');
            Route::get('parts-loading', 'checkPartsLoading')->name('partsLoading');
            Route::get('/pesan', 'messages')->name('pesan');
        });

        Route::controller(UserController::class)
            ->name('user.')
            ->prefix('users')
            ->group(function () {
                Route::get('user-management', 'userManagement')->name('userManagement');
                Route::post('unblock/{id}', 'unblockUser')->name('unblock');
            });

    Route::controller(ScanWaitingPostController::class)
        ->name('wp.')
        ->prefix('waiting-post')
        ->group(function () {
            Route::post('store-scan', 'storeScan')->name('store-scan');
            Route::post('store-scan-2', 'storeScan2')->name('store-scan-2');
            Route::get('index', 'index')->name('index');
            Route::get('tes', 'tes')->name('tes');
            Route::get('/data-manifest', 'dataManifest')->name('data-manifest');

            // untuk surat jalan
            Route::get('data-table-sj', 'dataTableSJ')->name('data-table-sj');
        });

        Route::controller(PoCheckController::class)
        ->name('po.')
        ->prefix('manifest')
        ->group(function () {
            Route::post('store-scan', 'processScan')->name('store-scan');

            // untuk surat jalan
            Route::post('scan-sj', 'checkManifestSJ')->name('scan-sj');
            Route::post('scan-loading', 'checkLoading')->name('scan-loading');
    });

    Route::controller(CustomerLabelController::class)
        ->name('label.')
        ->prefix('customer-label')
        ->group(function () {
            Route::post('parts-data', 'getPartsData')->name('parts-data');
            Route::post('store-scan', 'checkPartData')->name('store-scan');
            Route::post('check-ppc-loading', 'checkPartLoading')->name('scan-ppc-loading');
            Route::get('tbl-parts-loading', 'partLoading')->name('table-loading');
    });

    Route::controller(HistoryController::class)
        ->name('history.')
        ->prefix('history')
        ->group(function () {
            Route::get('admin', 'admin')->name('admin');
            Route::get('leader', 'leader')->name('leader');
            Route::get('loading', 'loading')->name('loading');
        });

});

Route::get('tes-scan', function () {return view('tes');});

Route::controller(ImportControler::class)->group(function() {
    Route::get('/index-import', 'index')->name('import.index');
    Route::post('/import-excel', 'importExcel')->name('import.excel');
    Route::get('/index-import-adm', 'indexADM')->name('import.indexADM');
    Route::post('/import-adm', 'importADM')->name('import.excelADM');
});

?>
