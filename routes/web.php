<?php

use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\PartQuoteController;
use App\Http\Controllers\QuoteRequestController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SessionsController;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('migrate', function() { Artisan::call('thinker'); return back();});
// Cache Clear
Route::get('clear', function() {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('route:clear');
    return back();
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [HomeController::class, 'home']);

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('user-management', InfoUserController::class)->middleware('admin');
    Route::resource('quote-requests', QuoteRequestController::class);
    Route::resource('part-quotes', PartQuoteController::class);

    Route::get('vin', function () {
        try {
            $part_catalogs_api_key = 'OEM-API-A373331C-2684-4560-8F57-20180D8AEB08';

            $data = $response->json();

            var_dump($data);
            // do something with $data
        } catch (RequestException $e) {
            // handle exception
            var_dump($e);
        }
    });

    Route::get('tables', function () {
        return view('tables');
    })->name('tables');

    Route::get('/logout', [SessionsController::class, 'destroy']);
    Route::get('/login', function () {
        return view('pages.dashboard');
    })->name('sign-up');
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [RegisterController::class, 'create']);
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/login', [SessionsController::class, 'create']);
    Route::post('/session', [SessionsController::class, 'store']);
    Route::get('/login/forgot-password', [ResetController::class, 'create']);
    Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
    Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
    Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');
});

Route::get('/login', function () {
    return view('session/login-session');
})->name('login');

Route::get('/last', [QuoteRequestController::class, 'Last']);
Route::get('/autoquote-export', [PartQuoteController::class, 'export']);
Route::get('/downlaod', [PartQuoteController::class, 'download']);
Route::get('/quote-automate', [PartQuoteController::class, 'quoteAutomate']);
Route::post('/upload', [PartQuoteController::class, 'upload'])->name('upload');