<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/', [\App\Http\Controllers\ForumController::class, 'index'])->name('home');
Route::get('/discussions/{discussion:slug}', [\App\Http\Controllers\DiscussionController::class, 'show'])->name('discussions.show');
Route::post('/posts/markdown/preview', [\App\Http\Controllers\PostController::class, 'previewMarkdown'])->name('posts.preview-markdown');

Route::middleware('auth')->group(function () {
    Route::post('discussions', [\App\Http\Controllers\DiscussionController::class, 'store'])->name('discussions.store');
    Route::delete('discussions/{discussion}', [\App\Http\Controllers\DiscussionController::class, 'destroy'])->name('discussions.destroy');
    Route::post('discussions/{discussion}/posts', [\App\Http\Controllers\PostController::class, 'store'])->name('posts.store');
    Route::patch('posts/{post}', [\App\Http\Controllers\PostController::class, 'update'])->name('posts.update');
    Route::delete('posts/{post}', [\App\Http\Controllers\PostController::class, 'destroy'])->name('posts.destroy');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
