<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceAttachmentController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceDetailController;
use App\Http\Controllers\InvoicesReports;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;







/*

$2y$12$JkktqU.iRG.IDf1tjX3I2unNk4z0iBUev8pcUQd5KKS3M6NZNMGWS

https://chat.whatsapp.com/B80ZpvRgrpbEAk4LVGPnGa

*/

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');

Auth::routes(['register' => false]);

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function() {

    Route::resource('invoices', InvoiceController::class);

    Route::get('section/{id}', [InvoiceController::class, 'getProducts']);

    Route::post('change_status/{id}', [InvoiceController::class, 'change_status'])->name('change_status');

    Route::get('print_invoice/{id}', [InvoiceController::class, 'print_invoice'])->name('invoices.print');

    Route::get('export_invoice', [InvoiceController::class, 'export']);

    Route::get('notification/markread', [InvoiceController::class, 'markAllRead'])->name('notification.markread');

    Route::resource('sections', SectionController::class);

    Route::resource('products', ProductController::class);

    Route::get('InvoicesDetails/{id}', [InvoiceDetailController::class, 'edit'])->name('InvoicesDetails');

    Route::get('show/{invoice_number}/{file_name}', [InvoiceDetailController::class, 'open_file'])->name('show');

    Route::get('download/{invoice_number}/{file_name}', [InvoiceDetailController::class, 'get_file'])->name('download');

    Route::delete('delete_file', [InvoiceDetailController::class, 'destroy'])->name('delete_file');

    Route::post('attachement/store', [InvoiceAttachmentController::class, 'store'])->name('attachment.store');

    Route::resource('roles', RoleController::class);
    
    Route::resource('users', UserController::class);

    Route::get('invoices_reports', [InvoicesReports::class, 'index'])->name('invoices_reports');
    
    Route::post('invoices_search', [InvoicesReports::class, 'search'])->name('invoices_search');

});

Route::get('/{page}', [AdminController::class, 'index']);


