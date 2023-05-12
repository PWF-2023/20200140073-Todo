<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //ini diperpendek, Syarat kalau CRUD
    Route::resource('todo', TodoController::class)->except(['show']);

    // Route::get('/todo', [TodoController::class, 'index'])->name('todo.index');
    // Route::post('/todo', [TodoController::class, 'store'])->name('todo.store');
    // Route::get('/todo/create', [TodoController::class, 'create'])->name('todo.create');
    // Route::get('/todo/{todo}/edit', [TodoController::class, 'edit'])->name('todo.edit');
    // Route::patch('/todo/{todo}', [TodoController::class, 'update'])->name('todo.update');
    // Route::delete('/todo/{todo}', [TodoController::class, 'destroy'])->name('todo.destroy');

    Route::patch('/todo/{todo}/complete', [TodoController::class, 'complete'])->name('todo.complete');
    Route::patch('/todo/{todo}/incomplete', [TodoController::class, 'uncomplete'])->name('todo.uncomplete');
    Route::delete('/todo', [TodoController::class, 'destroyCompleted'])->name('todo.deleteallcompleted');


    //get all user route and change with prefix user
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::patch('/{user}/makeadmin', [UserController::class, 'makeadmin'])->name('user.makeadmin');
        Route::patch('/{user}/removeadmin', [UserController::class, 'removeadmin'])->name('user.removeadmin');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('user.destroy');
    });
});



require __DIR__ . '/auth.php';
