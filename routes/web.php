<?php

use App\Http\Controllers\ChanelController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\ReplieController;
use App\Http\Controllers\ConversationController;
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

Route::get('language/{language}', function ($language) {
    Session()->put('locale', $language);
    return redirect()->back();
})->name('language');
Route::get('/forum', [ForumController::class, 'index'])->name('forum');
Route::get('/solved', [ForumController::class, 'getSolved'])->name('solved');
Route::get('/Unsolved', [ForumController::class, 'getUnsolved'])->name('Unsolved');

Route::get('/question/{name}', [ReplieController::class, 'getDetail'])->name('question.getDetail');
// Route::get('/')
Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('admin')->as('admin.')->group(function () {
        Route::prefix('chanels')->as('chanels.')->group(function () {
            Route::get('', [ChanelController::class, 'index'])->name('index');
            Route::post('store', [ChanelController::class, 'store'])->name('store');
            Route::post('update/{id}', [ChanelController::class, 'update'])->name('update');
            Route::delete('delete/{id}', [ChanelController::class, 'delete'])->name('delete');
        });

        Route::prefix('conversation')->as('conversation.')->group(function () {
            Route::get('', [ConversationController::class, 'index'])->name('index');
            Route::post('store', [ConversationController::class, 'store'])->name('store');
            Route::post('update/{id}', [ConversationController::class, 'update'])->name('update');
            Route::delete('delete/{id}', [ConversationController::class, 'delete'])->name('delete');
            Route::post('makeSolved', [ConversationController::class, 'makeSolved'])->name('makeSolved');
        });

        Route::prefix('replie')->as('replie.')->group(function () {

            Route::post('store/{id}', [ReplieController::class, 'store'])->name('store');
            Route::post('likeReplie/{id}', [ReplieController::class, 'likeRelie'])->name('like');
            Route::put('update/{id}', [ReplieController::class, 'update'])->name('update');
            Route::post('best_answer', [ReplieController::class, 'bestAnswer'])->name('bestAnswer');
        });
    });
    Route::get('myThread', [ConversationController::class, 'myConversation'])->name('myThread');
    Route::get('setting/account/update', [ForumController::class, 'editProfile'])->name('editProfile');
});
Route::get('@' . '{name}', [ForumController::class, 'profile'])->name('profile');

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
