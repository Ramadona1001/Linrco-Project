<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::get('/', [App\Http\Controllers\PostController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\PostController::class, 'index'])->name('home');

Route::get('/post/{hashtag}', [App\Http\Controllers\PostController::class, 'postHashTag'])->name('hashtagpost_post');
Route::get('/single-post/{post_id}', [App\Http\Controllers\PostController::class, 'show'])->name('single_post');
Route::post('/upload-post', [App\Http\Controllers\PostController::class, 'store'])->name('upload_post');
Route::get('/delete-post/{id}', [App\Http\Controllers\PostController::class, 'destroy'])->name('delete_post');
Route::get('/edit-post/{id}', [App\Http\Controllers\PostController::class, 'edit'])->name('edit_post');
Route::post('/update-post/{id}', [App\Http\Controllers\PostController::class, 'update'])->name('update_post');

Route::get('/delete-post-image/{id}', [App\Http\Controllers\PostPhotoController::class, 'destroy'])->name('delete_post_image');

Route::get('/post-likes', [App\Http\Controllers\PostLikeController::class, 'postLikes'])->name('get_post_likes');
Route::post('/like-post', [App\Http\Controllers\PostLikeController::class, 'like'])->name('like_post');
Route::post('/dislike-post', [App\Http\Controllers\PostLikeController::class, 'dislike'])->name('dislike_post');

Route::get('/post-comments', [App\Http\Controllers\PostCommentController::class, 'postComments'])->name('get_post_comments');
Route::post('/comment-post', [App\Http\Controllers\PostCommentController::class, 'comment'])->name('comment_post');
Route::post('/delete-comment', [App\Http\Controllers\PostCommentController::class, 'destroy'])->name('delete_comment');
