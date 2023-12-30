<?php

use Illuminate\Http\Request;
use App\Http\Middleware\CheckSession;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\SwitchSessionController;
use App\Http\Controllers\ExpenseSharingController;

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

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', CheckSession::class])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/switch-session', [SwitchSessionController::class, 'switchSession'])->name('switch-session');

    // route for account module
    Route::group(['prefix' => 'account'], function () {
        Route::get('/', [AccountController::class, 'index'])->name('account.index');
        Route::get('/create', [AccountController::class, 'create'])->name('account.create');
        Route::post('/store', [AccountController::class, 'store'])->name('account.store');
        Route::get('/edit/{account}', [AccountController::class, 'edit'])->name('account.edit');
        Route::put('/update/{account}', [AccountController::class, 'update'])->name('account.update');
        Route::delete('/delete/{account}', [AccountController::class, 'delete'])->name('account.delete');
    });

    // route for record module
    Route::group(['prefix' => 'record'], function () {
        Route::get('/', [RecordController::class, 'index'])->name('record.index');
        Route::get('/search', [RecordController::class, 'search'])->name('record.search');
        Route::get('/fetchByDate', [RecordController::class, 'fetchByDate'])->name('record.fetchByDate');
        Route::get('/filter', [RecordController::class, 'filter'])->name('record.filter');
        Route::get('/create', [RecordController::class, 'create'])->name('record.create');
        Route::post('/store', [RecordController::class, 'store'])->name('record.store');
        Route::get('/edit/{record}', [RecordController::class, 'edit'])->name('record.edit');
        Route::put('/update/{record}', [RecordController::class, 'update'])->name('record.update');
        Route::delete('/delete/{record}', [RecordController::class, 'delete'])->name('record.delete');
    });

    // route for budget module
    Route::group(['prefix' => 'budget'], function () {
        Route::get('/', [BudgetController::class, 'index'])->name('budget.index');
        Route::get('/createUserTemplate', [BudgetController::class, 'createUserTemplate'])->name('budget.createUserTemplate');
        Route::post('/storeUserTemplate', [BudgetController::class, 'storeUserTemplate'])->name('budget.storeUserTemplate');
        Route::get('/editUserTemplate/{budget}', [BudgetController::class, 'editUserTemplate'])->name('budget.editUserTemplate');
        Route::put('/updateUserTemplate/{budget}', [BudgetController::class, 'updateUserTemplate'])->name('budget.updateUserTemplate');
        Route::get('/createDefaultTemplate', [BudgetController::class, 'createDefaultTemplate'])->name('budget.createDefaultTemplate');
        Route::post('/storeDefaultTemplate', [BudgetController::class, 'storeDefaultTemplate'])->name('budget.storeDefaultTemplate');
        Route::get('/editDefaultTemplate/{budget}', [BudgetController::class, 'editDefaultTemplate'])->name('budget.editDefaultTemplate');
        Route::put('/updateDefaultTemplate/{budget}', [BudgetController::class, 'updateDefaultTemplate'])->name('budget.updateDefaultTemplate');
        Route::delete('/delete/{budget}', [BudgetController::class, 'delete'])->name('budget.delete');
    });

    // route for statistic module
    Route::group(['prefix' => 'statistic'], function () {
        Route::get('/', [StatisticController::class, 'index'])->name('statistic.index');
        Route::get('/expense', [StatisticController::class, 'expense'])->name('statistic.expense');
        Route::get('/income', [StatisticController::class, 'income'])->name('statistic.income');
    });

    // route for expense sharing & group module
    Route::group(['prefix' => 'expense-sharing', 'as' => 'expense-sharing.'], function () {
        Route::get('/', [ExpenseSharingController::class, 'index'])->name('index');
        Route::get('/create', [ExpenseSharingController::class, 'create'])->name('create');
        Route::post('/store', [ExpenseSharingController::class, 'store'])->name('store');
        Route::get('/edit/{group}', [ExpenseSharingController::class, 'edit'])->name('edit');
        Route::put('/update/{group}', [ExpenseSharingController::class, 'update'])->name('update');
        Route::delete('/delete/{group}', [ExpenseSharingController::class, 'delete'])->name('delete');


        Route::group(['prefix' => 'groups', 'as' => 'groups.'], function () {
            Route::get('/', [GroupController::class, 'index'])->name('index');
            Route::post('/send-invitation/{groupId}', [GroupController::class, 'sendInvitation'])->name('send-invitation');
            Route::get('/accept-invitation/{groupId}/{token}', [GroupController::class, 'acceptInvitation'])->name('accept-invitation');
        });
    });
});
