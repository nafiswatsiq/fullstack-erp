<?php

use App\Livewire\Topic;
use App\Livewire\BookList;
use App\Livewire\Category;
use App\Livewire\Dashboard;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LogoutController;

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

Route::get('/login', Login::class)->name('login')->middleware('guest');
Route::get('/register', Register::class)->name('register')->middleware('guest');

Route::middleware('auth')->group(function () {
  Route::get('/', Dashboard::class)->name('home');
  Route::get('/category', Category::class)->name('category');
  Route::get('/topic', Topic::class)->name('topic');

  Route::post('logout', LogoutController::class)->name('logout');
});
