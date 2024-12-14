<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix("transactions")->group(function (){
        Route::get("/",[TransactionController::class,'index'])->name("transaction.index");
        Route::post("/filter",[TransactionController::class,'filter'])->name("transaction.filter");
        Route::post("/report",[TransactionController::class,'report'])->name("transaction.report");
        Route::get("/{id}",[TransactionController::class,'show'])->name("transaction.show");
    });
});

require __DIR__.'/auth.php';
