<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\ProductController;
use App\Http\Controllers\Public\PageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AccountingController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\InsuranceController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\SuperAdmin\ProductController as SuperAdminProductController;
use App\Http\Controllers\Public\AppointmentController as PublicAppointmentController;
use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboard;
// Pages publiques
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/montures', [ProductController::class, 'index'])->name('products.index');
Route::get('/montures/{product:slug}', [ProductController::class, 'show'])->name('products.show');

Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/a-propos', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'contactStore'])->name('contact.store');

Route::get('/rendez-vous', [PublicAppointmentController::class, 'create'])->name('appointment.create');
Route::post('/rendez-vous', [PublicAppointmentController::class, 'store'])->name('appointment.store');

// ---------- ESPACE SUPER-ADMIN ----------
 Route::middleware(['auth', 'role:superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/', [SuperAdminDashboard::class, 'index'])->name('dashboard');

    // Catalogue
    Route::patch('products/{product}/visibility', [SuperAdminProductController::class, 'toggleVisibility'])
        ->name('products.toggle-visibility');
    Route::resource('products', SuperAdminProductController::class)->except(['show']);
});
  // ---------- ESPACE ADMIN / ÉQUIPE ----------
   Route::middleware(['auth', 'role:opticien,admin,superadmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Commandes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');

    // Clients
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/export', [CustomerController::class, 'export'])->name('customers.export');
    Route::post('/customers/import', [CustomerController::class, 'import'])->name('customers.import');
    Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
    Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');

    // Rendez-vous
    Route::get('/appointments', [AdminAppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/{appointment}', [AdminAppointmentController::class, 'show'])->name('appointments.show');
    Route::patch('/appointments/{appointment}/status', [AdminAppointmentController::class, 'updateStatus'])->name('appointments.update-status');

        // Produits (géré par l'équipe)
    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
    Route::get('/products/search-api', [\App\Http\Controllers\Admin\ProductController::class, 'searchApi'])->name('products.search-api');
    Route::get('/products/create', [AdminProductController::class, 'create'])->name('products.create');
    Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
    // Achats / Stock
    Route::get('/purchases', [\App\Http\Controllers\Admin\PurchaseController::class, 'index'])->name('purchases.index');
    Route::get('/purchases/create', [\App\Http\Controllers\Admin\PurchaseController::class, 'create'])->name('purchases.create');
    Route::post('/purchases', [\App\Http\Controllers\Admin\PurchaseController::class, 'store'])->name('purchases.store');
    Route::get('/purchases/{purchase}', [\App\Http\Controllers\Admin\PurchaseController::class, 'show'])->name('purchases.show');
    Route::get('/purchases/{purchase}/edit', [\App\Http\Controllers\Admin\PurchaseController::class, 'edit'])->name('purchases.edit');
    Route::put('/purchases/{purchase}', [\App\Http\Controllers\Admin\PurchaseController::class, 'update'])->name('purchases.update');
    Route::delete('/purchases/{purchase}', [\App\Http\Controllers\Admin\PurchaseController::class, 'destroy'])->name('purchases.destroy');

        // Comptabilité
    Route::get('/accounting', [\App\Http\Controllers\Admin\AccountingController::class, 'index'])->name('accounting.index');

    // Assurances
    Route::get('/insurances', [\App\Http\Controllers\Admin\InsuranceController::class, 'index'])->name('insurances.index');
    Route::get('/insurances/{insurance}/orders', [\App\Http\Controllers\Admin\InsuranceController::class, 'orders'])->name('insurances.orders');
    // Messagerie
    Route::get('/messages', [\App\Http\Controllers\Admin\ConversationController::class, 'index'])->name('messages.index');
    Route::get('/messages/{conversation}', [\App\Http\Controllers\Admin\ConversationController::class, 'show'])->name('messages.show');
    Route::post('/messages/{conversation}/reply', [\App\Http\Controllers\Admin\ConversationController::class, 'reply'])->name('messages.reply');
});

 // ---------- ESPACE CLIENT ----------
Route::middleware(['auth', 'role:client'])->prefix('mon-espace')->name('client.')->group(function () {
    // Dashboard
    Route::get('/', [\App\Http\Controllers\Client\DashboardController::class, 'index'])->name('dashboard');

    // Commandes
    Route::get('/commandes', [\App\Http\Controllers\Client\OrderController::class, 'index'])->name('orders.index');
    Route::get('/commandes/{order}', [\App\Http\Controllers\Client\OrderController::class, 'show'])->name('orders.show');

    // Rendez-vous
    Route::get('/rendez-vous', [\App\Http\Controllers\Client\AppointmentController::class, 'index'])->name('appointments.index');
    Route::post('/rendez-vous', [\App\Http\Controllers\Client\AppointmentController::class, 'store'])->name('appointments.store'); // <-- AJOUTÉ

    // Messagerie
    Route::get('/messages', [\App\Http\Controllers\Client\MessageController::class, 'index'])->name('messages.index');
    Route::post('/messages', [\App\Http\Controllers\Client\MessageController::class, 'store'])->name('messages.store'); // <-- AJOUTÉ
    Route::get('/messages/{conversation}', [\App\Http\Controllers\Client\MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{conversation}/reply', [\App\Http\Controllers\Client\MessageController::class, 'reply'])->name('messages.reply');
});
require __DIR__.'/auth.php';
