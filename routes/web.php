<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;
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

Route::get('/dashboard', function () {
    if (auth()->user()->role() == 1) {
        return Inertia::render('AdminDashboard'); // Replace with your admin dashboard component
    } else {
        return Inertia::render('UserDashboard'); // Replace with your user dashboard component
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Group chat-related routes under a middleware group
Route::middleware(['auth', 'verified'])->group(function () {
    // View the list of chats
    Route::get('/chats', [ChatController::class, 'index'])->name('chats.index');

    // View the create chat form
    Route::get('/chats/create', [ChatController::class, 'showCreate'])->name('chats.showCreate');

    // View a single chat and its messages
    Route::get('/chats/{chat}', [MessageController::class, 'index'])->name('message.index');

    // Store a new message (form submission)
    Route::post('/chats/{chat}/messages', [MessageController::class, 'store'])->name('message.store');

    // Update a message (form submission)
    Route::put('/chats/{chat}/messages/{message}', [MessageController::class, 'update'])->name('message.update');

    // Delete a message (form submission)
    Route::delete('/chats/{chat}/messages/{message}', [MessageController::class, 'destroy'])->name('message.destroy');

    // Store a new chat (form submission)
    Route::post('/chats', [ChatController::class, 'store'])->name('chats.store');

    // Delete a chat (form submission)
    Route::delete('/chats/{chat}', 'ChatController@destroy')->name('chats.destroy');
});

require __DIR__.'/auth.php';
