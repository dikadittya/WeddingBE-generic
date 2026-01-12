<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DataAlamatController;
use App\Http\Controllers\Api\DataBungaMelatiController;
use App\Http\Controllers\Api\DataBusanaController;
use App\Http\Controllers\Api\DataBusanaKategoriController;
use App\Http\Controllers\Api\MasterAlamatController;
use App\Http\Controllers\DataPropertyController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('login', [AuthController::class, 'login'])->name('login');

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('data-busana', [DataBusanaController::class, 'index']); //->middleware('casbin:data-busana,get');
});
Route::get('list-property', [DataPropertyController::class, 'listProperty']);

// Data Busana API Routes
Route::get('data-busana/{id}', [DataBusanaController::class, 'show']); //->middleware('casbin:data-busana,read');
Route::post('data-busana', [DataBusanaController::class, 'store']); //->middleware('casbin:data-busana,create');
Route::put('data-busana/{id}', [DataBusanaController::class, 'update']); //->middleware('casbin:data-busana,update');
Route::delete('data-busana/{id}', [DataBusanaController::class, 'destroy']); //->middleware('casbin:data-busana,delete');

// Data Busana Kategori API Routes
Route::get('data-busana-kategori', [DataBusanaKategoriController::class, 'index']); //->middleware('casbin:data-busana-kategori,read');
Route::get('data-busana-kategori/{id}', [DataBusanaKategoriController::class, 'show']); //->middleware('casbin:data-busana-kategori,read');
Route::post('data-busana-kategori', [DataBusanaKategoriController::class, 'store']); //->middleware('casbin:data-busana-kategori,create');
Route::put('data-busana-kategori/{id}', [DataBusanaKategoriController::class, 'update']); //->middleware('casbin:data-busana-kategori,update');
Route::delete('data-busana-kategori/{id}', [DataBusanaKategoriController::class, 'destroy']); //->middleware('casbin:data-busana-kategori,delete');

// Custom route for simple kategori busana list (dropdown usage)
Route::get('data-busana-kategori-list', [DataBusanaKategoriController::class, 'list']); //->middleware('casbin:data-busana-kategori,read');

// Data Bunga Melati API Routes
Route::get('data-bunga-melati', [DataBungaMelatiController::class, 'index']); //->middleware('casbin:data-bunga-melati,read');
Route::get('data-bunga-melati/{id}', [DataBungaMelatiController::class, 'show']); //->middleware('casbin:data-bunga-melati,read');
Route::post('data-bunga-melati', [DataBungaMelatiController::class, 'store']); //->middleware('casbin:data-bunga-melati,create');
Route::put('data-bunga-melati/{id}', [DataBungaMelatiController::class, 'update']); //->middleware('casbin:data-bunga-melati,update');
Route::delete('data-bunga-melati/{id}', [DataBungaMelatiController::class, 'destroy']); //->middleware('casbin:data-bunga-melati,delete');

// Custom routes for Data Bunga Melati
Route::get('data-bunga-melati-jenis-list', [DataBungaMelatiController::class, 'getJenisList']); //->middleware('casbin:data-bunga-melati,read');
Route::get('data-bunga-melati-bouquet-list', [DataBungaMelatiController::class, 'getBouquetList']); //->middleware('casbin:data-bunga-melati,read');

// Data Alamat API Routes
Route::get('data-alamat', [DataAlamatController::class, 'index']); //->middleware('casbin:data-alamat,read');
Route::get('data-alamat/{id}', [DataAlamatController::class, 'show']); //->middleware('casbin:data-alamat,read');
Route::post('data-alamat', [DataAlamatController::class, 'store']); //->middleware('casbin:data-alamat,create');
Route::put('data-alamat/{id}', [DataAlamatController::class, 'update']); //->middleware('casbin:data-alamat,update');
Route::delete('data-alamat/{id}', [DataAlamatController::class, 'destroy']); //->middleware('casbin:data-alamat,delete');

    // Master Alamat API Routes
Route::controller(MasterAlamatController::class)->prefix('master-alamat')->group(function () {
    Route::get('/provinsi', 'getProvinces');
    Route::get('/kabupaten', 'getRegencies');
    Route::get('/kecamatan', 'getDistricts');
});


// ####### List kebutuhan data job #######
// informasi Detail booking
// Route::get('detail-booking/{id}', [App\Http\Controllers\Api\MasterPaketController::class, 'detailBooking']);
// informasi paket wedding
Route::get('detail-paket/{id}', [App\Http\Controllers\Api\MasterPaketController::class, 'detailPaket']);
// busana pengantin perempuan   -> data busana tipe busana Kebaya/Gown
Route::get('list-busana-perempuan', [App\Http\Controllers\Api\MasterPaketController::class, 'busanaPerempuan']);
// busana pengantin Laki-laki   -> data busana tipe busana Jas/Beskap
Route::get('list-busana-laki', [App\Http\Controllers\Api\MasterPaketController::class, 'busanaLaki']);
// bunga melati
Route::get('data-bunga-melati-list', [DataBungaMelatiController::class, 'list']);

// Set Pendamping   -> data busana Set Pendamping
Route::get('list-set-pendamping', [App\Http\Controllers\Api\MasterPaketController::class, 'setPendamping']);
// Item Pendamping  -> master_item_paket id_jenis=2 [Make up dan Busana Pendamping]
Route::get('list-item-pendamping', [App\Http\Controllers\Api\MasterPaketController::class, 'itemPendamping']);

// Ukuran Dekorasi  -> master_item_paket id_jenis=3 [Dekorasi]
// Item Dekorasi    -> master_item_paket id_jenis=3 [Dekorasi]
Route::get('list-item-dekorasi', [App\Http\Controllers\Api\MasterPaketController::class, 'itemDekorasi']);

// list Entertain   -> master_item_paket id_jenis=5 [Entertain]
Route::get('list-item-entertain', [App\Http\Controllers\Api\MasterPaketController::class, 'itemEntertain']);
// list Properti    -> master_item_paket id_jenis=6 [Properti]
Route::get('list-item-properti', [App\Http\Controllers\Api\MasterPaketController::class, 'itemProperti']);