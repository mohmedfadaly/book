<?php

use App\Http\Controllers\ProfileController;
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
    $books = \App\Models\Book::with('borrowers')->get();
    return view('dashboard', compact('books'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

use App\Http\Controllers\BookController;

Route::middleware('auth')->group(function () {
    Route::get('/books/pdf', [BookController::class, 'exportPDF'])->name('books.export.pdf');
    Route::post('/books/{bookId}/borrow', [BookController::class, 'borrowBook'])->name('books.borrow');
    Route::resource('books', BookController::class);

});

require __DIR__.'/auth.php';
