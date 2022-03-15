<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\ReplieController;

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
    return redirect('/forum');
});
Route::get('/forum', [ForumController::class, 'index'])->name('forum');
Route::get('/question/{name}', [ReplieController::class, 'getDetail'])->name('question.getDetail');
// Route::get('/')
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


Route::get('/index', function () {
    return Inertia::render('Index');
});

Route::get('/getList', function () {
    return Inertia::render('Link');
})->name('getList');

require __DIR__ . '/auth.php';
