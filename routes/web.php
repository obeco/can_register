<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// ログイン関連のページのルーティング
Auth::routes();

// ログインのホーム画面のルーティング
Route::get('/register', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/',function() {
    return view('auth.login');
});


// 一覧画面表示
Route::get('/can/list', [\App\Http\Controllers\ArticleController::class, 'showList'])->name('show.list');
// 検索機能（Ajax）
Route::get('/can/list/search', [\App\Http\Controllers\ArticleController::class, 'search'])->name('search');
// 行削除機能（Ajax)
Route::delete('/can/destroy/{id}', [\App\Http\Controllers\ArticleController::class, 'destroyProduct']);
// 新規登録画面表示
Route::get('/can/regist', [\App\Http\Controllers\ArticleController::class, 'showRegist'])->name('show.regist');
// 詳細画面表示
Route::get('/can/detail/{id}', [\App\Http\Controllers\ArticleController::class, 'showDetail'])->name('show.detail');
// 一覧画面　→　編集画面表示
Route::get('/can/{id}/edit', [\App\Http\Controllers\ArticleController::class, 'showEdit'])->name('show.edit');
// 登録する
Route::post('/can/regist', [\App\Http\Controllers\ArticleController::class, 'storeProduct'])->name('store.product');
// 編集画面　→　更新画面表示
Route::post('/can/{id}/edit', [\App\Http\Controllers\ArticleController::class, 'updateProduct'])->name('update.product');

?>

