<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

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
// Route::redirect('/', '/categories');
Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false, 'password.request' => false, 'reset' => false]);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('categories', CategoryController::class);
Route::delete('products/{product}/delete', [ProductController::class, 'forceDelete'])->name('products.forceDelete');
Route::resource('categories.products', ProductController::class)->shallow()->except('show');

// Route::get('fresh', function (){
//     Artisan::call('migrate:fresh --seed');
// });