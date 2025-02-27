<?php

use App\Http\Controllers\itemController;
use Illuminate\Support\Facades\Route;
//Mengimpor kelas ItemController dari namespace App\Http\Controllers dan kelas Route dari Illuminate\Support\Facades.
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
//Komentar blok yang disediakan oleh Laravel untuk menandai bagian definisi rute web.

Route::get('/', function () { 
    return view('welcome'); //rute ini mengatur agar saat pengguna mengunjungi halaman utama aplikasi, mereka disajikan dengan halaman welcome.
});

Route::resource('items', itemController::class); //Mendefinisikan rute resource untuk items yang akan menangani semua operasi CRUD (Create, Read, Update, Delete) menggunakan ItemController.
/*Dengan satu baris ini, Laravel secara otomatis membuat rute untuk berbagai aksi seperti:
    GET /items → index
    GET /items/create → create
    POST /items → store
    GET /items/{item} → show
    GET /items/{item}/edit → edit
    PUT/PATCH /items/{item} → update
    DELETE /items/{item} → destroy*/
