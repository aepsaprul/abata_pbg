<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PbgController;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function () {

    // cabang pbg

    //cs
    Route::get('pbg/cs', [PbgController::class, 'cs'])->name('pbg.cs');
    Route::get('pbg/cs/create', [PbgController::class, 'csCreate'])->name('pbg.cs.create');
    Route::post('pbg/cs/store', [PbgController::class, 'csStore'])->name('pbg.cs.store');
    Route::get('pbg/cs/{id}/edit', [PbgController::class, 'csEdit'])->name('pbg.cs.edit');
    Route::put('pbg/cs/{id}/update', [PbgController::class, 'csUpdate'])->name('pbg.cs.update');
    Route::get('pbg/cs/{id}/delete', [PbgController::class, 'csDelete'])->name('pbg.cs.delete');

    Route::get('pbg/antrian/cs', [PbgController::class, 'antrianCs'])->name('pbg.antrian.cs');
    Route::get('pbg/antrian/cs/{id}/on', [PbgController::class, 'antrianCsOn'])->name('pbg.antrian.cs.on');
    Route::get('pbg/antrian/cs/{id}/off', [PbgController::class, 'antrianCsOff'])->name('pbg.antrian.cs.off');
    Route::get('pbg/antrian/cs/nomor', [PbgController::class, 'antrianCsNomor'])->name('pbg.antrian.cs.nomor');
    Route::get('pbg/antrian/cs/{nomor}/panggil', [PbgController::class, 'antrianCsPanggil'])->name('pbg.antrian.cs.panggil');
    Route::get('pbg/antrian/cs/{nomor}/mulai', [PbgController::class, 'antrianCsMulai'])->name('pbg.antrian.cs.mulai');
    Route::get('pbg/antrian/cs/{nomor}/selesai', [PbgController::class, 'antrianCsSelesai'])->name('pbg.antrian.cs.selesai');
    Route::get('pbg/antrian/cs/reset', [PbgController::class, 'antrianCsReset'])->name('pbg.antrian.cs.reset');

    // desain 
    Route::get('pbg/desain', [PbgController::class, 'desain'])->name('pbg.desain');
    Route::get('pbg/desain/create', [PbgController::class, 'desainCreate'])->name('pbg.desain.create');
    Route::post('pbg/desain/store', [PbgController::class, 'desainStore'])->name('pbg.desain.store');
    Route::get('pbg/desain/{id}/edit', [PbgController::class, 'desainEdit'])->name('pbg.desain.edit');
    Route::put('pbg/desain/{id}/update', [PbgController::class, 'desainUpdate'])->name('pbg.desain.update');
    Route::get('pbg/desain/{id}/delete', [PbgController::class, 'desainDelete'])->name('pbg.desain.delete');

    Route::get('pbg/antrian/desain', [PbgController::class, 'antrianDesain'])->name('pbg.antrian.desain');
    Route::get('pbg/antrian/desain/{id}/on', [PbgController::class, 'antrianDesainOn'])->name('pbg.antrian.desain.on');
    Route::get('pbg/antrian/desain/{id}/off', [PbgController::class, 'antrianDesainOff'])->name('pbg.antrian.desain.off');
    Route::get('pbg/antrian/desain/nomor', [PbgController::class, 'antrianDesainNomor'])->name('pbg.antrian.desain.nomor');
    Route::get('pbg/antrian/desain/{nomor}/panggil', [PbgController::class, 'antrianDesainPanggil'])->name('pbg.antrian.desain.panggil');
    Route::get('pbg/antrian/desain/{nomor}/jenis/{nama_jenis}', [PbgController::class, 'antrianDesainUpdate'])->name('pbg.antrian.desain.update');
    Route::get('pbg/antrian/desain/{nomor}/edit', [PbgController::class, 'antrianDesainUpdateEdit'])->name('pbg.antrian.desain.updateedit');
    Route::get('pbg/antrian/desain/{nomor}/mulai', [PbgController::class, 'antrianDesainMulai'])->name('pbg.antrian.desain.mulai');
    Route::get('pbg/antrian/desain/mulai/counter', [PbgController::class, 'antrianDesainMulaiCounter'])->name('pbg.antrian.desain.mulai.counter');
    Route::get('pbg/antrian/desain/{nomor}/selesai', [PbgController::class, 'antrianDesainSelesai'])->name('pbg.antrian.desain.selesai');

    // customer 
    Route::get('pbg/customer', [PbgController::class, 'customer'])->name('pbg.customer');
});

Route::get('pbg/antrian/customer', [PbgController::class, 'antrianCustomer'])->name('pbg.antrian.customer');
Route::post('pbg/antrian/customer/search', [PbgController::class, 'antrianCustomerSearch'])->name('pbg.antrian.customer.search');
Route::post('pbg/antrian/customer/store', [PbgController::class, 'antrianCustomerStore'])->name('pbg.antrian.customer.store');
Route::get('pbg/antrian/customer/nomor', [PbgController::class, 'antrianCustomerNomor'])->name('pbg.antrian.customer.nomor');
Route::post('pbg/antrian/customer/sender', [PbgController::class, 'antrianCustomerSender'])->name('pbg.antrian.customer.sender');
Route::get('pbg/antrian/customer/{id}/form', [PbgController::class, 'antrianCustomerForm'])->name('pbg.antrian.customer.form');

Route::get('pbg/antrian/display', [PbgController::class, 'antrianDisplay'])->name('pbg.antrian.display');
