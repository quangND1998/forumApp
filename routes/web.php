<?php

use App\Http\Controllers\ChannelController;
use App\Http\Controllers\ConfirmController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\ReplieController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ZoomController;

use App\Http\Controllers\Admin\PermisionsController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Api\AuthController;
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
Route::get('commercial/confirm', [ConfirmController::class, 'createAccountCommercial'])->name('commercial.confirm');
Route::get('channels',[ChannelController::class,'popularChannels'])->name('channels');

Route::group(['middleware' => ['web']], function () {
    Route::get('autologin',[AuthController::class,'autologin']);
});
// Route::get('/')
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('loginMissionX',[AuthController::class,'loginMissionX']);
    Route::prefix('notifications')->as('notifications.')->group(function () {
        Route::get('', [UserController::class, 'notifications'])->name('notifications');
        Route::get('markAsRead', [UserController::class, 'markAsRead'])->name('markAsRead');
        Route::delete('deleteNotifiaction', [UserController::class, 'deleteNotifiaction'])->name('deleteNotifiaction');
    });
    Route::prefix('admin')->as('admin.')->group(function () {
        Route::get('/conversations', [ConversationController::class, 'allQuestion'])->name('conversations');
        Route::post('/active-conversation', [ConversationController::class, 'setActive'])->name('conversation.active');
        
        Route::prefix('permissions')->as('permissions.')->group(function () {
            Route::get('', [PermisionsController::class, 'index'])->name('index');
            Route::post('', [PermisionsController::class, 'store'])->name('store');
            Route::put('/update/{id}', [PermisionsController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [PermisionsController::class, 'delete'])->name('delete');
        });

        Route::prefix('roles')->as('roles.')->group(function () {
            Route::get('', [RoleController::class, 'index'])->name('index');
            Route::post('', [RoleController::class, 'store'])->name('store');
            Route::put('/update/{id}', [RoleController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [RoleController::class, 'delete'])->name('delete');
        });

        Route::prefix('users')->as('users.')->group(function () {
            Route::get('', [UserController::class, 'index'])->name('index');

            Route::post('', [UserController::class, 'store'])->name('store');
            Route::put('/update/{id}', [UserController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('destroy');
            // Route::post('import/user',  [UserController::class, 'import'])->name('import');
        });
        Route::prefix('device')->as('device.')->group(function () {
            Route::get('', [DeviceController::class, 'getDevice'])->name('index');
        });

        Route::prefix('session')->as('session.')->group(function () {
            Route::get('', [ZoomController::class, 'getZoom'])->name('zoom');
            Route::get('/{code}', [ZoomController::class, 'getZoomCode'])->name('getZoomCode');
            Route::get('store', [ZoomController::class, 'store'])->name('store');
            Route::delete('delete/{id}', [ZoomController::class, 'deleteZoom'])->name('delete');
            Route::delete('deleteAll', [ZoomController::class, 'deleteAll'])->name('deleteAll');
        });
        Route::prefix('channels')->as('channels.')->group(function () {
            Route::get('', [ChannelController::class, 'index'])->name('index');
            Route::post('store', [ChannelController::class, 'store'])->name('store');
            Route::post('update/{id}', [ChannelController::class, 'update'])->name('update');
            Route::delete('delete/{id}', [ChannelController::class, 'delete'])->name('delete');
        });

        Route::prefix('conversation')->as('conversation.')->group(function () {
            Route::get('', [ConversationController::class, 'index'])->name('index');
            Route::post('store', [ConversationController::class, 'store'])->name('store');
            Route::post('update/{id}', [ConversationController::class, 'update'])->name('update');
            Route::delete('delete/{id}', [ConversationController::class, 'delete'])->name('delete');
            Route::post('makeSolved', [ConversationController::class, 'makeSolved'])->name('makeSolved');
            Route::post('lockComment', [ConversationController::class, 'lockComment'])->name('lockComment');
        });

        Route::prefix('replie')->as('replie.')->group(function () {

            Route::post('store/{id}', [ReplieController::class, 'store'])->name('store');
            Route::post('likeReplie/{id}', [ReplieController::class, 'likeRelie'])->name('like');
            Route::post('update/{id}', [ReplieController::class, 'update'])->name('update');
            Route::post('best_answer', [ReplieController::class, 'bestAnswer'])->name('bestAnswer');
            Route::delete('deleteReplie/{id}',[ReplieController::class,'deleteReplie'])->name('deleteReplie');
        });

       
    });
    Route::prefix('conversation')->as('conversation.')->group(function () {
        Route::get('create', [ConversationController::class, 'create'])->name('create');
        Route::get('edit/{id}', [ConversationController::class, 'edit'])->name('edit');

    });
    Route::prefix('delete')->group(function(){
        Route::delete('deleteImage/{id}', [ConversationController::class, 'deleteImage'])->name('deleteImage');
        Route::delete('deleteVideo/{id}', [ConversationController::class, 'deleteVideo'])->name('deleteVideo');
    });
    Route::get('myThread', [ConversationController::class, 'myConversation'])->name('myThread');
    // Route::get('setting/account/update', [ForumController::class, 'editProfile'])->name('editProfile');
    Route::post('saveProfile', [ForumController::class, 'saveProfile'])->name('saveProfile');
});
Route::get('@' . '{name}', [ForumController::class, 'profile'])->name('profile');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


// Route::get('/index', function () {
//     return Inertia::render('Index');
// });

Route::get('/getList', function () {
    return Inertia::render('Link');
})->name('getList');

Route::get('send', [ForumController::class, 'send']);
Route::post('postMessage', [ForumController::class, 'postMessage'])->name('poss.message');

Route::get('/post', [PostController::class, 'index']);
require __DIR__ . '/auth.php';
