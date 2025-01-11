<?php

// Import Controllers
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SalesOrderController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\CashReceiptController;
use App\Http\Controllers\CreditNoteController;
use App\Http\Controllers\DebitNoteController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ShipmentController;
use Illuminate\Support\Facades\Route;

Auth::routes(['register' => false]);

// Password Reset Routes
Route::prefix('password')->group(function () {
    Route::get('/reset', 'App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('/email', 'App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('/reset/{token}', 'App\Http\Controllers\Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('/reset', 'App\Http\Controllers\Auth\ResetPasswordController@reset')->name('password.update');
});

// Auth
Route::middleware(['auth'])->group(function () {
    // Users Routes
    Route::prefix('users')->group(function () {
        Route::get('/export', [UserController::class, 'export'])->name('users.export');
        Route::get('/new', [UserController::class, 'new'])->name('users.new');
        Route::post('/create', [UserController::class, 'create'])->name('users.create');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::post('/{user}/update', [UserController::class, 'update'])->name('users.update');
        Route::get('/{user}/delete', [UserController::class, 'destroy'])->name('users.destroy');
        Route::get('/', [UserController::class, 'index'])->name('users');
    });

    // Profile Routes
    Route::prefix('profile')->group(function () {
        Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('/savepassword', [ProfileController::class, 'SavePassword'])->name('profile.SavePassword');
        Route::get('/', [ProfileController::class, 'show'])->name('profile');
    });

    // Item Routes
    Route::prefix('items')->group(function () {
        Route::get('/export', [ItemController::class, 'export'])->name('items.export');
        Route::get('/new', [ItemController::class, 'new'])->name('items.new');
        Route::post('/create', [ItemController::class, 'create'])->name('items.create');
        Route::get('/{item}/edit', [ItemController::class, 'edit'])->name('items.edit');
        Route::post('/{item}/update', [ItemController::class, 'update'])->name('items.update');
        Route::get('/{item}/activity', [ItemController::class, 'activity'])->name('items.activity');
        Route::post('/report', [ItemController::class, 'report'])->name('items.report');
        Route::get('/report', [ItemController::class, 'report_page'])->name('items.report_page');
        Route::get('/{item}/report', [ItemController::class, 'item_report'])->name('items.item_report');
        Route::get('/{item}/delete', [ItemController::class, 'destroy'])->name('items.destroy');
        Route::get('/', [ItemController::class, 'index'])->name('items');
    });

    // Logs Routes
    Route::prefix('logs')->group(function () {
        Route::get('/export', [LogController::class, 'export'])->name('logs.export');
        Route::get('/', [LogController::class, 'index'])->name('logs');
    });

    // Sales Orders Routes
    Route::prefix('sales_orders')->group(function () {
        Route::get('/export', [SalesOrderController::class, 'export'])->name('sales_orders.export');
        Route::get('/new', [SalesOrderController::class, 'new'])->name('sales_orders.new');
        Route::post('/create', [SalesOrderController::class, 'create'])->name('sales_orders.create');
        Route::get('/items/{sales_order_item}/delete', [SalesOrderController::class, 'item_destroy'])->name('sales_orders.items.destroy');
        Route::get('/{sales_order}/edit', [SalesOrderController::class, 'edit'])->name('sales_orders.edit');
        Route::post('/{sales_order}/update', [SalesOrderController::class, 'update'])->name('sales_orders.update');
        Route::get('/{sales_order}/show', [SalesOrderController::class, 'show'])->name('sales_orders.show');
        Route::get('/live_search', [SalesOrderController::class, 'live_search'])->name('sales_orders.live_search');
        Route::get('/search', [SalesOrderController::class, 'search'])->name('sales_orders.search');
        Route::get('/{sales_order}/delete', [SalesOrderController::class, 'destroy'])->name('sales_orders.destroy');
        Route::get('/{sales_order}/new_invoice', [SalesOrderController::class, 'new_invoice'])->name('sales_orders.new_invoice');
        Route::get('/', [SalesOrderController::class, 'index'])->name('sales_orders');
    });
    Route::prefix('sales_order_items')->group(function () {
        Route::get('/{sales_order_item}/return', [SalesOrderController::class, 'Return'])->name('sales_orders.return');
        Route::get('/{sales_order}/returnall', [SalesOrderController::class, 'return_all'])->name('sales_orders.return_all');
        Route::get('/export', [SalesOrderController::class, 'export_so_items'])->name('sales_order_items.export');
    });

    // Purchase Orders Routes
    Route::prefix('purchase_orders')->group(function () {
        Route::get('/export', [PurchaseOrderController::class, 'export'])->name('purchase_orders.export');
        Route::get('/new', [PurchaseOrderController::class, 'new'])->name('purchase_orders.new');
        Route::post('/create', [PurchaseOrderController::class, 'create'])->name('purchase_orders.create');
        Route::get('/items/{purchase_order_item}/delete', [PurchaseOrderController::class, 'item_destroy'])->name('purchase_orders.items.destroy');
        Route::get('/{purchase_order}/edit', [PurchaseOrderController::class, 'edit'])->name('purchase_orders.edit');
        Route::post('/{purchase_order}/update', [PurchaseOrderController::class, 'update'])->name('purchase_orders.update');
        Route::get('/{purchase_order}/show', [PurchaseOrderController::class, 'show'])->name('purchase_orders.show');
        Route::get('/live_search', [PurchaseOrderController::class, 'live_search'])->name('purchase_orders.live_search');
        Route::get('/search', [PurchaseOrderController::class, 'search'])->name('purchase_orders.search');
        Route::get('/{purchase_order}/delete', [PurchaseOrderController::class, 'destroy'])->name('purchase_orders.destroy');
        Route::get('/{purchase_order}/new_receipt', [PurchaseOrderController::class, 'new_receipt'])->name('purchase_orders.new_receipt');
        Route::get('/', [PurchaseOrderController::class, 'index'])->name('purchase_orders');
    });
    Route::prefix('purchase_order_items')->group(function () {
        Route::get('/{purchase_order_item}/return', [PurchaseOrderController::class, 'Return'])->name('purchase_orders.return');
        Route::get('/{purchase_order}/returnall', [PurchaseOrderController::class, 'return_all'])->name('purchase_orders.return_all');
        Route::get('/export', [PurchaseOrderController::class, 'export_po_items'])->name('purchase_order_items.export');
    });

    // Clients Routes
    Route::prefix('clients')->group(function () {
        Route::get('/export', [ClientController::class, 'export'])->name('clients.export');
        Route::get('/new', [ClientController::class, 'new'])->name('clients.new');
        Route::post('/create', [ClientController::class, 'create'])->name('clients.create');
        Route::get('/{client}/edit', [ClientController::class, 'edit'])->name('clients.edit');
        Route::post('/{client}/update', [ClientController::class, 'update'])->name('clients.update');
        Route::get('/{client}/delete', [ClientController::class, 'destroy'])->name('clients.destroy');
        Route::get('/{client}/statement', [ClientController::class, 'statement'])->name('clients.statement');
        Route::get('/', [ClientController::class, 'index'])->name('clients');
    });

    // Suppliers Routes
    Route::prefix('suppliers')->group(function () {
        Route::get('/export', [SupplierController::class, 'export'])->name('suppliers.export');
        Route::get('/new', [SupplierController::class, 'new'])->name('suppliers.new');
        Route::post('/create', [SupplierController::class, 'create'])->name('suppliers.create');
        Route::get('/{supplier}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
        Route::post('/{supplier}/update', [SupplierController::class, 'update'])->name('suppliers.update');
        Route::get('/{supplier}/delete', [SupplierController::class, 'destroy'])->name('suppliers.destroy');
        Route::get('/{supplier}/statement', [SupplierController::class, 'statement'])->name('suppliers.statement');
        Route::get('/', [SupplierController::class, 'index'])->name('suppliers');
    });

    // Currency Routes
    Route::prefix('currencies')->group(function () {
        Route::get('/export', [CurrencyController::class, 'export'])->name('currencies.export');
        Route::post('/switch', [CurrencyController::class, 'switch'])->name('currencies.switch');
        Route::get('/{currency}/edit', [CurrencyController::class, 'edit'])->name('currencies.edit');
        Route::post('/{currency}/update', [CurrencyController::class, 'update'])->name('currencies.update');
        Route::get('/', [CurrencyController::class, 'index'])->name('currencies');
    });

    // Taxes Routes
    Route::prefix('taxes')->group(function () {
        Route::get('/export', [TaxController::class, 'export'])->name('taxes.export');
        Route::get('/new', [TaxController::class, 'new'])->name('taxes.new');
        Route::post('/create', [TaxController::class, 'create'])->name('taxes.create');
        Route::get('/{tax}/edit', [TaxController::class, 'edit'])->name('taxes.edit');
        Route::post('/{tax}/update', [TaxController::class, 'update'])->name('taxes.update');
        Route::get('/{tax}/delete', [TaxController::class, 'destroy'])->name('taxes.destroy');
        Route::get('/', [TaxController::class, 'index'])->name('taxes');
    });

    // Accounts Routes
    Route::prefix('accounts')->group(function () {
        Route::get('/export', [AccountController::class, 'export'])->name('accounts.export');
        Route::get('/new', [AccountController::class, 'new'])->name('accounts.new');
        Route::post('/create', [AccountController::class, 'create'])->name('accounts.create');
        Route::get('/statement_of_accounts', [AccountController::class, 'get_statement_of_accounts'])->name('accounts.get_statement_of_accounts');
        Route::post('/statement_of_accounts', [AccountController::class, 'statement_of_accounts'])->name('accounts.statement_of_accounts');
        Route::get('/trial_balance', [AccountController::class, 'get_trial_balance'])->name('accounts.get_trial_balance');
        Route::post('/trial_balance', [AccountController::class, 'trial_balance'])->name('accounts.trial_balance');
        Route::post('/trial_balance/export', [AccountController::class, 'export_trial_balance'])->name('accounts.export_trial_balance');
        Route::post('/closing', [AccountController::class, 'closing'])->name('accounts.closing');
        Route::get('/{account}/edit', [AccountController::class, 'edit'])->name('accounts.edit');
        Route::post('/{account}/update', [AccountController::class, 'update'])->name('accounts.update');
        Route::get('/{account}/delete', [AccountController::class, 'destroy'])->name('accounts.destroy');
        Route::get('/{account}/statement', [AccountController::class, 'statement'])->name('accounts.statement');
        Route::get('/', [AccountController::class, 'index'])->name('accounts');
    });

    // Receipts Routes
    Route::prefix('receipts')->group(function () {
        Route::get('/export', [ReceiptController::class, 'export'])->name('receipts.export');
        Route::get('/new', [ReceiptController::class, 'new'])->name('receipts.new');
        Route::post('/create', [ReceiptController::class, 'create'])->name('receipts.create');
        Route::get('/return', [ReceiptController::class, 'Return'])->name('receipts.return');
        Route::post('/return_save', [ReceiptController::class, 'ReturnSave'])->name('receipts.return_save');
        Route::get('/{receipt}/edit', [ReceiptController::class, 'edit'])->name('receipts.edit');
        Route::post('/{receipt}/update', [ReceiptController::class, 'update'])->name('receipts.update');
        Route::get('/{receipt}/delete', [ReceiptController::class, 'destroy'])->name('receipts.destroy');
        Route::get('/{receipt}/show', [ReceiptController::class, 'show'])->name('receipts.show');
        Route::get('/{receipt}/items', [ReceiptController::class, 'items'])->name('receipts.items');
        Route::get('/', [ReceiptController::class, 'index'])->name('receipts');
    });

    // Payment Routes
    Route::prefix('cash_receipts')->group(function () {
        Route::get('/export', [CashReceiptController::class, 'export'])->name('cash_receipts.export');
        Route::get('/new', [CashReceiptController::class, 'new'])->name('cash_receipts.new');
        Route::post('/create', [CashReceiptController::class, 'create'])->name('cash_receipts.create');
        Route::get('/return', [CashReceiptController::class, 'Return'])->name('cash_receipts.return');
        Route::post('/return_save', [CashReceiptController::class, 'ReturnSave'])->name('cash_receipts.return_save');
        Route::get('/{payment}/edit', [CashReceiptController::class, 'edit'])->name('cash_receipts.edit');
        Route::post('/{payment}/update', [CashReceiptController::class, 'update'])->name('cash_receipts.update');
        Route::get('/{payment}/delete', [CashReceiptController::class, 'destroy'])->name('cash_receipts.destroy');
        Route::get('/{payment}/show', [CashReceiptController::class, 'show'])->name('cash_receipts.show');
        Route::get('/{payment}/items', [CashReceiptController::class, 'items'])->name('cash_receipts.items');
        Route::get('/', [CashReceiptController::class, 'index'])->name('cash_receipts');
    });

    // Invoices Routes
    Route::prefix('invoices')->group(function () {
        Route::get('/export', [InvoiceController::class, 'export'])->name('invoices.export');
        Route::get('/new', [InvoiceController::class, 'new'])->name('invoices.new');
        Route::post('/create', [InvoiceController::class, 'create'])->name('invoices.create');
        Route::get('/return', [InvoiceController::class, 'Return'])->name('invoices.return');
        Route::post('/return_save', [InvoiceController::class, 'ReturnSave'])->name('invoices.return_save');
        Route::get('/{invoice}/edit', [InvoiceController::class, 'edit'])->name('invoices.edit');
        Route::post('/{invoice}/update', [InvoiceController::class, 'update'])->name('invoices.update');
        Route::get('/{invoice}/delete', [InvoiceController::class, 'destroy'])->name('invoices.destroy');
        Route::get('/{invoice}/show', [InvoiceController::class, 'show'])->name('invoices.show');
        Route::get('/{invoice}/items', [InvoiceController::class, 'items'])->name('invoices.items');
        Route::get('/', [InvoiceController::class, 'index'])->name('invoices');
    });

    // Credit Note Routes
    Route::prefix('credit_notes')->group(function () {
        Route::get('/export', [CreditNoteController::class, 'export'])->name('credit_notes.export');
        Route::get('/new', [CreditNoteController::class, 'new'])->name('credit_notes.new');
        Route::post('/create', [CreditNoteController::class, 'create'])->name('credit_notes.create');
        Route::get('/{cdnote}/edit', [CreditNoteController::class, 'edit'])->name('credit_notes.edit');
        Route::post('/{cdnote}/update', [CreditNoteController::class, 'update'])->name('credit_notes.update');
        Route::get('/{cdnote}/delete', [CreditNoteController::class, 'destroy'])->name('credit_notes.destroy');
        Route::get('/{cdnote}/show', [CreditNoteController::class, 'show'])->name('credit_notes.show');
        Route::get('/{cdnote}/items', [CreditNoteController::class, 'items'])->name('credit_notes.items');
        Route::get('/', [CreditNoteController::class, 'index'])->name('credit_notes');
    });

    // Debit Note Routes
    Route::prefix('debit_notes')->group(function () {
        Route::get('/export', [DebitNoteController::class, 'export'])->name('debit_notes.export');
        Route::get('/new', [DebitNoteController::class, 'new'])->name('debit_notes.new');
        Route::post('/create', [DebitNoteController::class, 'create'])->name('debit_notes.create');
        Route::get('/{cdnote}/edit', [DebitNoteController::class, 'edit'])->name('debit_notes.edit');
        Route::post('/{cdnote}/update', [DebitNoteController::class, 'update'])->name('debit_notes.update');
        Route::get('/{cdnote}/delete', [DebitNoteController::class, 'destroy'])->name('debit_notes.destroy');
        Route::get('/{cdnote}/show', [DebitNoteController::class, 'show'])->name('debit_notes.show');
        Route::get('/{cdnote}/items', [DebitNoteController::class, 'items'])->name('debit_notes.items');
        Route::get('/', [DebitNoteController::class, 'index'])->name('debit_notes');
    });

    // Statistics Routes
    Route::prefix('statistics')->group(function () {
        Route::get('/', [StatisticsController::class, 'index'])->name('statistics');
    });

    // Shipments Routes
    Route::prefix('shipments')->group(function () {
        Route::get('/export', [ShipmentController::class, 'export'])->name('shipments.export');
        Route::get('/new', [ShipmentController::class, 'new'])->name('shipments.new');
        Route::post('/create', [ShipmentController::class, 'create'])->name('shipments.create');
        Route::get('/items/{shipment_item}/delete', [ShipmentController::class, 'item_destroy'])->name('shipments.items.destroy');
        Route::get('/{shipment}/edit', [ShipmentController::class, 'edit'])->name('shipments.edit');
        Route::post('/{shipment}/update', [ShipmentController::class, 'update'])->name('shipments.update');
        Route::get('/{shipment}/show', [ShipmentController::class, 'show'])->name('shipments.show');
        Route::get('/{shipment}/delete', [ShipmentController::class, 'destroy'])->name('shipments.destroy');
        Route::get('/', [ShipmentController::class, 'index'])->name('shipments');
    });

    // Expenses Routes
    Route::prefix('expenses')->group(function () {
        Route::get('/export', [ExpenseController::class, 'export'])->name('expenses.export');
        Route::get('/new', [ExpenseController::class, 'new'])->name('expenses.new');
        Route::post('/create', [ExpenseController::class, 'create'])->name('expenses.create');
        Route::get('/{expense}/edit', [ExpenseController::class, 'edit'])->name('expenses.edit');
        Route::post('/{expense}/update', [ExpenseController::class, 'update'])->name('expenses.update');
        Route::get('/{expense}/show', [ExpenseController::class, 'show'])->name('expenses.show');
        Route::get('/{expense}/delete', [ExpenseController::class, 'destroy'])->name('expenses.destroy');
        Route::get('/', [ExpenseController::class, 'index'])->name('expenses');
    });

    // Settings
    Route::get('/settigns', [SettingsController::class, 'index'])->name('settings');
    Route::post('/settings/update', [SettingsController::class, 'update'])->name('settings.update');

    Route::prefix('backup')->group(function () {
        Route::get('/export', [SettingsController::class, 'export'])->name('backup.export');
        Route::post('/import', [SettingsController::class, 'import'])->name('backup.import');
    });

    // Navigation
    Route::post('/navigate', [HomeController::class, 'navigate'])->name('navigate');

    // App
    Route::get('/logout', [HomeController::class, 'custom_logout'])->name('custom_logout');
    Route::get('/', [HomeController::class, 'index'])->name('dashboard');
});
