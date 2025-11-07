<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SewaController;

Route::get('/kendaraan/list', function () {
    return \App\Models\Kendaraan::select('id_kendaraans', 'nomor_kendaraan')->get();
});


Route::get('/',[SewaController::class,'index'])->name('dashboard.index');
Route::get('/sewa/data',[SewaController::class,'getData'])->name('dashboard.data');
Route::get('/sewa/{id_sewas}',[SewaController::class,'show'])->name('dashboard.show');
Route::post('/sewa',[SewaController::class,'store'])->name('dashboard.store');
Route::put('/sewa/{$id_sewas}',[SewaController::class,'update'])->name('dashboard.update');
Route::delete('/sewa/{$id_sewas}',[SewaController::class,'destroy'])->name('dashboard.destroy');

