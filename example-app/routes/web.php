<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\TestController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SearchController;

//コメントアウトした
// Route::get('test', [TestController::class, 'test'])
//     ->name('test');

//リアルタイム検索のためのルート
Route::get('/ajax/search', [SearchController::class, 'ajaxSearch'])
->name('ajax.search');
//リアルタイム検索ページ（search.blade.php）表示のためのルート
// Route::get('/post/search', [SearchController::class, 'showSearchForm'])
// ->name('post.search.form');

Route::resource('post', PostController::class);


Route::get('/', function () {
    return view('welcome');
});

//書き足した
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

//コメントアウトした
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::get('post/create', [PostController::class, 'create']);

//コメントアウトした
// Route::post('post', [PostController::class, 'store'])
//     ->name('post.store');
// Route::get('post', [PostController::class, 'index'])
// ->name('post.index');
// Route::get('post/create', [PostController::class, 'create'])
//     ->middleware(['auth', 'admin']);

// Route::get('/', function () {
//     return view('welcome');
// });

//コメントアウトした
// Route::get('post/show/{post}', [PostController::class, 'show'])
//     ->name('post.show');

//コメントアウトした
// Route::get('post/{post}/edit', [PostController::class, 'edit'])
//     ->name('post.edit');
// Route::patch('post/{post}', [PostController::class, 'update'])
//     ->name('post.update');
// Route::delete('post/{post}', [PostController::class, 'destroy'])
// ->name('post.destroy');


//コメントを投稿するルート
Route::post('post/{post}/comments', [CommentController::class, 'store'])
->name('comments.store');


require __DIR__ . '/auth.php';
