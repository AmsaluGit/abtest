<?php

use App\Http\Controllers\CounterController;
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

Route::get('/', function () {
    return view('welcome');
});
/*
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
*/
Route::get('/dashboard', [CounterController::class,'dashboard'])->name('dashboard');
Route::get('/variation', [CounterController::class,'variation'])->name('variation');
Route::get('/control', [CounterController::class,'control'])->name('control');
Route::post('/setting/update', [CounterController::class,'settingUpdate'])->name('settingu');
Route::get('/setting', [CounterController::class,'setting'])->name('setting');
Route::get('/last', [CounterController::class,'last'])->name('last');

require __DIR__.'/auth.php';
