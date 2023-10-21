<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\RecordController;

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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::group(['prefix' => 'account'], function () {
    Route::get('/create', [AccountController::class, 'create'])->name('account.create');
    Route::get('/', [AccountController::class, 'index'])->name('account.index');
    Route::post('/store', [AccountController::class, 'store'])->name('account.store');
    Route::get('/edit/{account}', [AccountController::class, 'edit'])->name('account.edit');
    Route::put('/update/{account}', [AccountController::class, 'update'])->name('account.update');
    Route::delete('/delete/{account}', [AccountController::class, 'delete'])->name('account.delete');
});

Route::group(['prefix' => 'record'], function () {
    Route::get('/create', [RecordController::class, 'create'])->name('record.create');
    Route::get('/', [RecordController::class, 'index'])->name('record.index');
    Route::post('/store', [RecordController::class, 'store'])->name('record.store');
    Route::get('/edit/{record}', [RecordController::class, 'edit'])->name('record.edit');
    Route::put('/update/{record}', [RecordController::class, 'update'])->name('record.update');
    Route::delete('/delete/{record}', [RecordController::class, 'delete'])->name('record.delete');
});

Route::group(['prefix' => 'budget'], function () {
    Route::get('/createUserTemplate', [BudgetController::class, 'createUserTemplate'])->name('budget.createUserTemplate');
    Route::get('/createDefaultTemplate', [BudgetController::class, 'createDefaultTemplate'])->name('budget.createDefaultTemplate');
    Route::get('/', [BudgetController::class, 'index'])->name('budget.index');
    Route::post('/storeDefaultTemplate', [BudgetController::class, 'storeDefaultTemplate'])->name('budget.storeDefaultTemplate');
    Route::post('/storeUserTemplate', [BudgetController::class, 'storeUserTemplate'])->name('budget.storeUserTemplate');
    Route::get('/editDefaultTemplate/{budget}', [BudgetController::class, 'editDefaultTemplate'])->name('budget.editDefaultTemplate');
    Route::get('/editUserTemplate/{budget}', [BudgetController::class, 'editUserTemplate'])->name('budget.editUserTemplate');
    Route::put('/update/{budget}', [BudgetController::class, 'update'])->name('budget.update');
    Route::delete('/delete/{budget}', [BudgetController::class, 'delete'])->name('budget.delete');
});