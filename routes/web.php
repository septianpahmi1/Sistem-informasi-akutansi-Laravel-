<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\Reports\AruskasController;
use App\Http\Controllers\Reports\JournalController as ReportsJournalController;
use App\Http\Controllers\Reports\LabarugiController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.loginn');
});
Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('users', [UserController::class, 'index'])->name('users');
    Route::post('users/post', [UserController::class, 'post'])->name('users.post');
    Route::post('users/update/{id}', [UserController::class, 'update'])->name('users.update');
    Route::get('users/delete/{id}', [UserController::class, 'delete'])->name('users.delete');

    Route::get('account', [AccountController::class, 'index'])->name('account');
    Route::post('account/post', [AccountController::class, 'post'])->name('account.post');
    Route::post('account/update/{id}', [AccountController::class, 'update'])->name('account.update');
    Route::get('account/delete/{id}', [AccountController::class, 'delete'])->name('account.delete');
    Route::get('account/data', [AccountController::class, 'getData'])->name('account.data');

    Route::get('supplier', [SupplierController::class, 'index'])->name('supplier');
    Route::post('supplier/post', [SupplierController::class, 'post'])->name('supplier.post');
    Route::post('supplier/update/{id}', [SupplierController::class, 'update'])->name('supplier.update');
    Route::get('supplier/delete/{id}', [SupplierController::class, 'delete'])->name('supplier.delete');

    Route::get('customer', [CustomerController::class, 'index'])->name('customer');
    Route::post('customer/post', [CustomerController::class, 'post'])->name('customer.post');
    Route::post('customer/update/{id}', [CustomerController::class, 'update'])->name('customer.update');
    Route::get('customer/delete/{id}', [CustomerController::class, 'delete'])->name('customer.delete');

    Route::get('mitra', [MitraController::class, 'index'])->name('mitra');
    Route::post('mitra/post', [MitraController::class, 'post'])->name('mitra.post');
    Route::post('mitra/update/{id}', [MitraController::class, 'update'])->name('mitra.update');
    Route::get('mitra/delete/{id}', [MitraController::class, 'delete'])->name('mitra.delete');

    Route::get('sales', [SalesController::class, 'index'])->name('sales');
    Route::get('sales/create', [SalesController::class, 'create'])->name('sales.create');
    Route::post('sales/create/post', [SalesController::class, 'post'])->name('sales.post');
    Route::get('sales/delete/{id}', [SalesController::class, 'delete'])->name('sales.delete');
    Route::get('sales/update/{id}', [SalesController::class, 'update'])->name('sales.update');
    Route::post('sales/update/post/{id}', [SalesController::class, 'updatepost'])->name('sales.updatepost');
    Route::get('sales/invoice/{id}', [SalesController::class, 'invoice'])->name('sales.invoice');

    Route::get('purchase', [PurchaseController::class, 'index'])->name('purchase');
    Route::get('purchase/create', [PurchaseController::class, 'create'])->name('purchase.create');
    Route::post('purchase/create/post', [PurchaseController::class, 'post'])->name('purchase.post');
    Route::get('purchase/delete/{id}', [PurchaseController::class, 'delete'])->name('purchase.delete');
    Route::get('purchase/update/{id}', [PurchaseController::class, 'update'])->name('purchase.update');
    Route::post('purchase/update/post/{id}', [PurchaseController::class, 'updatepost'])->name('purchase.updatepost');
    Route::get('purchase/invoice/{id}', [PurchaseController::class, 'invoice'])->name('purchase.invoice');

    Route::get('journal', [JournalController::class, 'index'])->name('journal');
    Route::get('journal/create', [JournalController::class, 'create'])->name('journal.create');
    Route::post('journal/create/post', [JournalController::class, 'post'])->name('journal.post');
    Route::get('journal/delete/{id}', [JournalController::class, 'delete'])->name('journal.delete');
    Route::get('journal/update/{id}', [JournalController::class, 'update'])->name('journal.update');
    Route::post('journal/update/post/{id}', [JournalController::class, 'updatepost'])->name('journal.updatepost');
    Route::get('journal/detail/{id}', [JournalController::class, 'detailJournal'])->name('journal.detail');

    Route::get('journal-entries', [JournalController::class, 'detail'])->name('entries');
    Route::get('journal-entries/get-data', [JournalController::class, 'getData'])->name('entries.getData');

    Route::get('reports/journal-umum', [ReportsJournalController::class, 'index'])->name('reportJournal');
    Route::get('reports/journal-umum/get-data', [ReportsJournalController::class, 'getData'])->name('reportJournal.getdata');
    Route::get('reports/laba-rugi', [LabarugiController::class, 'index'])->name('reportLaba');
    Route::get('reports/laba-rugi/get-data', [LabarugiController::class, 'getData'])->name('reportLaba.getdata');
    Route::get('reports/arus-kas', [AruskasController::class, 'index'])->name('reportAruskas');
    Route::get('reports/arus-kas/get-data', [AruskasController::class, 'getData'])->name('reportAruskas.getdata');
});

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__ . '/auth.php';
