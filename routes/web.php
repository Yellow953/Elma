<?php

// Import Controllers
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\ExcellController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SOController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\POController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\JournalVoucherController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\VOCController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SecondaryImageController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\CashReceiptController;
use App\Http\Controllers\CreditNoteController;
use App\Http\Controllers\DebitNoteController;
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
        Route::get('/new', [UserController::class, 'new'])->name('users.new');
        Route::post('/create', [UserController::class, 'create'])->name('users.create');
        Route::get('/terms', [UserController::class, 'terms'])->name('users.terms');
        Route::post('/terms_agree', [UserController::class, 'terms_agree'])->name('users.terms_agree');
        Route::get('/{user}/delete', [UserController::class, 'destroy'])->name('users.destroy');
        Route::get('/', [UserController::class, 'index'])->name('users');
    });

    // Profile Routes
    Route::prefix('profile')->group(function () {
        Route::get('/{user}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/{user}/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('/{user}/savepassword', [ProfileController::class, 'SavePassword'])->name('profile.SavePassword');
        Route::get('/{user}', [ProfileController::class, 'show'])->name('profile');
    });

    // Item Routes
    Route::prefix('items')->group(function () {
        Route::get('/new', [ItemController::class, 'new'])->name('items.new');
        Route::post('/create', [ItemController::class, 'create'])->name('items.create');
        Route::get('/in/{item}', [ItemController::class, 'In'])->name('items.In');
        Route::post('/in/{item}/save', [ItemController::class, 'InSave'])->name('items.InSave');
        Route::get('/out/{item}', [ItemController::class, 'Out'])->name('items.Out');
        Route::post('/out/{item}/save', [ItemController::class, 'OutSave'])->name('items.OutSave');
        Route::get('/transfer/{item}', [ItemController::class, 'Transfer'])->name('items.Transfer');
        Route::post('/transfer/{item}/save', [ItemController::class, 'TransferSave'])->name('items.TransferSave');
        Route::get('/{item}/edit', [ItemController::class, 'edit'])->name('items.edit');
        Route::post('/{item}/update', [ItemController::class, 'update'])->name('items.update');
        Route::get('/{item}/activity', [ItemController::class, 'activity'])->name('items.activity');
        Route::get('/{item}/barcodes', [ItemController::class, 'barcodes'])->name('items.barcodes');
        Route::post('/track', [ItemController::class, 'track'])->name('items.track');
        Route::get('/track', [ItemController::class, 'track_page'])->name('items.track_page');
        Route::post('/report', [ItemController::class, 'report'])->name('items.report');
        Route::get('/report', [ItemController::class, 'report_page'])->name('items.report_page');
        Route::get('/{item}/report', [ItemController::class, 'item_report'])->name('items.item_report');
        Route::get('/{item}/delete', [ItemController::class, 'destroy'])->name('items.destroy');
        Route::get('/{item}/images', [ItemController::class, 'images'])->name('items.images');
        Route::get('/{warehouse}', [ItemController::class, 'index_warehouse'])->name('items.warehouse');
        Route::get('/', [ItemController::class, 'index'])->name('items');
    });

    // Secondary Images Routes
    Route::prefix('secondary_images')->group(function () {
        Route::post('/create', [SecondaryImageController::class, 'create'])->name('secondary_images.create');
        Route::get('/destroy/{secondary_image}', [SecondaryImageController::class, 'destroy'])->name('secondary_images.destroy');
    });

    // Logs Routes
    Route::prefix('logs')->group(function () {
        Route::get('/{warehouse}', [LogController::class, 'IndividualLogs'])->name('logs.individual');
        Route::get('/', [LogController::class, 'index'])->name('logs');
    });

    // Backup Routes
    Route::prefix('backup')->group(function () {
        // Export Routes
        Route::get('/export/users', [ExcellController::class, 'ExportUsers'])->name('export.users');
        Route::get('/export/logs', [ExcellController::class, 'ExportLogs'])->name('export.logs');
        Route::get('/export/items', [ExcellController::class, 'ExportItems'])->name('export.items');
        Route::get('/export/sos', [ExcellController::class, 'ExportSOS'])->name('export.sos');
        Route::get('/export/so_items', [ExcellController::class, 'ExportSOItems'])->name('export.so_items');
        Route::get('/export/pos', [ExcellController::class, 'ExportPOS'])->name('export.pos');
        Route::get('/export/po_items', [ExcellController::class, 'ExportPOItems'])->name('export.po_items');
        Route::get('/export/tros', [ExcellController::class, 'ExportTROS'])->name('export.tros');
        Route::get('/export/tro_items', [ExcellController::class, 'ExportTROItems'])->name('export.tro_items');
        Route::get('/export/suppliers', [ExcellController::class, 'ExportSuppliers'])->name('export.suppliers');
        Route::get('/export/clients', [ExcellController::class, 'ExportClients'])->name('export.clients');
        Route::get('/export/accounts', [ExcellController::class, 'ExportAccounts'])->name('export.accounts');
        Route::get('/export/jvs', [ExcellController::class, 'ExportJVs'])->name('export.jvs');
        Route::get('/export/transactions', [ExcellController::class, 'ExportTransactions'])->name('export.transactions');
        Route::get('/export/taxes', [ExcellController::class, 'ExportTaxes'])->name('export.taxes');
        Route::get('/export/currencies', [ExcellController::class, 'ExportCurrencies'])->name('export.currencies');
        Route::get('/export/cdnotes', [ExcellController::class, 'ExportCDNotes'])->name('export.cdnotes');
        Route::get('/export/cdnote_items', [ExcellController::class, 'ExportCDNoteItems'])->name('export.cdnote_items');
        Route::get('/export/receipts', [ExcellController::class, 'ExportReceipts'])->name('export.receipts');
        Route::get('/export/receipt_items', [ExcellController::class, 'ExportReceiptItems'])->name('export.receipt_items');
        Route::get('/export/landed_costs', [ExcellController::class, 'ExportLandedCosts'])->name('export.landed_costs');
        Route::get('/export/vocs', [ExcellController::class, 'ExportVOCs'])->name('export.vocs');
        Route::get('/export/voc_items', [ExcellController::class, 'ExportVOCItems'])->name('export.voc_items');
        Route::get('/export/payments', [ExcellController::class, 'ExportPayments'])->name('export.payments');
        Route::get('/export/payment_items', [ExcellController::class, 'ExportPaymentItems'])->name('export.payment_items');
        Route::get('/export/invoices', [ExcellController::class, 'ExportInvoices'])->name('export.invoices');
        Route::get('/export/invoice_items', [ExcellController::class, 'ExportInvoiceItems'])->name('export.invoice_items');
        Route::get('/export', [ExcellController::class, 'export'])->name('backup.export');

        // Import Routes
        Route::post('/import/users', [ExcellController::class, 'ImportUsers'])->name('import.users');
        Route::post('/import/logs', [ExcellController::class, 'ImportLogs'])->name('import.logs');
        Route::post('/import/items', [ExcellController::class, 'ImportItems'])->name('import.items');
        Route::post('/import/sos', [ExcellController::class, 'ImportSOS'])->name('import.sos');
        Route::post('/import/so_items', [ExcellController::class, 'ImportSOItems'])->name('import.so_items');
        Route::post('/import/pos', [ExcellController::class, 'ImportPOS'])->name('import.pos');
        Route::post('/import/po_items', [ExcellController::class, 'ImportPOItems'])->name('import.po_items');
        Route::post('/import/tros', [ExcellController::class, 'ImportTROS'])->name('import.tros');
        Route::post('/import/tro_items', [ExcellController::class, 'ImportTROItems'])->name('import.tro_items');
        Route::post('/import/suppliers', [ExcellController::class, 'ImportSuppliers'])->name('import.suppliers');
        Route::post('/import/clients', [ExcellController::class, 'ImportClients'])->name('import.clients');
        Route::post('/import/accounts', [ExcellController::class, 'ImportAccounts'])->name('import.accounts');
        Route::post('/import/jvs', [ExcellController::class, 'ImportJVs'])->name('import.jvs');
        Route::post('/import/transactions', [ExcellController::class, 'ImportTransactions'])->name('import.transactions');
        Route::post('/import/taxes', [ExcellController::class, 'ImportTaxes'])->name('import.taxes');
        Route::post('/import/currencies', [ExcellController::class, 'ImportCurrencies'])->name('import.currencies');
        Route::post('/import/cdnotes', [ExcellController::class, 'ImportCDNotes'])->name('import.cdnotes');
        Route::post('/import/cdnote_items', [ExcellController::class, 'ImportCDNoteItems'])->name('import.cdnote_items');
        Route::post('/import/receipts', [ExcellController::class, 'ImportReceipts'])->name('import.receipts');
        Route::post('/import/receipt_items', [ExcellController::class, 'ImportReceiptItems'])->name('import.receipt_items');
        Route::post('/import/landed_costs', [ExcellController::class, 'ImportLandedCosts'])->name('import.landed_costs');
        Route::post('/import/vocs', [ExcellController::class, 'ImportVOCs'])->name('import.vocs');
        Route::post('/import/voc_items', [ExcellController::class, 'ImportVOCItems'])->name('import.voc_items');
        Route::post('/import/payments', [ExcellController::class, 'ImportPayments'])->name('import.payments');
        Route::post('/import/payment_items', [ExcellController::class, 'ImportPaymentItems'])->name('import.payment_items');
        Route::post('/import/invoices', [ExcellController::class, 'ImportInvoices'])->name('import.invoices');
        Route::post('/import/invoice_items', [ExcellController::class, 'ImportInvoiceItems'])->name('import.invoice_items');
        Route::post('/import', [ExcellController::class, 'import'])->name('backup.import');

        // index Route
        Route::get('/', [ExcellController::class, 'index'])->name('backup');
    });

    // SOS Routes
    Route::prefix('so')->group(function () {
        Route::get('/', [SOController::class, 'index'])->name('so');
        Route::get('/new', [SOController::class, 'new'])->name('so.new');
        Route::post('/create', [SOController::class, 'create'])->name('so.create');
        Route::get('/{so}/edit', [SOController::class, 'edit'])->name('so.edit');
        Route::post('/{so}/update', [SOController::class, 'update'])->name('so.update');
        Route::get('/{so}/show', [SOController::class, 'show'])->name('so.show');
        Route::get('/{so}/activity', [SOController::class, 'activity'])->name('so.activity');
        Route::post('/{so}/saveitems', [SOController::class, 'SaveItems'])->name('so.SaveItems');
        Route::get('/{so}/print', [SOController::class, 'print'])->name('so.print');
        Route::get('/{so}/display', [SOController::class, 'display'])->name('so.display');
        Route::get('/{so}/additems', [SOController::class, 'AddItems'])->name('so.AddItems');
        Route::get('/{so}/quantities', [SOController::class, 'quantities'])->name('so.quantities');
        Route::get('/live_search', [SOController::class, 'live_search'])->name('so.live_search');
        Route::get('/search', [SOController::class, 'search'])->name('so.search');
        Route::get('/{so}/delete', [SOController::class, 'destroy'])->name('so.destroy');
        Route::get('/{so}/export_items', [ExcellController::class, 'so_export_items'])->name('so.so_export_items');
        Route::post('/{so}/import_items', [ExcellController::class, 'so_import_items'])->name('so.so_import_items');
        Route::get('/{so}/new_invoice', [SOController::class, 'new_invoice'])->name('so.new_invoice');
    });
    Route::prefix('so_items')->group(function () {
        Route::get('/{so_item}/return', [SOController::class, 'Return'])->name('so.return');
        Route::get('/{so}/returnall', [SOController::class, 'return_all'])->name('so.return_all');
    });

    // POS Routes
    Route::prefix('po')->group(function () {
        Route::get('/', [POController::class, 'index'])->name('po');
        Route::get('/new', [POController::class, 'new'])->name('po.new');
        Route::post('/create', [POController::class, 'create'])->name('po.create');
        Route::get('/{po}/edit', [POController::class, 'edit'])->name('po.edit');
        Route::post('/{po}/update', [POController::class, 'update'])->name('po.update');
        Route::get('/{po}/show', [POController::class, 'show'])->name('po.show');
        Route::get('/{po}/activity', [POController::class, 'activity'])->name('po.activity');
        Route::post('/{po}/saveitems', [POController::class, 'SaveItems'])->name('po.SaveItems');
        Route::get('/{po}/print', [POController::class, 'print'])->name('po.print');
        Route::get('/{po}/additems', [POController::class, 'AddItems'])->name('po.AddItems');
        Route::get('/{po}/quantities', [POController::class, 'quantities'])->name('po.quantities');
        Route::get('/live_search', [POController::class, 'live_search'])->name('po.live_search');
        Route::get('/search', [POController::class, 'search'])->name('po.search');
        Route::get('/{po}/delete', [POController::class, 'destroy'])->name('po.destroy');
        Route::get('/{po}/export_items', [ExcellController::class, 'po_export_items'])->name('po.po_export_items');
        Route::post('/{po}/import_items', [ExcellController::class, 'po_import_items'])->name('po.po_import_items');
        Route::get('/{po}/new_receipt', [POController::class, 'new_receipt'])->name('po.new_receipt');
    });
    Route::prefix('po_items')->group(function () {
        Route::get('/{po_item}/return', [POController::class, 'Return'])->name('po.return');
        Route::get('/{po}/returnall', [POController::class, 'return_all'])->name('po.return_all');
    });

    // Clients Routes
    Route::prefix('clients')->group(function () {
        Route::get('/new', [ClientController::class, 'new'])->name('clients.new');
        Route::post('/create', [ClientController::class, 'create'])->name('clients.create');
        Route::get('/{client}/edit', [ClientController::class, 'edit'])->name('clients.edit');
        Route::get('/{client}/projects', [ClientController::class, 'Projects'])->name('clients.projects');
        Route::post('/{client}/update', [ClientController::class, 'update'])->name('clients.update');
        Route::get('/{client}/delete', [ClientController::class, 'destroy'])->name('clients.destroy');
        Route::get('/{client}/statement', [ClientController::class, 'statement'])->name('clients.statement');
        Route::get('/', [ClientController::class, 'index'])->name('clients');
    });

    // Suppliers Routes
    Route::prefix('suppliers')->group(function () {
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
        Route::post('/switch', [CurrencyController::class, 'switch'])->name('currencies.switch');
        Route::get('/{currency}/edit', [CurrencyController::class, 'edit'])->name('currencies.edit');
        Route::post('/{currency}/update', [CurrencyController::class, 'update'])->name('currencies.update');
        Route::get('/', [CurrencyController::class, 'index'])->name('currencies');
    });

    // Taxes Routes
    Route::prefix('taxes')->group(function () {
        Route::get('/new', [TaxController::class, 'new'])->name('taxes.new');
        Route::post('/create', [TaxController::class, 'create'])->name('taxes.create');
        Route::get('/{tax}/edit', [TaxController::class, 'edit'])->name('taxes.edit');
        Route::post('/{tax}/update', [TaxController::class, 'update'])->name('taxes.update');
        Route::get('/{tax}/delete', [TaxController::class, 'destroy'])->name('taxes.destroy');
        Route::get('/', [TaxController::class, 'index'])->name('taxes');
    });

    // Accounts Routes
    Route::prefix('accounts')->group(function () {
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

    // Journal Vouchers Routes
    Route::prefix('journal_vouchers')->group(function () {
        Route::get('/new', [JournalVoucherController::class, 'new'])->name('journal_vouchers.new');
        Route::post('/create', [JournalVoucherController::class, 'create'])->name('journal_vouchers.create');
        Route::post('/batch_post', [JournalVoucherController::class, 'batch_post'])->name('journal_vouchers.batch_post');
        Route::get('/{journal_voucher}/edit', [JournalVoucherController::class, 'edit'])->name('journal_vouchers.edit');
        Route::post('/{journal_voucher}/update', [JournalVoucherController::class, 'update'])->name('journal_vouchers.update');
        Route::get('/{journal_voucher}/delete', [JournalVoucherController::class, 'destroy'])->name('journal_vouchers.destroy');
        Route::get('/{journal_voucher}/show', [JournalVoucherController::class, 'show'])->name('journal_vouchers.show');
        Route::get('/{journal_voucher}/post', [JournalVoucherController::class, 'post'])->name('journal_vouchers.post');
        Route::get('/{journal_voucher}/void', [JournalVoucherController::class, 'void'])->name('journal_vouchers.void');
        Route::get('/{journal_voucher}/backout', [JournalVoucherController::class, 'backout'])->name('journal_vouchers.backout');
        Route::get('/{journal_voucher}/copy', [JournalVoucherController::class, 'copy'])->name('journal_vouchers.copy');
        Route::get('/', [JournalVoucherController::class, 'index'])->name('journal_vouchers');
    });

    // Receipts Routes
    Route::prefix('receipts')->group(function () {
        Route::get('/new', [ReceiptController::class, 'new'])->name('receipts.new');
        Route::post('/create', [ReceiptController::class, 'create'])->name('receipts.create');
        Route::get('/return', [ReceiptController::class, 'Return'])->name('receipts.return');
        Route::post('/return_save', [ReceiptController::class, 'ReturnSave'])->name('receipts.return_save');
        Route::get('/{receipt}/edit', [ReceiptController::class, 'edit'])->name('receipts.edit');
        Route::post('/{receipt}/update', [ReceiptController::class, 'update'])->name('receipts.update');
        Route::get('/{receipt}/delete', [ReceiptController::class, 'destroy'])->name('receipts.destroy');
        Route::get('/{receipt}/show', [ReceiptController::class, 'show'])->name('receipts.show');
        Route::get('/{receipt}/items', [ReceiptController::class, 'items'])->name('receipts.items');
        Route::get('/{receipt}/landed_costs', [ReceiptController::class, 'landed_costs'])->name('receipts.landed_costs');
        Route::get('/', [ReceiptController::class, 'index'])->name('receipts');
    });

    // VOC Routes
    Route::prefix('voc')->group(function () {
        Route::get('/new', [VOCController::class, 'new'])->name('voc.new');
        Route::post('/create', [VOCController::class, 'create'])->name('voc.create');
        Route::get('/return', [VOCController::class, 'Return'])->name('voc.return');
        Route::post('/return_save', [VOCController::class, 'ReturnSave'])->name('voc.return_save');
        Route::get('/{voc}/edit', [VOCController::class, 'edit'])->name('voc.edit');
        Route::post('/{voc}/update', [VOCController::class, 'update'])->name('voc.update');
        Route::get('/{voc}/delete', [VOCController::class, 'destroy'])->name('voc.destroy');
        Route::get('/{voc}/show', [VOCController::class, 'show'])->name('voc.show');
        Route::get('/{voc}/items', [VOCController::class, 'items'])->name('voc.items');
        Route::get('/', [VOCController::class, 'index'])->name('voc');
    });

    // Payment Routes
    Route::prefix('payments')->group(function () {
        Route::get('/new', [PaymentController::class, 'new'])->name('payments.new');
        Route::post('/create', [PaymentController::class, 'create'])->name('payments.create');
        Route::get('/return', [PaymentController::class, 'Return'])->name('payments.return');
        Route::post('/return_save', [PaymentController::class, 'ReturnSave'])->name('payments.return_save');
        Route::get('/{payment}/edit', [PaymentController::class, 'edit'])->name('payments.edit');
        Route::post('/{payment}/update', [PaymentController::class, 'update'])->name('payments.update');
        Route::get('/{payment}/delete', [PaymentController::class, 'destroy'])->name('payments.destroy');
        Route::get('/{payment}/show', [PaymentController::class, 'show'])->name('payments.show');
        Route::get('/{payment}/items', [PaymentController::class, 'items'])->name('payments.items');
        Route::get('/', [PaymentController::class, 'index'])->name('payments');
    });

    // Payment Routes
    Route::prefix('cash_receipts')->group(function () {
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
        Route::get('/inventory/top-selling-products', [StatisticsController::class, 'topSellingProducts'])->name('inventory.topSellingProducts');
        Route::get('/inventory/monthly-turnover-ratio', [StatisticsController::class, 'monthlyTurnoverRatio'])->name('inventory.monthlyTurnoverRatio');
        Route::get('/inventory/stock-out-analysis', [StatisticsController::class, 'stockOutAnalysis'])->name('inventory.stockOutAnalysis');
        Route::get('/inventory/stock-in-analysis', [StatisticsController::class, 'stockInAnalysis'])->name('inventory.stockInAnalysis');
        Route::get('/inventory/dead-stock-analysis', [StatisticsController::class, 'deadStockAnalysis'])->name('inventory.deadStockAnalysis');
        Route::get('/inventory/demand-forecasting', [StatisticsController::class, 'demandForecasting'])->name('inventory.demandForecasting');

        Route::get('/accounting/revenue-expenses', [StatisticsController::class, 'revenueExpenses'])->name('accounting.revenueExpenses');
        Route::get('/accounting/top-customers-suppliers', [StatisticsController::class, 'topCustomersSuppliers'])->name('accounting.topCustomersSuppliers');
        Route::get('/accounting/receivables-distribution', [StatisticsController::class, 'receivablesDistribution'])->name('accounting.receivablesDistribution');
        Route::get('/accounting/payables-distribution', [StatisticsController::class, 'payablesDistribution'])->name('accounting.payablesDistribution');
        Route::get('/accounting/net-profit-margin', [StatisticsController::class, 'netProfitMargin'])->name('accounting.netProfitMargin');
        Route::get('/accounting/stock-valuation', [StatisticsController::class, 'stockValuation'])->name('accounting.stockValuation');

        Route::get('/', [StatisticsController::class, 'index'])->name('statistics');
    });

    // Settings
    Route::get('/setup', [SettingsController::class, 'new'])->name('settings.new');
    Route::post('/setup', [SettingsController::class, 'create'])->name('settings.create');
    Route::post('/company/update', [SettingsController::class, 'update'])->name('company.update');
    Route::post('/company/toggle-allow-past-dates', [SettingsController::class, 'toggle_allow_past_dates'])->name('company.toggle_allow_past_dates');

    // navigation
    Route::post('/navigate', [HomeController::class, 'navigate'])->name('navigate');

    // App
    Route::get('/logout', [HomeController::class, 'custom_logout'])->name('custom_logout');
    Route::get('/', [HomeController::class, 'index'])->name('dashboard');
});
