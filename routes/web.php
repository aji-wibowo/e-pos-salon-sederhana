<?php

use Illuminate\Support\Facades\Auth;
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
    if (Auth::check()) {
        return redirect(Auth::user()->level);
    } else {
        return redirect('/login');
    }
});

Auth::routes(['register' => false]);

Route::prefix('/owner')->middleware('auth', 'cekLevel:owner')->group(function () {
    Route::get('/', [App\Http\Controllers\OwnerController::class, 'index'])->name('owner_home');

    // master user
    Route::get('/master/user', [App\Http\Controllers\OwnerController::class, 'master_user'])->name('owner_master_user');
    Route::post('/master/user/insert/process', [\App\Http\Controllers\OwnerController::class, 'master_user_tambah_proses'])->name('owner_master_user_insert_process');
    Route::post('/master/user/update/process/{id}', [\App\Http\Controllers\OwnerController::class, 'master_user_ubah_proses'])->name('owner_master_user_update_process');
    Route::get('/master/user/delete/process/{id}', [\App\Http\Controllers\OwnerController::class, 'master_user_hapus_proses'])->name('owner_master_user_delete_process');

    // master customer
    Route::get('/master/customer', [\App\Http\Controllers\OwnerController::class, 'master_customer'])->name('owner_master_customer');
    Route::post('/master/customer/insert/process', [\App\Http\Controllers\OwnerController::class, 'master_customer_tambah_proses'])->name('owner_master_customer_insert_process');
    Route::post('/master/customer/update/process/{id}', [\App\Http\Controllers\OwnerController::class, 'master_customer_ubah_proses'])->name('owner_master_customer_update_process');
    Route::get('/master/customer/delete/process/{id}', [\App\Http\Controllers\OwnerController::class, 'master_customer_hapus_proses'])->name('owner_master_customer_delete_process');

    // master treatment
    Route::get('/master/treatment', [\App\Http\Controllers\OwnerController::class, 'master_treatment'])->name('owner_master_treatment');
    Route::post('/master/treatment/insert/process', [\App\Http\Controllers\OwnerController::class, 'master_treatment_tambah_proses'])->name('owner_master_treatment_insert_process');
    Route::post('/master/treatment/update/process/{id}', [\App\Http\Controllers\OwnerController::class, 'master_treatment_ubah_proses'])->name('owner_master_treatment_update_process');
    Route::get('/master/treatment/delete/process/{id}', [\App\Http\Controllers\OwnerController::class, 'master_treatment_hapus_proses'])->name('owner_master_treatment_delete_process');

    // master produk
    Route::get('/master/product', [\App\Http\Controllers\OwnerController::class, 'master_product'])->name('owner_master_product');
    Route::post('/master/product/insert/process', [\App\Http\Controllers\OwnerController::class, 'master_product_tambah_proses'])->name('owner_master_product_insert_process');
    Route::post('/master/product/update/process/{id}', [\App\Http\Controllers\OwnerController::class, 'master_product_ubah_proses'])->name('owner_master_product_update_process');
    Route::get('/master/product/delete/process/{id}', [\App\Http\Controllers\OwnerController::class, 'master_product_hapus_proses'])->name('owner_master_product_delete_process');

    // master account
    Route::get('/master/account', [\App\Http\Controllers\OwnerController::class, 'master_account'])->name('owner_master_account');
    Route::post('/master/account/insert/process', [\App\Http\Controllers\OwnerController::class, 'master_account_tambah_proses'])->name('owner_master_account_insert_process');
    Route::post('/master/account/update/process/{id}', [\App\Http\Controllers\OwnerController::class, 'master_account_ubah_proses'])->name('owner_master_account_update_process');
    Route::get('/master/account/delete/process/{id}', [\App\Http\Controllers\OwnerController::class, 'master_account_hapus_proses'])->name('owner_master_account_delete_process');

    // transaction
    Route::get('/transaction', [\App\Http\Controllers\OwnerController::class, 'transaction_view'])->name('transaction_view');
    Route::post('/temporary/insert', [\App\Http\Controllers\OwnerController::class, 'temporary_insert'])->name('temporary_insert');
    Route::post('/temporary/get', [\App\Http\Controllers\OwnerController::class, 'temporary_get'])->name('temporary_get');
    Route::post('/temporary/delete', [\App\Http\Controllers\OwnerController::class, 'temporary_delete'])->name('temporary_delete');
    Route::post('/transaction', [\App\Http\Controllers\OwnerController::class, 'transaction_process'])->name('transaction_process');

    // jurnal transaction
    Route::get('transaction/jurnal', [\App\Http\Controllers\OwnerController::class, 'transaction_jurnal'])->name('transaction_jurnal');
    Route::post('transaction/jurnal', [\App\Http\Controllers\OwnerController::class, 'transaction_jurnal_post'])->name('transaction_jurnal_post');
    Route::post('transaction/jurnal/{id}', [\App\Http\Controllers\OwnerController::class, 'transaction_jurnal_post_edit'])->name('transaction_jurnal_post_edit');
    Route::get('transaction/jurnal/{id}', [\App\Http\Controllers\OwnerController::class, 'transaction_jurnal_hapus_proses'])->name('transaction_jurnal_hapus_proses');

    // laporan transaksi
    Route::get('transaction/report', [\App\Http\Controllers\OwnerController::class, 'transaction_report_view'])->name('transaction_report_view');
    Route::post('transaction/report', [\App\Http\Controllers\OwnerController::class, 'transaction_report_process'])->name('transaction_report_process');

    Route::get('transaction/report/jurnal', [\App\Http\Controllers\OwnerController::class, 'transaction_report_jurnal_view'])->name('transaction_report_jurnal_views');
    Route::post('transaction/report/jurnal', [\App\Http\Controllers\OwnerController::class, 'transaction_report_jurnal_process'])->name('transaction_report_jurnal_process');
});

Route::prefix('/kasir')->middleware('auth', 'cekLevel:kasir')->group(function () {
    Route::get('/', [App\Http\Controllers\KasirController::class, 'index'])->name('kasir_home');

    // master produk
    Route::get('/master/product', [\App\Http\Controllers\KasirController::class, 'master_product'])->name('kasir_master_product');
    Route::post('/master/product/insert/process', [\App\Http\Controllers\KasirController::class, 'master_product_tambah_proses'])->name('kasir_master_product_insert_process');
    Route::post('/master/product/update/process/{id}', [\App\Http\Controllers\KasirController::class, 'master_product_ubah_proses'])->name('kasir_master_product_update_process');
    Route::get('/master/product/delete/process/{id}', [\App\Http\Controllers\KasirController::class, 'master_product_hapus_proses'])->name('kasir_master_product_delete_process');

    // master customer
    Route::get('/master/customer', [\App\Http\Controllers\KasirController::class, 'master_customer'])->name('kasir_master_customer');
    Route::post('/master/customer/insert/process', [\App\Http\Controllers\KasirController::class, 'master_customer_tambah_proses'])->name('kasir_master_customer_insert_process');
    Route::post('/master/customer/update/process/{id}', [\App\Http\Controllers\KasirController::class, 'master_customer_ubah_proses'])->name('kasir_master_customer_update_process');
    Route::get('/master/customer/delete/process/{id}', [\App\Http\Controllers\KasirController::class, 'master_customer_hapus_proses'])->name('kasir_master_customer_delete_process');

    // transaction
    Route::get('/transaction', [\App\Http\Controllers\KasirController::class, 'transaction_view'])->name('transaction_view');
    Route::post('/temporary/insert', [\App\Http\Controllers\KasirController::class, 'temporary_insert'])->name('temporary_insert');
    Route::post('/temporary/get', [\App\Http\Controllers\KasirController::class, 'temporary_get'])->name('temporary_get');
    Route::post('/temporary/delete', [\App\Http\Controllers\KasirController::class, 'temporary_delete'])->name('temporary_delete');
    Route::post('/transaction', [\App\Http\Controllers\KasirController::class, 'transaction_process'])->name('transaction_process');

    // master account
    Route::get('/master/account', [\App\Http\Controllers\KasirController::class, 'master_account'])->name('kasir_master_account');
    Route::post('/master/account/insert/process', [\App\Http\Controllers\KasirController::class, 'master_account_tambah_proses'])->name('kasir_master_account_insert_process');
    Route::post('/master/account/update/process/{id}', [\App\Http\Controllers\KasirController::class, 'master_account_ubah_proses'])->name('kasir_master_account_update_process');
    Route::get('/master/account/delete/process/{id}', [\App\Http\Controllers\KasirController::class, 'master_account_hapus_proses'])->name('kasir_master_account_delete_process');
});


Route::prefix('/')->middleware('auth')->group(function () {
    Route::get('/profil', [\App\Http\Controllers\ProfileController::class, 'profile_view'])->name('profile_view');
    Route::post('/profil', [\App\Http\Controllers\ProfileController::class, 'profile_process'])->name('profile_process');
});
