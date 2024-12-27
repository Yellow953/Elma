<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Client;
use App\Models\Currency;
use App\Models\SO;
use App\Models\SOItem;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\PO;
use App\Models\POItem;
use App\Models\Req;
use App\Models\Item;
use App\Models\JournalVoucher;
use App\Models\LandedCost;
use App\Models\Log;
use App\Models\Payment;
use App\Models\PaymentItem;
use App\Models\Receipt;
use App\Models\ReceiptItem;
use App\Models\Supplier;
use App\Models\Tax;
use App\Models\Transaction;
use App\Models\User;
use App\Models\VOC;
use App\Models\VOCItem;
use App\Models\CDNote;
use App\Models\CDNoteItem;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcellController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:backup.all');
    }

    public function ImportExcell(Request $request, $warehouse)
    {
        $this->validate($request, [
            'excel' => 'required|file|mimes:xls,xlsx'
        ]);
        $the_file = $request->file('excel');

        $spreadsheet = IOFactory::load($the_file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $row_limit = $sheet->getHighestDataRow();
        $row_range = range(2, $row_limit);

        $warehouse = Warehouse::where('name', $warehouse)->firstOrFail();
        $items = $warehouse->items;

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        foreach ($items as $item) {
            $item->delete();
        }

        foreach ($row_range as $row) {
            $item = new Item();
            $item->id = $sheet->getCell('A' . $row)->getValue();
            $item->supplier = $sheet->getCell('B' . $row)->getValue();
            $item->itemcode = $sheet->getCell('C' . $row)->getValue();
            $item->description = ($sheet->getCell('D' . $row)->getValue()) ? ($sheet->getCell('D' . $row)->getValue()) : 'No Description Yet';
            $item->quantity = ($sheet->getCell('E' . $row)->getValue()) ? ($sheet->getCell('E' . $row)->getValue()) : 0;
            $item->leveling = ($sheet->getCell('F' . $row)->getValue()) ? ($sheet->getCell('F' . $row)->getValue()) : 0;
            $item->created_at = $sheet->getCell('G' . $row)->getValue() ?? Carbon::now();

            $item->warehouse_id = $warehouse->id;
            $item->image = '/assets/images/profiles/NoItemImage.png';
            $item->name = 'item' . ($row - 1);
            $item->save();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $log = new Log();
        $log->text = ucwords(auth()->user()->name) . " imported items to " . $warehouse->name . ', datetime :   ' . now();
        $log->save();
        return redirect()->back()->with('info', 'Excell imported successfully!');
    }

    public function ExportExcell($warehouse)
    {
        $warehouse = Warehouse::where('name', $warehouse)->firstOrFail();
        $data = Item::where('warehouse_id', $warehouse->id)->orderBy('itemcode')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Supplier');
        $sheet->setCellValue('C1', 'Item Code');
        $sheet->setCellValue('D1', 'Description');
        $sheet->setCellValue('E1', 'Quantity');
        $sheet->setCellValue('F1', 'Leveling');
        $sheet->setCellValue('G1', 'Created At');

        $rows = 2;

        foreach ($data as $d) {
            $sheet->setCellValue('A' . $rows, $d->id);
            $sheet->setCellValue('B' . $rows, $d->supplier);
            $sheet->setCellValue('C' . $rows, $d->itemcode);
            $sheet->setCellValue('D' . $rows, $d->description);
            $sheet->setCellValue('E' . $rows, $d->quantity);
            $sheet->setCellValue('F' . $rows, $d->leveling);
            $sheet->setCellValue('G' . $rows, $d->created_at ?? Carbon::now());
            $rows++;
        }

        $fileName = $warehouse->name . ".xls";
        $writer = new Xls($spreadsheet);
        $writer->save($fileName);
        header("Content-Type: application/xls");
        header("Content-Disposition: attachement; filename: " . $fileName);

        return response()->file($fileName);
    }

    public function index()
    {
        return view('backup.index');
    }

    public function ExportUsers()
    {
        $data = User::all();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Name');
        $sheet->setCellValue('C1', 'Email');
        $sheet->setCellValue('D1', 'Role');
        $sheet->setCellValue('E1', 'Phone Number');
        $sheet->setCellValue('F1', 'Location ID');
        $sheet->setCellValue('G1', 'Currency ID');
        $sheet->setCellValue('H1', 'Created At');
        $rows = 2;

        foreach ($data as $d) {
            $sheet->setCellValue('A' . $rows, $d->id);
            $sheet->setCellValue('B' . $rows, $d->name);
            $sheet->setCellValue('C' . $rows, $d->email);
            $sheet->setCellValue('D' . $rows, $d->role);
            $sheet->setCellValue('E' . $rows, $d->phone);
            $sheet->setCellValue('F' . $rows, $d->location_id);
            $sheet->setCellValue('G' . $rows, $d->currency_id);
            $sheet->setCellValue('H' . $rows, $d->created_at ?? Carbon::now());
            $rows++;
        }

        $fileName = "Users.xls";
        $writer = new Xls($spreadsheet);
        $writer->save($fileName);
        header("Content-Type: application/xls");
        header("Content-Disposition: attachement; filename: " . $fileName);
        return response()->file($fileName);
    }

    public function ExportLogs()
    {
        $data = Log::all();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Text');
        $sheet->setCellValue('B1', 'Created At');
        $rows = 2;

        foreach ($data as $d) {
            $sheet->setCellValue('A' . $rows, $d->text);
            $sheet->setCellValue('B' . $rows, $d->created_at ?? Carbon::now());
            $rows++;
        }

        $fileName = "Logs.xls";
        $writer = new Xls($spreadsheet);
        $writer->save($fileName);
        header("Content-Type: application/xls");
        header("Content-Disposition: attachement; filename: " . $fileName);
        return response()->file($fileName);
    }

    public function ExportProjects()
    {
        $data = Project::all();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Name');
        $sheet->setCellValue('C1', 'Number');
        $sheet->setCellValue('D1', 'Status');
        $sheet->setCellValue('E1', 'Delivery Date');
        $sheet->setCellValue('F1', 'Warehouse ID');
        $sheet->setCellValue('G1', 'Client ID');
        $sheet->setCellValue('H1', 'Created At');
        $rows = 2;

        foreach ($data as $d) {
            $sheet->setCellValue('A' . $rows, $d->id);
            $sheet->setCellValue('B' . $rows, $d->name);
            $sheet->setCellValue('C' . $rows, $d->number ?? '');
            $sheet->setCellValue('D' . $rows, $d->status);
            $sheet->setCellValue('E' . $rows, $d->delivery_date);
            $sheet->setCellValue('F' . $rows, $d->warehouse_id ?? '');
            $sheet->setCellValue('G' . $rows, $d->client_id ?? '');
            $sheet->setCellValue('H' . $rows, $d->created_at ?? Carbon::now());
            $rows++;
        }

        $fileName = "Projects.xls";
        $writer = new Xls($spreadsheet);
        $writer->save($fileName);
        header("Content-Type: application/xls");
        header("Content-Disposition: attachement; filename: " . $fileName);
        return response()->file($fileName);
    }

    public function ExportItems()
    {
        $data = Item::all();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Name');
        $sheet->setCellValue('C1', 'ItemCode');
        $sheet->setCellValue('D1', 'Description');
        $sheet->setCellValue('E1', 'Quantity');
        $sheet->setCellValue('F1', 'Unit Cost');
        $sheet->setCellValue('G1', 'Unit Price');
        $sheet->setCellValue('H1', 'Leveling');
        $sheet->setCellValue('I1', 'Warehouse ID');
        $sheet->setCellValue('J1', 'Type');
        $sheet->setCellValue('K1', 'Inventory Account ID');
        $sheet->setCellValue('L1', 'Cost of Sales Account ID');
        $sheet->setCellValue('M1', 'Sales Account ID');
        $sheet->setCellValue('N1', 'Created At');

        $rows = 2;

        foreach ($data as $d) {
            $sheet->setCellValue('A' . $rows, $d->id);
            $sheet->setCellValue('B' . $rows, $d->name);
            $sheet->setCellValue('C' . $rows, $d->itemcode);
            $sheet->setCellValue('D' . $rows, $d->description);
            $sheet->setCellValue('E' . $rows, $d->quantity);
            $sheet->setCellValue('F' . $rows, $d->unit_cost);
            $sheet->setCellValue('G' . $rows, $d->unit_price);
            $sheet->setCellValue('H' . $rows, $d->leveling);
            $sheet->setCellValue('I' . $rows, $d->warehouse_id);
            $sheet->setCellValue('J' . $rows, $d->type);
            $sheet->setCellValue('K' . $rows, $d->inventory_account_id);
            $sheet->setCellValue('L' . $rows, $d->cost_of_sales_account_id);
            $sheet->setCellValue('M' . $rows, $d->sales_account_id);
            $sheet->setCellValue('N' . $rows, $d->created_at ?? Carbon::now());
            $rows++;
        }

        $fileName = "Items.xls";
        $writer = new Xls($spreadsheet);
        $writer->save($fileName);
        header("Content-Type: application/xls");
        header("Content-Disposition: attachement; filename: " . $fileName);

        return response()->file($fileName);
    }

    public function ExportSOS()
    {
        $data = SO::all();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Name');
        $sheet->setCellValue('C1', 'Project ID');
        $sheet->setCellValue('D1', 'Technician');
        $sheet->setCellValue('E1', 'Job Number');
        $sheet->setCellValue('F1', 'Description');
        $sheet->setCellValue('G1', 'Date');
        $rows = 2;

        foreach ($data as $d) {
            $sheet->setCellValue('A' . $rows, $d->id);
            $sheet->setCellValue('B' . $rows, $d->name);
            $sheet->setCellValue('C' . $rows, $d->project_id);
            $sheet->setCellValue('D' . $rows, $d->technician ?? '');
            $sheet->setCellValue('E' . $rows, $d->job_number ?? '');
            $sheet->setCellValue('F' . $rows, $d->description ?? '');
            $sheet->setCellValue('G' . $rows, $d->date ?? Carbon::now());
            $rows++;
        }

        $fileName = "SOS.xls";
        $writer = new Xls($spreadsheet);
        $writer->save($fileName);
        header("Content-Type: application/xls");
        header("Content-Disposition: attachement; filename: " . $fileName);
        return response()->file($fileName);
    }

    public function ExportSOItems()
    {
        $data = SOItem::all();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'SO ID');
        $sheet->setCellValue('C1', 'Item ID');
        $sheet->setCellValue('D1', 'Quantity');
        $sheet->setCellValue('E1', 'Created At');
        $rows = 2;

        foreach ($data as $d) {
            $sheet->setCellValue('A' . $rows, $d->id);
            $sheet->setCellValue('B' . $rows, $d->so_id);
            $sheet->setCellValue('C' . $rows, $d->item_id);
            $sheet->setCellValue('D' . $rows, $d->quantity);
            $sheet->setCellValue('E' . $rows, $d->created_at ?? Carbon::now());
            $rows++;
        }

        $fileName = "SO_items.xls";
        $writer = new Xls($spreadsheet);
        $writer->save($fileName);
        header("Content-Type: application/xls");
        header("Content-Disposition: attachement; filename: " . $fileName);
        return response()->file($fileName);
    }

    public function ExportPOS()
    {
        $data = PO::all();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Name');
        $sheet->setCellValue('C1', 'Supplier ID');
        $sheet->setCellValue('D1', 'Description');
        $sheet->setCellValue('E1', 'Date');
        $rows = 2;

        foreach ($data as $d) {
            $sheet->setCellValue('A' . $rows, $d->id);
            $sheet->setCellValue('B' . $rows, $d->name);
            $sheet->setCellValue('C' . $rows, $d->supplier_id ?? '');
            $sheet->setCellValue('D' . $rows, $d->description ?? '');
            $sheet->setCellValue('E' . $rows, $d->date ?? Carbon::now());

            $rows++;
        }

        $fileName = "POS.xls";
        $writer = new Xls($spreadsheet);
        $writer->save($fileName);
        header("Content-Type: application/xls");
        header("Content-Disposition: attachement; filename: " . $fileName);
        return response()->file($fileName);
    }

    public function ExportPOItems()
    {
        $data = POItem::all();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'PO ID');
        $sheet->setCellValue('C1', 'Item ID');
        $sheet->setCellValue('D1', 'Quantity');
        $sheet->setCellValue('E1', 'Created At');
        $rows = 2;

        foreach ($data as $d) {
            $sheet->setCellValue('A' . $rows, $d->id);
            $sheet->setCellValue('B' . $rows, $d->po_id);
            $sheet->setCellValue('C' . $rows, $d->item_id);
            $sheet->setCellValue('D' . $rows, $d->quantity);
            $sheet->setCellValue('E' . $rows, $d->created_at);
            $rows++;
        }

        $fileName = "PO_items.xls";
        $writer = new Xls($spreadsheet);
        $writer->save($fileName);
        header("Content-Type: application/xls");
        header("Content-Disposition: attachement; filename: " . $fileName);
        return response()->file($fileName);
    }

    public function ExportSuppliers()
    {
        $data = Supplier::all();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Name');
        $sheet->setCellValue('C1', 'Email');
        $sheet->setCellValue('D1', 'Contact Person');
        $sheet->setCellValue('E1', 'Address');
        $sheet->setCellValue('F1', 'VAT Number');
        $sheet->setCellValue('G1', 'Country');
        $sheet->setCellValue('H1', 'Phone Number');
        $sheet->setCellValue('I1', 'Tax ID');
        $sheet->setCellValue('J1', 'Currency ID');
        $sheet->setCellValue('K1', 'Account ID');
        $sheet->setCellValue('L1', 'Payable Account ID');
        $sheet->setCellValue('M1', 'Created At');
        $rows = 2;

        foreach ($data as $d) {
            $sheet->setCellValue('A' . $rows, $d->id);
            $sheet->setCellValue('B' . $rows, $d->name);
            $sheet->setCellValue('C' . $rows, $d->email);
            $sheet->setCellValue('D' . $rows, $d->contact_person);
            $sheet->setCellValue('E' . $rows, $d->address);
            $sheet->setCellValue('F' . $rows, $d->vat_number);
            $sheet->setCellValue('G' . $rows, $d->country);
            $sheet->setCellValue('H' . $rows, $d->phone);
            $sheet->setCellValue('I' . $rows, $d->tax_id);
            $sheet->setCellValue('J' . $rows, $d->currency_id);
            $sheet->setCellValue('K' . $rows, $d->account_id);
            $sheet->setCellValue('L' . $rows, $d->payable_account_id);
            $sheet->setCellValue('M' . $rows, $d->created_at ?? Carbon::now());

            $rows++;
        }

        $fileName = "Suppliers.xls";
        $writer = new Xls($spreadsheet);
        $writer->save($fileName);
        header("Content-Type: application/xls");
        header("Content-Disposition: attachement; filename: " . $fileName);
        return response()->file($fileName);
    }

    public function ExportClients()
    {
        $data = Client::all();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Name');
        $sheet->setCellValue('C1', 'Email');
        $sheet->setCellValue('D1', 'Address');
        $sheet->setCellValue('E1', 'VAT Number');
        $sheet->setCellValue('F1', 'Phone Number');
        $sheet->setCellValue('G1', 'Tax ID');
        $sheet->setCellValue('H1', 'Currency ID');
        $sheet->setCellValue('I1', 'Account ID');
        $sheet->setCellValue('J1', 'Receivable Account ID');
        $sheet->setCellValue('K1', 'Created At');
        $rows = 2;

        foreach ($data as $d) {
            $sheet->setCellValue('A' . $rows, $d->id);
            $sheet->setCellValue('B' . $rows, $d->name);
            $sheet->setCellValue('C' . $rows, $d->email);
            $sheet->setCellValue('D' . $rows, $d->address);
            $sheet->setCellValue('E' . $rows, $d->vat_number);
            $sheet->setCellValue('F' . $rows, $d->phone);
            $sheet->setCellValue('G' . $rows, $d->tax_id);
            $sheet->setCellValue('H' . $rows, $d->currency_id);
            $sheet->setCellValue('I' . $rows, $d->account_id);
            $sheet->setCellValue('J' . $rows, $d->receivable_account_id);
            $sheet->setCellValue('K' . $rows, $d->created_at ?? Carbon::now());

            $rows++;
        }

        $fileName = "Clients.xls";
        $writer = new Xls($spreadsheet);
        $writer->save($fileName);
        header("Content-Type: application/xls");
        header("Content-Disposition: attachement; filename: " . $fileName);
        return response()->file($fileName);
    }

    public function ExportAccounts()
    {
        $data = Account::all();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Account Number');
        $sheet->setCellValue('C1', 'Account Description');
        $sheet->setCellValue('D1', 'Account Type');
        $sheet->setCellValue('E1', 'Currency ID');
        $sheet->setCellValue('F1', 'Created At');
        $rows = 2;

        foreach ($data as $d) {
            $sheet->setCellValue('A' . $rows, $d->id);
            $sheet->setCellValue('B' . $rows, $d->account_number);
            $sheet->setCellValue('C' . $rows, $d->account_description);
            $sheet->setCellValue('D' . $rows, $d->type);
            $sheet->setCellValue('E' . $rows, $d->currency_id);
            $sheet->setCellValue('F' . $rows, $d->created_at);
            $rows++;
        }

        $fileName = "Accounts.xls";
        $writer = new Xls($spreadsheet);
        $writer->save($fileName);
        header("Content-Type: application/xls");
        header("Content-Disposition: attachement; filename: " . $fileName);
        return response()->file($fileName);
    }

    public function ExportJVs()
    {
        $data = JournalVoucher::all();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'User ID');
        $sheet->setCellValue('C1', 'Currency ID');
        $sheet->setCellValue('D1', 'Foreign Currency ID');
        $sheet->setCellValue('E1', 'rate');
        $sheet->setCellValue('F1', 'Date');
        $sheet->setCellValue('G1', 'Description');
        $sheet->setCellValue('H1', 'Source');
        $sheet->setCellValue('I1', 'Status');
        $sheet->setCellValue('J1', 'Batch');
        $sheet->setCellValue('K1', 'Created At');
        $rows = 2;

        foreach ($data as $d) {
            $sheet->setCellValue('A' . $rows, $d->id);
            $sheet->setCellValue('B' . $rows, $d->user_id);
            $sheet->setCellValue('C' . $rows, $d->currency_id);
            $sheet->setCellValue('D' . $rows, $d->foreign_currecy_id);
            $sheet->setCellValue('E' . $rows, $d->rate);
            $sheet->setCellValue('F' . $rows, $d->date);
            $sheet->setCellValue('G' . $rows, $d->description);
            $sheet->setCellValue('H' . $rows, $d->source);
            $sheet->setCellValue('I' . $rows, $d->status);
            $sheet->setCellValue('J' . $rows, $d->batch);
            $sheet->setCellValue('K' . $rows, $d->created_at);

            $rows++;
        }

        $fileName = "JournalVoucher.xls";
        $writer = new Xls($spreadsheet);
        $writer->save($fileName);
        header("Content-Type: application/xls");
        header("Content-Disposition: attachement; filename: " . $fileName);
        return response()->file($fileName);
    }

    public function ExportTransactions()
    {
        $data = Transaction::all();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Journal Voucher ID');
        $sheet->setCellValue('C1', 'User ID');
        $sheet->setCellValue('D1', 'Account ID');
        $sheet->setCellValue('E1', 'Currency ID');
        $sheet->setCellValue('F1', 'Debit');
        $sheet->setCellValue('G1', 'Credit');
        $sheet->setCellValue('H1', 'Balance');
        $sheet->setCellValue('I1', 'Foreign Currency ID');
        $sheet->setCellValue('J1', 'Foreign Debit');
        $sheet->setCellValue('K1', 'Foreign Credit');
        $sheet->setCellValue('L1', 'Foreign Balance');
        $sheet->setCellValue('M1', 'Rate');
        $sheet->setCellValue('N1', 'Hidden');
        $sheet->setCellValue('O1', 'Created At');

        $rows = 2;

        foreach ($data as $d) {
            $sheet->setCellValue('A' . $rows, $d->id);
            $sheet->setCellValue('B' . $rows, $d->journal_voucher_id);
            $sheet->setCellValue('C' . $rows, $d->user_id);
            $sheet->setCellValue('D' . $rows, $d->account_id);
            $sheet->setCellValue('E' . $rows, $d->currency_id);
            $sheet->setCellValue('F' . $rows, $d->debit);
            $sheet->setCellValue('G' . $rows, $d->credit);
            $sheet->setCellValue('H' . $rows, $d->balance);
            $sheet->setCellValue('I' . $rows, $d->foreign_currecy_id);
            $sheet->setCellValue('J' . $rows, $d->foreign_debit);
            $sheet->setCellValue('K' . $rows, $d->foreign_credit);
            $sheet->setCellValue('L' . $rows, $d->foreign_balance);
            $sheet->setCellValue('M' . $rows, $d->rate);
            $sheet->setCellValue('N' . $rows, $d->hidden);
            $sheet->setCellValue('O' . $rows, $d->created_at);
            $rows++;
        }

        $fileName = "Transactions.xls";
        $writer = new Xls($spreadsheet);
        $writer->save($fileName);
        header("Content-Type: application/xls");
        header("Content-Disposition: attachement; filename: " . $fileName);
        return response()->file($fileName);
    }

    public function ExportTaxes()
    {
        $data = Tax::all();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Name');
        $sheet->setCellValue('C1', 'Rate');
        $sheet->setCellValue('D1', 'Account ID');
        $sheet->setCellValue('E1', 'Created At');

        $rows = 2;

        foreach ($data as $d) {
            $sheet->setCellValue('A' . $rows, $d->id);
            $sheet->setCellValue('B' . $rows, $d->name);
            $sheet->setCellValue('C' . $rows, $d->rate);
            $sheet->setCellValue('D' . $rows, $d->account_id);
            $sheet->setCellValue('E' . $rows, $d->created_at);
            $rows++;
        }

        $fileName = "Taxes.xls";
        $writer = new Xls($spreadsheet);
        $writer->save($fileName);
        header("Content-Type: application/xls");
        header("Content-Disposition: attachement; filename: " . $fileName);
        return response()->file($fileName);
    }

    public function ExportCurrencies()
    {
        $data = Currency::all();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Code');
        $sheet->setCellValue('C1', 'Name');
        $sheet->setCellValue('D1', 'Symbol');
        $sheet->setCellValue('E1', 'Rate');
        $sheet->setCellValue('F1', 'Created At');

        $rows = 2;

        foreach ($data as $d) {
            $sheet->setCellValue('A' . $rows, $d->id);
            $sheet->setCellValue('B' . $rows, $d->code);
            $sheet->setCellValue('C' . $rows, $d->name);
            $sheet->setCellValue('D' . $rows, $d->symbol);
            $sheet->setCellValue('E' . $rows, $d->rate);
            $sheet->setCellValue('F' . $rows, $d->created_at);

            $rows++;
        }

        $fileName = "Currencies.xls";
        $writer = new Xls($spreadsheet);
        $writer->save($fileName);
        header("Content-Type: application/xls");
        header("Content-Disposition: attachement; filename: " . $fileName);
        return response()->file($fileName);
    }

    public function ExportCDNotes()
    {
        $data = CDNote::all();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'CDNote Number');
        $sheet->setCellValue('C1', 'Supplier ID');
        $sheet->setCellValue('D1', 'Client ID');
        $sheet->setCellValue('E1', 'Description');
        $sheet->setCellValue('F1', 'Date');
        $sheet->setCellValue('G1', 'Currency ID');
        $sheet->setCellValue('H1', 'Foreign Currency ID');
        $sheet->setCellValue('I1', 'Rate');
        $sheet->setCellValue('J1', 'Type');
        $sheet->setCellValue('K1', 'Journal Voucher ID');
        $sheet->setCellValue('L1', 'Created At');

        $rows = 2;

        foreach ($data as $d) {
            $sheet->setCellValue('A' . $rows, $d->id);
            $sheet->setCellValue('B' . $rows, $d->cdnote_number);
            $sheet->setCellValue('C' . $rows, $d->supplier_id);
            $sheet->setCellValue('D' . $rows, $d->client_id);
            $sheet->setCellValue('E' . $rows, $d->description);
            $sheet->setCellValue('F' . $rows, $d->date);
            $sheet->setCellValue('G' . $rows, $d->currency_id);
            $sheet->setCellValue('H' . $rows, $d->foreign_currency_id);
            $sheet->setCellValue('I' . $rows, $d->rate);
            $sheet->setCellValue('J' . $rows, $d->type);
            $sheet->setCellValue('K' . $rows, $d->journal_voucher_id);
            $sheet->setCellValue('L' . $rows, $d->created_at);

            $rows++;
        }

        $fileName = "CDNote.xls";
        $writer = new Xls($spreadsheet);
        $writer->save($fileName);
        header("Content-Type: application/xls");
        header("Content-Disposition: attachement; filename: " . $fileName);
        return response()->file($fileName);
    }

    public function ExportCDNoteItems()
    {
        $data = CDNoteItem::all();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'CDNote ID');
        $sheet->setCellValue('C1', 'Account ID');
        $sheet->setCellValue('D1', 'Amount');
        $sheet->setCellValue('E1', 'Created At');
        $rows = 2;

        foreach ($data as $d) {
            $sheet->setCellValue('A' . $rows, $d->id);
            $sheet->setCellValue('B' . $rows, $d->cdnote_id);
            $sheet->setCellValue('C' . $rows, $d->account_id);
            $sheet->setCellValue('D' . $rows, $d->amount);
            $sheet->setCellValue('E' . $rows, $d->created_at);
            $rows++;
        }

        $fileName = "Credit / Debit Note Items.xls";
        $writer = new Xls($spreadsheet);
        $writer->save($fileName);
        header("Content-Type: application/xls");
        header("Content-Disposition: attachement; filename: " . $fileName);
        return response()->file($fileName);
    }

    public function ExportReceipts()
    {
        $data = Receipt::all();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Receipt Number');
        $sheet->setCellValue('C1', 'Supplier Invoice');
        $sheet->setCellValue('D1', 'Supplier ID');
        $sheet->setCellValue('E1', 'Tax ID');
        $sheet->setCellValue('F1', 'Currency ID');
        $sheet->setCellValue('G1', 'Foreign Currency ID');
        $sheet->setCellValue('H1', 'Rate');
        $sheet->setCellValue('I1', 'Journal VoucherID');
        $sheet->setCellValue('J1', 'Date');
        $sheet->setCellValue('K1', 'Type');
        $sheet->setCellValue('L1', 'Created At');

        $rows = 2;

        foreach ($data as $d) {
            $sheet->setCellValue('A' . $rows, $d->id);
            $sheet->setCellValue('B' . $rows, $d->receipt_number);
            $sheet->setCellValue('C' . $rows, $d->supplier_invoice);
            $sheet->setCellValue('D' . $rows, $d->supplier_id);
            $sheet->setCellValue('E' . $rows, $d->tax_id);
            $sheet->setCellValue('F' . $rows, $d->currency_id);
            $sheet->setCellValue('G' . $rows, $d->foreign_currency_id);
            $sheet->setCellValue('H' . $rows, $d->rate);
            $sheet->setCellValue('I' . $rows, $d->journal_voucher_id);
            $sheet->setCellValue('J' . $rows, $d->date);
            $sheet->setCellValue('K' . $rows, $d->type);
            $sheet->setCellValue('L' . $rows, $d->created_at);

            $rows++;
        }

        $fileName = "Receipts.xls";
        $writer = new Xls($spreadsheet);
        $writer->save($fileName);
        header("Content-Type: application/xls");
        header("Content-Disposition: attachement; filename: " . $fileName);
        return response()->file($fileName);
    }

    public function ExportReceiptItems()
    {
        $data = ReceiptItem::all();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Receipt ID');
        $sheet->setCellValue('C1', 'Item ID');
        $sheet->setCellValue('D1', 'Quantity');
        $sheet->setCellValue('E1', 'Unit Cost');
        $sheet->setCellValue('F1', 'Total Cost');
        $sheet->setCellValue('G1', 'Vat');
        $sheet->setCellValue('H1', 'Rate');
        $sheet->setCellValue('I1', 'Total Cost After Vat');
        $sheet->setCellValue('J1', 'Total After Landed Cost');
        $sheet->setCellValue('K1', 'Total Foreign Cost');
        $sheet->setCellValue('L1', 'Created At');

        $rows = 2;

        foreach ($data as $d) {
            $sheet->setCellValue('A' . $rows, $d->id);
            $sheet->setCellValue('B' . $rows, $d->receipt_id);
            $sheet->setCellValue('C' . $rows, $d->item_id);
            $sheet->setCellValue('D' . $rows, $d->quantity);
            $sheet->setCellValue('E' . $rows, $d->unit_cost);
            $sheet->setCellValue('F' . $rows, $d->total_cost);
            $sheet->setCellValue('G' . $rows, $d->vat);
            $sheet->setCellValue('H' . $rows, $d->rate);
            $sheet->setCellValue('I' . $rows, $d->total_cost_after_vat);
            $sheet->setCellValue('J' . $rows, $d->total_after_landed_cost);
            $sheet->setCellValue('K' . $rows, $d->total_foreign_cost);
            $sheet->setCellValue('L' . $rows, $d->created_at);
            $rows++;
        }

        $fileName = "ReceiptItems.xls";
        $writer = new Xls($spreadsheet);
        $writer->save($fileName);
        header("Content-Type: application/xls");
        header("Content-Disposition: attachement; filename: " . $fileName);
        return response()->file($fileName);
    }

    public function ExportLandedCosts()
    {
        $data = LandedCost::all();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Name');
        $sheet->setCellValue('C1', 'Receipt ID');
        $sheet->setCellValue('D1', 'Supplier ID');
        $sheet->setCellValue('E1', 'Currency ID');
        $sheet->setCellValue('F1', 'Amount');
        $sheet->setCellValue('G1', 'Rate');
        $sheet->setCellValue('H1', 'Date');
        $sheet->setCellValue('I1', 'Created At');

        $rows = 2;

        foreach ($data as $d) {
            $sheet->setCellValue('A' . $rows, $d->id);
            $sheet->setCellValue('B' . $rows, $d->name);
            $sheet->setCellValue('C' . $rows, $d->receipt_id);
            $sheet->setCellValue('D' . $rows, $d->supplier_id);
            $sheet->setCellValue('E' . $rows, $d->currency_id);
            $sheet->setCellValue('F' . $rows, $d->amount);
            $sheet->setCellValue('G' . $rows, $d->rate);
            $sheet->setCellValue('H' . $rows, $d->date);
            $sheet->setCellValue('I' . $rows, $d->created_at);
            $rows++;
        }

        $fileName = "LandedCosts.xls";
        $writer = new Xls($spreadsheet);
        $writer->save($fileName);
        header("Content-Type: application/xls");
        header("Content-Disposition: attachement; filename: " . $fileName);
        return response()->file($fileName);
    }

    public function ExportVOCs()
    {
        $data = VOC::all();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'VOC Number');
        $sheet->setCellValue('C1', 'Supplier ID');
        $sheet->setCellValue('D1', 'Supplier Invoice');
        $sheet->setCellValue('E1', 'Date');
        $sheet->setCellValue('F1', 'Description');
        $sheet->setCellValue('G1', 'Tax ID');
        $sheet->setCellValue('H1', 'Currency ID');
        $sheet->setCellValue('I1', 'Foreign Currency ID');
        $sheet->setCellValue('J1', 'Rate');
        $sheet->setCellValue('K1', 'Type');
        $sheet->setCellValue('L1', 'Journal Voucher ID');
        $sheet->setCellValue('M1', 'Created At');

        $rows = 2;

        foreach ($data as $d) {
            $sheet->setCellValue('A' . $rows, $d->id);
            $sheet->setCellValue('B' . $rows, $d->voc_number);
            $sheet->setCellValue('C' . $rows, $d->supplier_id);
            $sheet->setCellValue('D' . $rows, $d->supplier_invoice);
            $sheet->setCellValue('E' . $rows, $d->date);
            $sheet->setCellValue('F' . $rows, $d->description);
            $sheet->setCellValue('G' . $rows, $d->tax_id);
            $sheet->setCellValue('H' . $rows, $d->currency_id);
            $sheet->setCellValue('I' . $rows, $d->foreign_currency_id);
            $sheet->setCellValue('J' . $rows, $d->rate);
            $sheet->setCellValue('K' . $rows, $d->type);
            $sheet->setCellValue('L' . $rows, $d->journal_voucher_id);
            $sheet->setCellValue('M' . $rows, $d->created_at);

            $rows++;
        }

        $fileName = "VOCs.xls";
        $writer = new Xls($spreadsheet);
        $writer->save($fileName);
        header("Content-Type: application/xls");
        header("Content-Disposition: attachement; filename: " . $fileName);
        return response()->file($fileName);
    }

    public function ExportVOCItems()
    {
        $data = VOCItem::all();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'VOC ID');
        $sheet->setCellValue('C1', 'Account ID');
        $sheet->setCellValue('D1', 'Amount');
        $sheet->setCellValue('E1', 'Tax');
        $sheet->setCellValue('F1', 'Total');
        $sheet->setCellValue('G1', 'Created At');

        $rows = 2;

        foreach ($data as $d) {
            $sheet->setCellValue('A' . $rows, $d->id);
            $sheet->setCellValue('B' . $rows, $d->voc_id);
            $sheet->setCellValue('C' . $rows, $d->account_id);
            $sheet->setCellValue('D' . $rows, $d->amount);
            $sheet->setCellValue('E' . $rows, $d->vat);
            $sheet->setCellValue('F' . $rows, $d->total);
            $sheet->setCellValue('G' . $rows, $d->created_at);
            $rows++;
        }

        $fileName = "VOCItems.xls";
        $writer = new Xls($spreadsheet);
        $writer->save($fileName);
        header("Content-Type: application/xls");
        header("Content-Disposition: attachement; filename: " . $fileName);
        return response()->file($fileName);
    }

    public function ExportPayments()
    {
        $data = Payment::all();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Payment Number');
        $sheet->setCellValue('C1', 'Supplier ID');
        $sheet->setCellValue('D1', 'Client ID');
        $sheet->setCellValue('E1', 'Description');
        $sheet->setCellValue('F1', 'Date');
        $sheet->setCellValue('G1', 'Currency ID');
        $sheet->setCellValue('H1', 'Foreign Currency ID');
        $sheet->setCellValue('I1', 'Rate');
        $sheet->setCellValue('J1', 'Type');
        $sheet->setCellValue('K1', 'Journal Voucher ID');
        $sheet->setCellValue('L1', 'Created At');

        $rows = 2;

        foreach ($data as $d) {
            $sheet->setCellValue('A' . $rows, $d->id);
            $sheet->setCellValue('B' . $rows, $d->payment_number);
            $sheet->setCellValue('C' . $rows, $d->supplier_id);
            $sheet->setCellValue('D' . $rows, $d->client_id);
            $sheet->setCellValue('E' . $rows, $d->description);
            $sheet->setCellValue('F' . $rows, $d->date);
            $sheet->setCellValue('G' . $rows, $d->currency_id);
            $sheet->setCellValue('H' . $rows, $d->foreign_currency_id);
            $sheet->setCellValue('I' . $rows, $d->rate);
            $sheet->setCellValue('J' . $rows, $d->type);
            $sheet->setCellValue('K' . $rows, $d->journal_voucher_id);
            $sheet->setCellValue('L' . $rows, $d->created_at);

            $rows++;
        }

        $fileName = "Payments.xls";
        $writer = new Xls($spreadsheet);
        $writer->save($fileName);
        header("Content-Type: application/xls");
        header("Content-Disposition: attachement; filename: " . $fileName);
        return response()->file($fileName);
    }

    public function ExportPaymentItems()
    {
        $data = PaymentItem::all();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Payment ID');
        $sheet->setCellValue('C1', 'Account ID');
        $sheet->setCellValue('D1', 'Amount');
        $sheet->setCellValue('E1', 'Created At');
        $rows = 2;

        foreach ($data as $d) {
            $sheet->setCellValue('A' . $rows, $d->id);
            $sheet->setCellValue('B' . $rows, $d->payment_id);
            $sheet->setCellValue('C' . $rows, $d->account_id);
            $sheet->setCellValue('D' . $rows, $d->amount);
            $sheet->setCellValue('E' . $rows, $d->created_at);
            $rows++;
        }

        $fileName = "PaymentItems.xls";
        $writer = new Xls($spreadsheet);
        $writer->save($fileName);
        header("Content-Type: application/xls");
        header("Content-Disposition: attachement; filename: " . $fileName);
        return response()->file($fileName);
    }

    public function ExportInvoices()
    {
        $data = Invoice::all();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Invoice Number');
        $sheet->setCellValue('C1', 'Client ID');
        $sheet->setCellValue('D1', 'Currency ID');
        $sheet->setCellValue('E1', 'Foreign Currency ID');
        $sheet->setCellValue('F1', 'Rate');
        $sheet->setCellValue('G1', 'Tax ID');
        $sheet->setCellValue('H1', 'Date');
        $sheet->setCellValue('I1', 'Journal Voucher ID');
        $sheet->setCellValue('J1', 'Type');
        $sheet->setCellValue('K1', 'Created At');

        $rows = 2;

        foreach ($data as $d) {
            $sheet->setCellValue('A' . $rows, $d->id);
            $sheet->setCellValue('B' . $rows, $d->invoice_number);
            $sheet->setCellValue('C' . $rows, $d->client_id);
            $sheet->setCellValue('D' . $rows, $d->currency_id);
            $sheet->setCellValue('E' . $rows, $d->foreign_currency_id);
            $sheet->setCellValue('F' . $rows, $d->rate);
            $sheet->setCellValue('G' . $rows, $d->tax_id);
            $sheet->setCellValue('H' . $rows, $d->date);
            $sheet->setCellValue('I' . $rows, $d->journal_voucher_id);
            $sheet->setCellValue('J' . $rows, $d->type);
            $sheet->setCellValue('K' . $rows, $d->created_at);

            $rows++;
        }

        $fileName = "Invoices.xls";
        $writer = new Xls($spreadsheet);
        $writer->save($fileName);
        header("Content-Type: application/xls");
        header("Content-Disposition: attachement; filename: " . $fileName);
        return response()->file($fileName);
    }

    public function ExportInvoiceItems()
    {
        $data = InvoiceItem::all();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Invoice ID');
        $sheet->setCellValue('C1', 'Item ID');
        $sheet->setCellValue('D1', 'Quantity');
        $sheet->setCellValue('E1', 'Unit Cost');
        $sheet->setCellValue('F1', 'Total Cost');
        $sheet->setCellValue('G1', 'Unit Price');
        $sheet->setCellValue('H1', 'Total Price');
        $sheet->setCellValue('I1', 'Vat');
        $sheet->setCellValue('J1', 'Rate');
        $sheet->setCellValue('K1', 'Total Price After Vat');
        $sheet->setCellValue('L1', 'Total Foreign Price');
        $sheet->setCellValue('M1', 'Created At');

        $rows = 2;

        foreach ($data as $d) {
            $sheet->setCellValue('A' . $rows, $d->id);
            $sheet->setCellValue('B' . $rows, $d->invoice_id);
            $sheet->setCellValue('C' . $rows, $d->item_id);
            $sheet->setCellValue('D' . $rows, $d->quantity);
            $sheet->setCellValue('E' . $rows, $d->unit_cost);
            $sheet->setCellValue('F' . $rows, $d->total_cost);
            $sheet->setCellValue('G' . $rows, $d->unit_price);
            $sheet->setCellValue('H' . $rows, $d->total_price);
            $sheet->setCellValue('I' . $rows, $d->vat);
            $sheet->setCellValue('J' . $rows, $d->rate);
            $sheet->setCellValue('K' . $rows, $d->total_price_after_vat);
            $sheet->setCellValue('L' . $rows, $d->total_foreign_price);
            $sheet->setCellValue('M' . $rows, $d->created_at);

            $rows++;
        }

        $fileName = "InvoiceItems.xls";
        $writer = new Xls($spreadsheet);
        $writer->save($fileName);
        header("Content-Type: application/xls");
        header("Content-Disposition: attachement; filename: " . $fileName);
        return response()->file($fileName);
    }

    public function ImportUsers(Request $request)
    {
        $this->validate($request, [
            'users' => 'required|file|mimes:xls,xlsx'
        ]);
        $the_file = $request->file('users');

        $spreadsheet = IOFactory::load($the_file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $row_limit = $sheet->getHighestDataRow();
        $row_range = range(2, $row_limit);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();

        foreach ($row_range as $row) {
            $user = new User();
            $user->id = $sheet->getCell('A' . $row)->getValue();
            $user->name = $sheet->getCell('B' . $row)->getValue();
            $user->email = $sheet->getCell('C' . $row)->getValue();
            $user->role = $sheet->getCell('D' . $row)->getValue();
            $user->phone = $sheet->getCell('E' . $row)->getValue();
            $user->location_id = $sheet->getCell('F' . $row)->getValue();
            $user->currency_id = $sheet->getCell('G' . $row)->getValue();
            $user->created_at = Carbon::parse($sheet->getCell('H' . $row)->getValue()) ?? Carbon::now();
            $user->image = "/assets/images/profiles/NoProfile.png";
            $user->password = Hash::make('password');
            $user->save();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $log = new Log();
        $log->text = ucwords(auth()->user()->name) . " imported all users, datetime :   " . now();
        $log->save();
        return redirect()->back()->with('success', 'Users imported successfully!');
    }

    public function ImportLogs(Request $request)
    {
        $this->validate($request, [
            'logs' => 'required|file|mimes:xls,xlsx'
        ]);
        $the_file = $request->file('logs');

        $spreadsheet = IOFactory::load($the_file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $row_limit = $sheet->getHighestDataRow();
        $row_range = range(2, $row_limit);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Log::truncate();

        foreach ($row_range as $row) {
            $log = new Log();
            $log->text = $sheet->getCell('A' . $row)->getValue();
            $log->created_at = Carbon::parse($sheet->getCell('B' . $row)->getValue()) ?? Carbon::now();
            $log->save();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $log = new Log();
        $log->text = ucwords(auth()->user()->name) . " imported all logs, datetime :   " . now();
        $log->save();
        return redirect()->back()->with('success', 'Logs imported successfully!');
    }

    public function ImportItems(Request $request)
    {
        $this->validate($request, [
            'items' => 'required|file|mimes:xls,xlsx'
        ]);
        $the_file = $request->file('items');

        $spreadsheet = IOFactory::load($the_file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $row_limit = $sheet->getHighestDataRow();
        $row_range = range(2, $row_limit);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Item::truncate();

        foreach ($row_range as $row) {
            $item = new Item();
            $item->id = $sheet->getCell('A' . $row)->getValue();
            $item->name = $sheet->getCell('B' . $row)->getValue();
            $item->itemcode = $sheet->getCell('C' . $row)->getValue();
            $item->description = $sheet->getCell('D' . $row)->getValue() ?? 'No Description Yet';
            $item->quantity = $sheet->getCell('E' . $row)->getValue() ?? 0;
            $item->unit_cost = $sheet->getCell('F' . $row)->getValue() ?? 0;
            $item->unit_price = $sheet->getCell('G' . $row)->getValue() ?? 0;
            $item->leveling = $sheet->getCell('H' . $row)->getValue() ?? 0;
            $item->warehouse_id = $sheet->getCell('I' . $row)->getValue();
            $item->type = $sheet->getCell('J' . $row)->getValue();
            $item->inventory_account_id = $sheet->getCell('K' . $row)->getValue();
            $item->cost_of_sales_account_id = $sheet->getCell('L' . $row)->getValue();
            $item->sales_account_id = $sheet->getCell('M' . $row)->getValue();
            $item->created_at = Carbon::parse($sheet->getCell('N' . $row)->getValue()) ?? Carbon::now();

            $item->image = '/assets/images/profiles/NoItemImage.png';
            $item->save();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $log = new Log();
        $log->text = ucwords(auth()->user()->name) . " imported all items, datetime :   " . now();
        $log->save();
        return redirect()->back()->with('info', 'Items imported successfully!');
    }

    public function ImportSOS(Request $request)
    {
        $this->validate($request, [
            'sos' => 'required|file|mimes:xls,xlsx'
        ]);
        $the_file = $request->file('sos');

        $spreadsheet = IOFactory::load($the_file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $row_limit = $sheet->getHighestDataRow();
        $row_range = range(2, $row_limit);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        SO::truncate();

        foreach ($row_range as $row) {
            $so = new SO();
            $so->id = $sheet->getCell('A' . $row)->getValue();
            $so->name = $sheet->getCell('B' . $row)->getValue();
            $so->project_id = $sheet->getCell('C' . $row)->getValue();
            $so->technician = $sheet->getCell('D' . $row)->getValue() ?? '';
            $so->job_number = $sheet->getCell('E' . $row)->getValue() ?? 0;
            $so->description = $sheet->getCell('F' . $row)->getValue() ?? '';
            $so->date = Carbon::parse($sheet->getCell('G' . $row)->getValue()) ?? Carbon::now();
            $so->save();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $log = new Log();
        $log->text = ucwords(auth()->user()->name) . " imported all SOs, datetime :   " . now();
        $log->save();
        return redirect()->back()->with('success', 'SOs imported successfully!');
    }

    public function ImportSOItems(Request $request)
    {
        $this->validate($request, [
            'so_items' => 'required|file|mimes:xls,xlsx'
        ]);
        $the_file = $request->file('so_items');

        $spreadsheet = IOFactory::load($the_file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $row_limit = $sheet->getHighestDataRow();
        $row_range = range(2, $row_limit);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        SOItem::truncate();

        foreach ($row_range as $row) {
            $so_item = new SOItem();
            $so_item->id = $sheet->getCell('A' . $row)->getValue();
            $so_item->so_id = $sheet->getCell('B' . $row)->getValue();
            $so_item->item_id = $sheet->getCell('C' . $row)->getValue();
            $so_item->quantity = $sheet->getCell('D' . $row)->getValue();
            $so_item->created_at = Carbon::parse($sheet->getCell('E' . $row)->getValue()) ?? Carbon::now();
            $so_item->save();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $log = new Log();
        $log->text = ucwords(auth()->user()->name) . " imported all SO items, datetime :   " . now();
        $log->save();
        return redirect()->back()->with('success', 'SO Items imported successfully!');
    }

    public function ImportPOS(Request $request)
    {
        $this->validate($request, [
            'pos' => 'required|file|mimes:xls,xlsx'
        ]);
        $the_file = $request->file('pos');

        $spreadsheet = IOFactory::load($the_file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $row_limit = $sheet->getHighestDataRow();
        $row_range = range(2, $row_limit);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        PO::truncate();

        foreach ($row_range as $row) {
            $po = new PO();
            $po->id = $sheet->getCell('A' . $row)->getValue();
            $po->name = $sheet->getCell('B' . $row)->getValue();
            $po->supplier_id = $sheet->getCell('C' . $row)->getValue() ?? '';
            $po->description = $sheet->getCell('D' . $row)->getValue() ?? '';
            $po->date = Carbon::parse($sheet->getCell('E' . $row)->getValue()) ?? Carbon::now();
            $po->save();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $log = new Log();
        $log->text = ucwords(auth()->user()->name) . " imported all pos, datetime :   " . now();
        $log->save();
        return redirect()->back()->with('success', 'POS imported successfully!');
    }

    public function ImportPOItems(Request $request)
    {
        $this->validate($request, [
            'po_items' => 'required|file|mimes:xls,xlsx'
        ]);
        $the_file = $request->file('po_items');

        $spreadsheet = IOFactory::load($the_file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $row_limit = $sheet->getHighestDataRow();
        $row_range = range(2, $row_limit);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        POItem::truncate();

        foreach ($row_range as $row) {
            $po_item = new POItem();
            $po_item->id = $sheet->getCell('A' . $row)->getValue();
            $po_item->po_id = $sheet->getCell('B' . $row)->getValue();
            $po_item->item_id = $sheet->getCell('C' . $row)->getValue();
            $po_item->quantity = $sheet->getCell('D' . $row)->getValue();
            $po_item->created_at = Carbon::parse($sheet->getCell('E' . $row)->getValue()) ?? Carbon::now();
            $po_item->save();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $log = new Log();
        $log->text = ucwords(auth()->user()->name) . " imported all po items, datetime :   " . now();
        $log->save();
        return redirect()->back()->with('success', 'PO Items imported successfully!');
    }

    public function ImportSuppliers(Request $request)
    {
        $this->validate($request, [
            'suppliers' => 'required|file|mimes:xls,xlsx'
        ]);
        $the_file = $request->file('suppliers');

        $spreadsheet = IOFactory::load($the_file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $row_limit = $sheet->getHighestDataRow();
        $row_range = range(2, $row_limit);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Supplier::truncate();

        foreach ($row_range as $row) {
            $supplier = new Supplier();
            $supplier->id = $sheet->getCell('A' . $row)->getValue();
            $supplier->name = $sheet->getCell('B' . $row)->getValue();
            $supplier->email = $sheet->getCell('C' . $row)->getValue();
            $supplier->contact_person = $sheet->getCell('D' . $row)->getValue();
            $supplier->address = $sheet->getCell('E' . $row)->getValue();
            $supplier->vat_number = $sheet->getCell('F' . $row)->getValue();
            $supplier->country = $sheet->getCell('G' . $row)->getValue();
            $supplier->phone = $sheet->getCell('H' . $row)->getValue();
            $supplier->tax_id = $sheet->getCell('I' . $row)->getValue();
            $supplier->currency_id = $sheet->getCell('J' . $row)->getValue();
            $supplier->account_id = $sheet->getCell('K' . $row)->getValue();
            $supplier->payable_account_id = $sheet->getCell('L' . $row)->getValue();
            $supplier->created_at = Carbon::parse($sheet->getCell('M' . $row)->getValue()) ?? Carbon::now();

            $supplier->save();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $log = new Log();
        $log->text = ucwords(auth()->user()->name) . " imported all suppliers, datetime : " . now();
        $log->save();
        return redirect()->back()->with('success', 'Suppliers imported successfully!');
    }

    public function ImportClients(Request $request)
    {
        $this->validate($request, [
            'clients' => 'required|file|mimes:xls,xlsx'
        ]);
        $the_file = $request->file('clients');

        $spreadsheet = IOFactory::load($the_file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $row_limit = $sheet->getHighestDataRow();
        $row_range = range(2, $row_limit);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Client::truncate();

        foreach ($row_range as $row) {
            $client = new Client();
            $client->id = $sheet->getCell('A' . $row)->getValue();
            $client->name = $sheet->getCell('B' . $row)->getValue();
            $client->email = $sheet->getCell('C' . $row)->getValue();
            $client->address = $sheet->getCell('D' . $row)->getValue();
            $client->vat_number = $sheet->getCell('E' . $row)->getValue();
            $client->phone = $sheet->getCell('F' . $row)->getValue();
            $client->tax_id = $sheet->getCell('G' . $row)->getValue();
            $client->currency_id = $sheet->getCell('H' . $row)->getValue();
            $client->account_id = $sheet->getCell('I' . $row)->getValue();
            $client->receivable_account_id = $sheet->getCell('J' . $row)->getValue();
            $client->created_at = Carbon::parse($sheet->getCell('K' . $row)->getValue()) ?? Carbon::now();
            $client->save();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $log = new Log();
        $log->text = ucwords(auth()->user()->name) . " imported all clients, datetime : " . now();
        $log->save();
        return redirect()->back()->with('success', 'Clients imported successfully!');
    }

    public function ImportAccounts(Request $request)
    {
        $this->validate($request, [
            'accounts' => 'required|file|mimes:xls,xlsx'
        ]);
        $the_file = $request->file('accounts');

        $spreadsheet = IOFactory::load($the_file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $row_limit = $sheet->getHighestDataRow();
        $row_range = range(2, $row_limit);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Account::truncate();

        foreach ($row_range as $row) {
            $account = new Account();
            $account->id = $sheet->getCell('A' . $row)->getValue();
            $account->account_number = $sheet->getCell('B' . $row)->getValue();
            $account->account_description = $sheet->getCell('C' . $row)->getValue();
            $account->type = $sheet->getCell('D' . $row)->getValue();
            $account->currency_id = $sheet->getCell('E' . $row)->getValue();
            $account->created_at = Carbon::parse($sheet->getCell('F' . $row)->getValue()) ?? Carbon::now();
            $account->save();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $log = new Log();
        $log->text = ucwords(auth()->user()->name) . " imported all accounts, datetime : " . now();
        $log->save();
        return redirect()->back()->with('success', 'Accounts imported successfully!');
    }

    public function ImportJVs(Request $request)
    {
        $this->validate($request, [
            'jvs' => 'required|file|mimes:xls,xlsx'
        ]);
        $the_file = $request->file('jvs');

        $spreadsheet = IOFactory::load($the_file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $row_limit = $sheet->getHighestDataRow();
        $row_range = range(2, $row_limit);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        JournalVoucher::truncate();

        foreach ($row_range as $row) {
            $jv = new JournalVoucher();
            $jv->id = $sheet->getCell('A' . $row)->getValue();
            $jv->user_id = $sheet->getCell('B' . $row)->getValue();
            $jv->currency_id = $sheet->getCell('C' . $row)->getValue();
            $jv->foreign_currency_id = $sheet->getCell('D' . $row)->getValue();
            $jv->rate = $sheet->getCell('E' . $row)->getValue();
            $jv->date = $sheet->getCell('F' . $row)->getValue();
            $jv->description = $sheet->getCell('G' . $row)->getValue();
            $jv->source = $sheet->getCell('H' . $row)->getValue();
            $jv->status = $sheet->getCell('I' . $row)->getValue();
            $jv->batch = $sheet->getCell('J' . $row)->getValue();
            $jv->created_at = Carbon::parse($sheet->getCell('K' . $row)->getValue()) ?? Carbon::now();
            $jv->save();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $log = new Log();
        $log->text = ucwords(auth()->user()->name) . " imported all journal vouchers, datetime : " . now();
        $log->save();
        return redirect()->back()->with('success', 'Journal Vouchers imported successfully!');
    }

    public function ImportTransactions(Request $request)
    {
        $this->validate($request, [
            'transactions' => 'required|file|mimes:xls,xlsx'
        ]);
        $the_file = $request->file('transactions');

        $spreadsheet = IOFactory::load($the_file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $row_limit = $sheet->getHighestDataRow();
        $row_range = range(2, $row_limit);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Transaction::truncate();

        foreach ($row_range as $row) {
            $transaction = new Transaction();
            $transaction->id = $sheet->getCell('A' . $row)->getValue();
            $transaction->journal_voucher_id = $sheet->getCell('B' . $row)->getValue();
            $transaction->user_id = $sheet->getCell('C' . $row)->getValue();
            $transaction->account_id = $sheet->getCell('D' . $row)->getValue();
            $transaction->currency_id = $sheet->getCell('E' . $row)->getValue();
            $transaction->debit = $sheet->getCell('F' . $row)->getValue();
            $transaction->credit = $sheet->getCell('G' . $row)->getValue();
            $transaction->balance = $sheet->getCell('H' . $row)->getValue();
            $transaction->foreign_currency_id = $sheet->getCell('I' . $row)->getValue();
            $transaction->foreign_debit = $sheet->getCell('J' . $row)->getValue();
            $transaction->foreign_credit = $sheet->getCell('K' . $row)->getValue();
            $transaction->foreign_balance = $sheet->getCell('L' . $row)->getValue();
            $transaction->rate = $sheet->getCell('M' . $row)->getValue();
            $transaction->hidden = $sheet->getCell('N' . $row)->getValue() ?? false;
            $transaction->created_at = Carbon::parse($sheet->getCell('O' . $row)->getValue()) ?? Carbon::now();
            $transaction->save();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $log = new Log();
        $log->text = ucwords(auth()->user()->name) . " imported all transactions, datetime : " . now();
        $log->save();
        return redirect()->back()->with('success', 'Transactions imported successfully!');
    }

    public function ImportTaxes(Request $request)
    {
        $this->validate($request, [
            'taxes' => 'required|file|mimes:xls,xlsx'
        ]);
        $the_file = $request->file('taxes');

        $spreadsheet = IOFactory::load($the_file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $row_limit = $sheet->getHighestDataRow();
        $row_range = range(2, $row_limit);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Tax::truncate();

        foreach ($row_range as $row) {
            $tax = new Tax();
            $tax->id = $sheet->getCell('A' . $row)->getValue();
            $tax->name = $sheet->getCell('B' . $row)->getValue();
            $tax->rate = $sheet->getCell('C' . $row)->getValue();
            $tax->account_id = $sheet->getCell('D' . $row)->getValue();
            $tax->created_at = Carbon::parse($sheet->getCell('E' . $row)->getValue()) ?? Carbon::now();
            $tax->save();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $log = new Log();
        $log->text = ucwords(auth()->user()->name) . " imported all taxes, datetime : " . now();
        $log->save();
        return redirect()->back()->with('success', 'Taxes imported successfully!');
    }

    public function ImportCurrencies(Request $request)
    {
        $this->validate($request, [
            'currencies' => 'required|file|mimes:xls,xlsx'
        ]);
        $the_file = $request->file('currencies');

        $spreadsheet = IOFactory::load($the_file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $row_limit = $sheet->getHighestDataRow();
        $row_range = range(2, $row_limit);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Currency::truncate();

        foreach ($row_range as $row) {
            $currency = new Currency();
            $currency->id = $sheet->getCell('A' . $row)->getValue();
            $currency->code = $sheet->getCell('B' . $row)->getValue();
            $currency->name = $sheet->getCell('C' . $row)->getValue();
            $currency->symbol = $sheet->getCell('D' . $row)->getValue();
            $currency->rate = $sheet->getCell('E' . $row)->getValue();
            $currency->created_at = Carbon::parse($sheet->getCell('F' . $row)->getValue()) ?? Carbon::now();
            $currency->save();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $log = new Log();
        $log->text = ucwords(auth()->user()->name) . " imported all currencies, datetime : " . now();
        $log->save();
        return redirect()->back()->with('success', 'Currencies imported successfully!');
    }

    public function ImportCDNotes(Request $request)
    {
        $this->validate($request, [
            'cdnotes' => 'required|file|mimes:xls,xlsx'
        ]);
        $the_file = $request->file('cdnotes');

        $spreadsheet = IOFactory::load($the_file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $row_limit = $sheet->getHighestDataRow();
        $row_range = range(2, $row_limit);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        CDNote::truncate();

        foreach ($row_range as $row) {
            $cdnote = new CDNote();
            $cdnote->id = $sheet->getCell('A' . $row)->getValue();
            $cdnote->cdnote_number = $sheet->getCell('B' . $row)->getValue();
            $cdnote->supplier_id = $sheet->getCell('C' . $row)->getValue();
            $cdnote->client_id = $sheet->getCell('D' . $row)->getValue();
            $cdnote->description = $sheet->getCell('E' . $row)->getValue();
            $cdnote->date = $sheet->getCell('F' . $row)->getValue();
            $cdnote->currency_id = $sheet->getCell('G' . $row)->getValue();
            $cdnote->foreign_currency_id = $sheet->getCell('H' . $row)->getValue();
            $cdnote->rate = $sheet->getCell('I' . $row)->getValue();
            $cdnote->type = $sheet->getCell('J' . $row)->getValue();
            $cdnote->journal_voucher_id = $sheet->getCell('K' . $row)->getValue();
            $cdnote->created_at = Carbon::parse($sheet->getCell('L' . $row)->getValue()) ?? Carbon::now();
            $cdnote->save();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $log = new Log();
        $log->text = ucwords(auth()->user()->name) . " imported all credit / debit notes, datetime : " . now();
        $log->save();
        return redirect()->back()->with('success', 'Credit / Debit Notes imported successfully!');
    }

    public function ImportCDNoteItems(Request $request)
    {
        $this->validate($request, [
            'cdnotes' => 'required|file|mimes:xls,xlsx'
        ]);
        $the_file = $request->file('cdnotes');

        $spreadsheet = IOFactory::load($the_file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $row_limit = $sheet->getHighestDataRow();
        $row_range = range(2, $row_limit);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        CDNote::truncate();

        foreach ($row_range as $row) {
            $cdnote_item = new CDNoteItem();
            $cdnote_item->id = $sheet->getCell('A' . $row)->getValue();
            $cdnote_item->cdnote_id = $sheet->getCell('B' . $row)->getValue();
            $cdnote_item->account_id = $sheet->getCell('C' . $row)->getValue();
            $cdnote_item->amount = $sheet->getCell('D' . $row)->getValue();
            $cdnote_item->created_at = Carbon::parse($sheet->getCell('E' . $row)->getValue()) ?? Carbon::now();
            $cdnote_item->save();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $log = new Log();
        $log->text = ucwords(auth()->user()->name) . " imported all credit / debit note items, datetime : " . now();
        $log->save();
        return redirect()->back()->with('success', 'Credit / Debit Note Items imported successfully!');
    }

    public function ImportReceipts(Request $request)
    {
        $this->validate($request, [
            'receipts' => 'required|file|mimes:xls,xlsx'
        ]);
        $the_file = $request->file('receipts');

        $spreadsheet = IOFactory::load($the_file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $row_limit = $sheet->getHighestDataRow();
        $row_range = range(2, $row_limit);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Receipt::truncate();

        foreach ($row_range as $row) {
            $receipt = new Receipt();
            $receipt->id = $sheet->getCell('A' . $row)->getValue();
            $receipt->receipt_number = $sheet->getCell('B' . $row)->getValue();
            $receipt->supplier_invoice = $sheet->getCell('C' . $row)->getValue();
            $receipt->supplier_id = $sheet->getCell('D' . $row)->getValue();
            $receipt->tax_id = $sheet->getCell('E' . $row)->getValue();
            $receipt->currency_id = $sheet->getCell('F' . $row)->getValue();
            $receipt->foreign_currency_id = $sheet->getCell('G' . $row)->getValue();
            $receipt->rate = $sheet->getCell('H' . $row)->getValue();
            $receipt->journal_voucher_id = $sheet->getCell('I' . $row)->getValue();
            $receipt->date = $sheet->getCell('J' . $row)->getValue();
            $receipt->type = $sheet->getCell('K' . $row)->getValue();
            $receipt->created_at = Carbon::parse($sheet->getCell('L' . $row)->getValue()) ?? Carbon::now();
            $receipt->save();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $log = new Log();
        $log->text = ucwords(auth()->user()->name) . " imported all receipts, datetime : " . now();
        $log->save();
        return redirect()->back()->with('success', 'Receipts imported successfully!');
    }

    public function ImportReceiptItems(Request $request)
    {
        $this->validate($request, [
            'receipt_items' => 'required|file|mimes:xls,xlsx'
        ]);
        $the_file = $request->file('receipt_items');

        $spreadsheet = IOFactory::load($the_file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $row_limit = $sheet->getHighestDataRow();
        $row_range = range(2, $row_limit);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        ReceiptItem::truncate();

        foreach ($row_range as $row) {
            $receipt_item = new ReceiptItem();
            $receipt_item->id = $sheet->getCell('A' . $row)->getValue();
            $receipt_item->receipt_id = $sheet->getCell('B' . $row)->getValue();
            $receipt_item->item_id = $sheet->getCell('C' . $row)->getValue();
            $receipt_item->quantity = $sheet->getCell('D' . $row)->getValue();
            $receipt_item->unit_cost = $sheet->getCell('E' . $row)->getValue();
            $receipt_item->total_cost = $sheet->getCell('F' . $row)->getValue();
            $receipt_item->vat = $sheet->getCell('G' . $row)->getValue();
            $receipt_item->rate = $sheet->getCell('H' . $row)->getValue();
            $receipt_item->total_cost_after_vat = $sheet->getCell('I' . $row)->getValue();
            $receipt_item->total_after_landed_cost = $sheet->getCell('J' . $row)->getValue();
            $receipt_item->total_foreign_cost = $sheet->getCell('K' . $row)->getValue();
            $receipt_item->created_at = Carbon::parse($sheet->getCell('L' . $row)->getValue()) ?? Carbon::now();
            $receipt_item->save();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $log = new Log();
        $log->text = ucwords(auth()->user()->name) . " imported all receipt items, datetime : " . now();
        $log->save();
        return redirect()->back()->with('success', 'ReceiptItems imported successfully!');
    }

    public function ImportLandedCosts(Request $request)
    {
        $this->validate($request, [
            'landed_costs' => 'required|file|mimes:xls,xlsx'
        ]);
        $the_file = $request->file('landed_costs');

        $spreadsheet = IOFactory::load($the_file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $row_limit = $sheet->getHighestDataRow();
        $row_range = range(2, $row_limit);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        LandedCost::truncate();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Name');
        $sheet->setCellValue('C1', 'Receipt ID');
        $sheet->setCellValue('D1', 'Supplier ID');
        $sheet->setCellValue('E1', 'Currency ID');
        $sheet->setCellValue('F1', 'Amount');
        $sheet->setCellValue('G1', 'Rate');
        $sheet->setCellValue('H1', 'Date');
        $sheet->setCellValue('I1', 'Created At');

        foreach ($row_range as $row) {
            $landed_cost = new LandedCost();
            $landed_cost->id = $sheet->getCell('A' . $row)->getValue();
            $landed_cost->name = $sheet->getCell('B' . $row)->getValue();
            $landed_cost->receipt_id = $sheet->getCell('C' . $row)->getValue();
            $landed_cost->supplier_id = $sheet->getCell('D' . $row)->getValue();
            $landed_cost->currency_id = $sheet->getCell('E' . $row)->getValue();
            $landed_cost->amount = $sheet->getCell('F' . $row)->getValue();
            $landed_cost->rate = $sheet->getCell('G' . $row)->getValue();
            $landed_cost->date = $sheet->getCell('H' . $row)->getValue();
            $landed_cost->created_at = Carbon::parse($sheet->getCell('I' . $row)->getValue()) ?? Carbon::now();
            $landed_cost->save();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $log = new Log();
        $log->text = ucwords(auth()->user()->name) . " imported all landed costs, datetime : " . now();
        $log->save();
        return redirect()->back()->with('success', 'LandedCosts imported successfully!');
    }

    public function ImportVOCs(Request $request)
    {
        $this->validate($request, [
            'vocs' => 'required|file|mimes:xls,xlsx'
        ]);
        $the_file = $request->file('vocs');

        $spreadsheet = IOFactory::load($the_file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $row_limit = $sheet->getHighestDataRow();
        $row_range = range(2, $row_limit);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        VOC::truncate();

        foreach ($row_range as $row) {
            $voc = new VOC();
            $voc->id = $sheet->getCell('A' . $row)->getValue();
            $voc->voc_number = $sheet->getCell('B' . $row)->getValue();
            $voc->supplier_id = $sheet->getCell('C' . $row)->getValue();
            $voc->supplier_invoice = $sheet->getCell('D' . $row)->getValue();
            $voc->date = $sheet->getCell('E' . $row)->getValue();
            $voc->description = $sheet->getCell('F' . $row)->getValue();
            $voc->tax_id = $sheet->getCell('G' . $row)->getValue();
            $voc->currency_id = $sheet->getCell('H' . $row)->getValue();
            $voc->foreign_currency_id = $sheet->getCell('I' . $row)->getValue();
            $voc->rate = $sheet->getCell('J' . $row)->getValue();
            $voc->type = $sheet->getCell('K' . $row)->getValue();
            $voc->journal_voucher_id = $sheet->getCell('L' . $row)->getValue();
            $voc->created_at = Carbon::parse($sheet->getCell('M' . $row)->getValue()) ?? Carbon::now();
            $voc->save();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $log = new Log();
        $log->text = ucwords(auth()->user()->name) . " imported all vocs, datetime : " . now();
        $log->save();
        return redirect()->back()->with('success', 'VOCs imported successfully!');
    }

    public function ImportVOCItems(Request $request)
    {
        $this->validate($request, [
            'voc_items' => 'required|file|mimes:xls,xlsx'
        ]);
        $the_file = $request->file('voc_items');

        $spreadsheet = IOFactory::load($the_file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $row_limit = $sheet->getHighestDataRow();
        $row_range = range(2, $row_limit);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        VOCItem::truncate();

        foreach ($row_range as $row) {
            $voc_item = new VOCItem();
            $voc_item->id = $sheet->getCell('A' . $row)->getValue();
            $voc_item->voc_id = $sheet->getCell('B' . $row)->getValue();
            $voc_item->account_id = $sheet->getCell('C' . $row)->getValue();
            $voc_item->amount = $sheet->getCell('D' . $row)->getValue();
            $voc_item->tax = $sheet->getCell('E' . $row)->getValue();
            $voc_item->total = $sheet->getCell('F' . $row)->getValue();
            $voc_item->created_at = Carbon::parse($sheet->getCell('G' . $row)->getValue()) ?? Carbon::now();
            $voc_item->save();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $log = new Log();
        $log->text = ucwords(auth()->user()->name) . " imported all voc items, datetime : " . now();
        $log->save();
        return redirect()->back()->with('success', 'VOCItems imported successfully!');
    }

    public function ImportPayments(Request $request)
    {
        $this->validate($request, [
            'payments' => 'required|file|mimes:xls,xlsx'
        ]);
        $the_file = $request->file('payments');

        $spreadsheet = IOFactory::load($the_file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $row_limit = $sheet->getHighestDataRow();
        $row_range = range(2, $row_limit);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Payment::truncate();

        foreach ($row_range as $row) {
            $payment = new Payment();
            $payment->id = $sheet->getCell('A' . $row)->getValue();
            $payment->payment_number = $sheet->getCell('B' . $row)->getValue();
            $payment->supplier_id = $sheet->getCell('C' . $row)->getValue();
            $payment->client_id = $sheet->getCell('D' . $row)->getValue();
            $payment->description = $sheet->getCell('E' . $row)->getValue();
            $payment->date = $sheet->getCell('F' . $row)->getValue();
            $payment->currency_id = $sheet->getCell('G' . $row)->getValue();
            $payment->foreign_currency_id = $sheet->getCell('H' . $row)->getValue();
            $payment->rate = $sheet->getCell('I' . $row)->getValue();
            $payment->type = $sheet->getCell('J' . $row)->getValue();
            $payment->journal_voucher_id = $sheet->getCell('K' . $row)->getValue();
            $payment->created_at = Carbon::parse($sheet->getCell('L' . $row)->getValue()) ?? Carbon::now();
            $payment->save();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $log = new Log();
        $log->text = ucwords(auth()->user()->name) . " imported all payments, datetime : " . now();
        $log->save();
        return redirect()->back()->with('success', 'Payments imported successfully!');
    }

    public function ImportPaymentItems(Request $request)
    {
        $this->validate($request, [
            'payment_items' => 'required|file|mimes:xls,xlsx'
        ]);
        $the_file = $request->file('payment_items');

        $spreadsheet = IOFactory::load($the_file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $row_limit = $sheet->getHighestDataRow();
        $row_range = range(2, $row_limit);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        PaymentItem::truncate();

        foreach ($row_range as $row) {
            $payment_item = new PaymentItem();
            $payment_item->id = $sheet->getCell('A' . $row)->getValue();
            $payment_item->payment_id = $sheet->getCell('B' . $row)->getValue();
            $payment_item->account_id = $sheet->getCell('C' . $row)->getValue();
            $payment_item->amount = $sheet->getCell('D' . $row)->getValue();
            $payment_item->created_at = Carbon::parse($sheet->getCell('E' . $row)->getValue()) ?? Carbon::now();
            $payment_item->save();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $log = new Log();
        $log->text = ucwords(auth()->user()->name) . " imported all payment items, datetime : " . now();
        $log->save();
        return redirect()->back()->with('success', 'PaymentItems imported successfully!');
    }

    public function ImportInvoices(Request $request)
    {
        $this->validate($request, [
            'invoices' => 'required|file|mimes:xls,xlsx'
        ]);
        $the_file = $request->file('invoices');

        $spreadsheet = IOFactory::load($the_file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $row_limit = $sheet->getHighestDataRow();
        $row_range = range(2, $row_limit);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Invoice::truncate();

        foreach ($row_range as $row) {
            $invoice = new Invoice();
            $invoice->id = $sheet->getCell('A' . $row)->getValue();
            $invoice->invoice_number = $sheet->getCell('B' . $row)->getValue();
            $invoice->client_id = $sheet->getCell('C' . $row)->getValue();
            $invoice->currency_id = $sheet->getCell('D' . $row)->getValue();
            $invoice->foreign_id = $sheet->getCell('E' . $row)->getValue();
            $invoice->rate = $sheet->getCell('F' . $row)->getValue();
            $invoice->tax_id = $sheet->getCell('G' . $row)->getValue();
            $invoice->date = $sheet->getCell('H' . $row)->getValue();
            $invoice->journal_voucher_id = $sheet->getCell('I' . $row)->getValue();
            $invoice->type = $sheet->getCell('J' . $row)->getValue();
            $invoice->created_at = Carbon::parse($sheet->getCell('K' . $row)->getValue()) ?? Carbon::now();
            $invoice->save();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $log = new Log();
        $log->text = ucwords(auth()->user()->name) . " imported all invoices, datetime : " . now();
        $log->save();
        return redirect()->back()->with('success', 'Invoices imported successfully!');
    }

    public function ImportInvoiceItems(Request $request)
    {
        $this->validate($request, [
            'invoice_items' => 'required|file|mimes:xls,xlsx'
        ]);
        $the_file = $request->file('invoice_items');

        $spreadsheet = IOFactory::load($the_file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $row_limit = $sheet->getHighestDataRow();
        $row_range = range(2, $row_limit);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        InvoiceItem::truncate();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Invoice ID');
        $sheet->setCellValue('C1', 'Item ID');
        $sheet->setCellValue('D1', 'Quantity');
        $sheet->setCellValue('E1', 'Unit Cost');
        $sheet->setCellValue('F1', 'Total Cost');
        $sheet->setCellValue('G1', 'Unit Price');
        $sheet->setCellValue('H1', 'Total Price');
        $sheet->setCellValue('I1', 'Vat');
        $sheet->setCellValue('J1', 'Rate');
        $sheet->setCellValue('K1', 'Total Price After Vat');
        $sheet->setCellValue('L1', 'Total Foreign Price');
        $sheet->setCellValue('M1', 'Created At');

        foreach ($row_range as $row) {
            $invoice_item = new InvoiceItem();
            $invoice_item->id = $sheet->getCell('A' . $row)->getValue();
            $invoice_item->invoice_id = $sheet->getCell('B' . $row)->getValue();
            $invoice_item->item_id = $sheet->getCell('C' . $row)->getValue();
            $invoice_item->quantity = $sheet->getCell('D' . $row)->getValue();
            $invoice_item->unit_cost = $sheet->getCell('E' . $row)->getValue();
            $invoice_item->total_cost = $sheet->getCell('F' . $row)->getValue();
            $invoice_item->unit_price = $sheet->getCell('G' . $row)->getValue();
            $invoice_item->total_price = $sheet->getCell('H' . $row)->getValue();
            $invoice_item->vat = $sheet->getCell('I' . $row)->getValue();
            $invoice_item->rate = $sheet->getCell('J' . $row)->getValue();
            $invoice_item->total_price_after_vat = $sheet->getCell('K' . $row)->getValue();
            $invoice_item->total_foreign_price = $sheet->getCell('L' . $row)->getValue();
            $invoice_item->created_at = Carbon::parse($sheet->getCell('M' . $row)->getValue()) ?? Carbon::now();
            $invoice_item->save();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $log = new Log();
        $log->text = ucwords(auth()->user()->name) . " imported all invoice items, datetime : " . now();
        $log->save();
        return redirect()->back()->with('success', 'InvoiceItems imported successfully!');
    }

    public function so_export_items(SO $so)
    {
        $data = SOItem::where('so_id', $so->id)->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Item');
        $sheet->setCellValue('B1', 'Quantity');
        $sheet->setCellValue('C1', 'Created At');
        $rows = 2;

        foreach ($data as $d) {
            $sheet->setCellValue('A' . $rows, $d->item->itemcode);
            $sheet->setCellValue('B' . $rows, $d->quantity);
            $sheet->setCellValue('C' . $rows, Carbon::now());
            $rows++;
        }

        $fileName = $so->name . "_items.xls";
        $writer = new Xls($spreadsheet);
        $writer->save($fileName);
        header("Content-Type: application/xls");
        header("Content-Disposition: attachement; filename: " . $fileName);
        return response()->file($fileName);
    }

    public function so_import_items(SO $so, Request $request)
    {
        $this->validate($request, [
            'file' => 'required|file|mimes:xls,xlsx'
        ]);
        $the_file = $request->file('file');

        $spreadsheet = IOFactory::load($the_file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $row_limit = $sheet->getHighestDataRow();
        $row_range = range(2, $row_limit);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $parts = explode('-', $so->name);
        $warehouse = Warehouse::where("code", $parts[0])->firstOrFail();
        $counter = 0;

        foreach ($row_range as $row) {
            $item = Item::where('itemcode', $sheet->getCell('A' . $row)->getValue())->where('warehouse_id', $warehouse->id)->get()->firstOrFail();

            if ($item == null || $sheet->getCell('B' . $row)->getValue() <= 0 || $item->quantity - $sheet->getCell('B' . $row)->getValue() < 0) {
                continue;
            }

            \App\Models\Request::create([
                'user_id' => auth()->user()->id,
                'item_id' => $item->id,
                'project_id' => $so->project_id,
                'so_id' => $so->id,
                'quantity' => $sheet->getCell('B' . $row)->getValue(),
                'warehouse_id' => $warehouse->id,
                'type' => 2,
                'status' => 0,
                'created_at' => Carbon::now()->addSeconds($counter),
            ]);

            $counter++;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $text = ucwords(auth()->user()->name) . " imported SO items for " . $so->name . ", datetime :   " . now();
        Log::create(['text' => $text]);

        return redirect()->back()->with('success', 'SO Items imported successfully!');
    }

    public function po_export_items(PO $po)
    {
        $data = POItem::where('po_id', $po->id)->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Item');
        $sheet->setCellValue('B1', 'Quantity');
        $sheet->setCellValue('C1', 'Created At');
        $rows = 2;

        foreach ($data as $d) {
            $sheet->setCellValue('A' . $rows, $d->item->itemcode);
            $sheet->setCellValue('B' . $rows, $d->quantity);
            $sheet->setCellValue('C' . $rows, Carbon::now());
            $rows++;
        }

        $fileName = $po->name . "_items.xls";
        $writer = new Xls($spreadsheet);
        $writer->save($fileName);
        header("Content-Type: application/xls");
        header("Content-Disposition: attachement; filename: " . $fileName);
        return response()->file($fileName);
    }

    public function po_import_items(PO $po, Request $request)
    {
        $this->validate($request, [
            'file' => 'required|file|mimes:xls,xlsx'
        ]);
        $the_file = $request->file('file');

        $spreadsheet = IOFactory::load($the_file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $row_limit = $sheet->getHighestDataRow();
        $row_range = range(2, $row_limit);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $parts = explode('-', $po->name);
        $warehouse = Warehouse::where("code", $parts[0])->firstOrFail();
        $counter = 0;

        foreach ($row_range as $row) {
            $item = Item::where('itemcode', $sheet->getCell('A' . $row)->getValue())->where('warehouse_id', $warehouse->id)->get()->firstOrFail();

            if ($item == null || $sheet->getCell('B' . $row)->getValue() <= 0) {
                continue;
            }

            \App\Models\Request::create([
                'user_id' => auth()->user()->id,
                'item_id' => $item->id,
                'po_id' => $po->id,
                'quantity' => $sheet->getCell('B' . $row)->getValue(),
                'warehouse_id' => $warehouse->id,
                'type' => 9,
                'status' => 0,
                'created_at' => Carbon::now()->addSeconds($counter),
            ]);

            $counter++;
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $text = ucwords(auth()->user()->name) . " imported po items for " . $po->name . ", datetime :   " . now();
        Log::create(['text' => $text]);

        return redirect()->back()->with('success', 'PO Items imported successfully!');
    }

    public function export()
    {
        $filePath = public_path('backups/database_backup.sql');

        exec('mysqldump -u' . env('DB_USERNAME') . ' -p' . env('DB_PASSWORD') . ' ' . env('DB_DATABASE') . ' > ' . $filePath);

        return response()->download($filePath)->deleteFileAfterSend(false);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimetypes:text/plain,application/octet-stream',
        ]);

        $file = $request->file('file');

        $sql = file_get_contents($file->getRealPath());

        DB::unprepared($sql);

        return redirect()->back()->with('success', 'Database imported successfully.');
    }
}
