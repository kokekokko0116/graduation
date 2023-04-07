<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CardController;
use App\Http\Controllers\MastertestController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SearchController;
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

// ログインしていないときはアプリケーション利用不可となるコード
Route::middleware('auth')->group(function () {
  Route::get('/mypage', [MastertestController::class, 'mypage'])->name('mastertest.mypage');
  Route::get('mastertest/search/edit_result', [SearchController::class, 'edit_result'])->name('search.edit_result');
  Route::post('mastertest/{mastertest}/stock', [StockController::class, 'store'])->name('stock');
  Route::post('mastertest/{mastertest}/unstock', [StockController::class, 'destroy'])->name('unstock');
  Route::post('mastertest/{mastertest}/increment', [MastertestController::class, 'increment'])->name('mastertest.increment');
  Route::post('mastertest/{mastertest}/decrement', [MastertestController::class, 'decrement'])->name('mastertest.decrement');

  Route::resource('card', CardController::class);
  Route::resource('mastertest', MastertestController::class);
});

Route::get('/', function () {
    return view('welcome');
});


Route::get('/commons/show', function () {
    return view('commons.show');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
