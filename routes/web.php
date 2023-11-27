<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BandsController;
use App\Http\Controllers\AlbumsController;
use App\Http\Controllers\ProfileController;

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

// Rotas para Views
Route::get('/', [HomeController::class, 'getMain'])->name('view-home');


// #Rotas Albums#
// read
Route::get('/view-band-albums/{id}', [AlbumsController::class, 'viewBandAlbuns'])->name('band-albums');

// Rota fallback
Route::fallback(function () {
    return '<h3>Ups, essa página não existe.</h3>';
});

// Rotas dashboard e gestão de perfil
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // #Rotas Albuns#

    // create
    Route::post('/store-album', [AlbumsController::class, 'assertInput'])->name('store-album');

    // update
    Route::put('/update-album/{id}', [AlbumsController::class, 'assertInput'])->name('update-albums');

    // delete
    Route::delete('/delete-album/{id}', [AlbumsController::class, 'delete'])->name('delete-album');


    // #Rotas Bandas#

    // create
    Route::post('/store-band', [BandsController::class, 'assertInput'])->name('store-band');

    // read
    Route::get('/view-bands', [BandsController::class, 'showAll'])->name('get-bands');

    // update
    Route::put('/update-band', [BandsController::class, 'assertInput'])->name('update-band');

    // delete
    Route::get('/delete-band/{id}', [BandsController::class, 'delete'])->name('delete-band');


    Route::get('/add-band/{id}', [BandsController::class, 'addNewBand'])->name('view-add-band');
    Route::get('/add-album/{id}/band/{band_id}', [AlbumsController::class, 'addNewAlbum'])->name('view-add-album');
});

require __DIR__ . '/auth.php';
