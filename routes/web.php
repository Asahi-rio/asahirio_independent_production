<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;


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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

//会員登録画面で行う処理//
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'create'])->name('create');

//ログイン画面で行う処理//
Route::get('/', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'signin'])->name('signin');


Route::group(['middleware' => 'auth'], function (){
    // ホーム画面
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

///アイテム管理、登録を行う処理
Route::prefix('items')->group(function () {
    //アイテム一覧画面表示

    Route::get('/item', [App\Http\Controllers\ItemController::class, 'index'])->name('item.index');
    //アイテム登録
    Route::get('/add', [App\Http\Controllers\ItemController::class, 'create'])->name('item.add');
    Route::post('/add', [App\Http\Controllers\ItemController::class, 'store'])->name('item.store');
    //登録しようとする際に同じ名前が重複している場合にアラートを出す処理
    Route::post('/check-name', [App\Http\Controllers\ItemController::class, 'checkName'])->name('item.checkName');

    //アイテム登録完了画面遷移
    Route::get('/add/completion', [ItemController::class, 'completion'])->name('item.completion');

    ///商品の詳細画面を表示する
    Route::get('/item/{id}', [App\Http\Controllers\ItemController::class, 'description'])->name('item.description');
    Route::get('/description', [App\Http\Controllers\ItemController::class, 'description']);

    //アイテムの情報を編集する
    Route::get('/item/{id}/edit', [ItemController::class, 'edit'])->name('item.edit');
    Route::put('/item/{id}', [ItemController::class, 'update'])->name('item.update');
    Route::delete('/item/{id}', [ItemController::class, 'destroy'])->name('item.destroy');

});
