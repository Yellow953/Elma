@extends('layouts.app')

@section('title', 'backup')

@section('content')
<div class="container-fluid px-2 px-md-4">
    <div class="page-header min-height-300 border-radius-xl mt-4"
        style="background-image: url({{asset('/assets/images/warehouse.png')}});"></div>
    <div class="card card-body mx-1 mx-md-4 mt-n6">
        <h4 class="mt-2">Full Backup</h4>
        <div class="row my-2 ">
            <div class="col-md-6">
                <form action="{{ route('backup.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex flex-row">
                        <input type="file" name="file" required class="input-field">
                        <button type="submit" class="btn btn-info mx-2 py-2 px-3">Import</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <a href="{{ route('backup.export') }}" class="text-center btn btn-info mx-2 py-2 px-3">
                    Export
                </a>
            </div>
        </div>
        <hr>

        <h4>Individual Backup</h4>
        <h5 class="mt-2 text-decoration-underline">Users</h5>
        <small>ps: all the users password will reset to "password"</small>
        <div class="row my-2 ">
            <div class="col-md-6">
                <form action="{{ route('import.users') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex flex-row">
                        <input type="file" name="users" required class="input-field">
                        <button type="submit" class="btn btn-info mx-2 py-2 px-3">Import</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <a href="{{ route('export.users') }}" class="text-center btn btn-info mx-2 py-2 px-3">
                    Export
                </a>
            </div>
        </div>
        <hr>

        <h5 class="mt-2 text-decoration-underline">Logs</h5>
        <div class="row my-2 ">
            <div class="col-md-6">
                <form action="{{ route('import.logs') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex flex-row">
                        <input type="file" name="logs" required class="input-field">
                        <button type="submit" class="btn btn-info mx-2 py-2 px-3">Import</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <a href="{{ route('export.logs') }}" class="text-center btn btn-info mx-2 py-2 px-3">
                    Export
                </a>
            </div>
        </div>
        <hr>

        <h5 class="mt-2 text-decoration-underline">Items</h5>
        <div class="row my-2">
            <div class="col-md-6">
                <form action="{{ route('import.items') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex flex-row">
                        <input type="file" name="items" required class="input-field">
                        <button type="submit" class="btn btn-info mx-2 py-2 px-3">Import All</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <a href="{{ route('export.items') }}" class="text-center btn btn-info mx-2 py-2 px-3">
                    Export All
                </a>
            </div>
        </div>
        <hr>

        <h5 class="mt-2 text-decoration-underline">SOs</h5>
        <div class="row my-2 ">
            <div class="col-md-6">
                <form action="{{ route('import.sos') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex flex-row">
                        <input type="file" name="sos" required class="input-field">
                        <button type="submit" class="btn btn-info mx-2 py-2 px-3">Import</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <a href="{{ route('export.sos') }}" class="text-center btn btn-info mx-2 py-2 px-3">
                    Export
                </a>
            </div>
        </div>
        <h6 class="mt-2">SO Items</h6>
        <div class="row my-2 ">
            <div class="col-md-6">
                <form action="{{ route('import.so_items') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex flex-row">
                        <input type="file" name="so_items" required class="input-field">
                        <button type="submit" class="btn btn-info mx-2 py-2 px-3">Import</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <a href="{{ route('export.so_items') }}" class="text-center btn btn-info mx-2 py-2 px-3">
                    Export
                </a>
            </div>
        </div>
        <hr>

        <h5 class="mt-2 text-decoration-underline">POS</h5>
        <div class="row my-2 ">
            <div class="col-md-6">
                <form action="{{ route('import.pos') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex flex-row">
                        <input type="file" name="pos" required class="input-field">
                        <button type="submit" class="btn btn-info mx-2 py-2 px-3">Import</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <a href="{{ route('export.pos') }}" class="text-center btn btn-info mx-2 py-2 px-3">
                    Export
                </a>
            </div>
        </div>
        <h6 class="mt-2">PO Items</h6>
        <div class="row my-2 ">
            <div class="col-md-6">
                <form action="{{ route('import.po_items') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex flex-row">
                        <input type="file" name="po_items" required class="input-field">
                        <button type="submit" class="btn btn-info mx-2 py-2 px-3">Import</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <a href="{{ route('export.po_items') }}" class="text-center btn btn-info mx-2 py-2 px-3">
                    Export
                </a>
            </div>
        </div>
        <hr>

        <h5 class="mt-2 text-decoration-underline">Supplier</h5>
        <div class="row my-2 ">
            <div class="col-md-6">
                <form action="{{ route('import.suppliers') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex flex-row">
                        <input type="file" name="suppliers" required class="input-field">
                        <button type="submit" class="btn btn-info mx-2 py-2 px-3">Import</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <a href="{{ route('export.suppliers') }}" class="text-center btn btn-info mx-2 py-2 px-3">
                    Export
                </a>
            </div>
        </div>
        <hr>

        <h5 class="mt-2 text-decoration-underline">Clients</h5>
        <div class="row my-2 ">
            <div class="col-md-6">
                <form action="{{ route('import.clients') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex flex-row">
                        <input type="file" name="clients" required class="input-field">
                        <button type="submit" class="btn btn-info mx-2 py-2 px-3">Import</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <a href="{{ route('export.clients') }}" class="text-center btn btn-info mx-2 py-2 px-3">
                    Export
                </a>
            </div>
        </div>
        <hr>

        <h5 class="mt-2 text-decoration-underline">Accounts</h5>
        <div class="row my-2 ">
            <div class="col-md-6">
                <form action="{{ route('import.accounts') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex flex-row">
                        <input type="file" name="accounts" required class="input-field">
                        <button type="submit" class="btn btn-info mx-2 py-2 px-3">Import</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <a href="{{ route('export.accounts') }}" class="text-center btn btn-info mx-2 py-2 px-3">
                    Export
                </a>
            </div>
        </div>
        <hr>

        <h5 class="mt-2 text-decoration-underline">Journal Vouchers</h5>
        <div class="row my-2 ">
            <div class="col-md-6">
                <form action="{{ route('import.jvs') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex flex-row">
                        <input type="file" name="jvs" required class="input-field">
                        <button type="submit" class="btn btn-info mx-2 py-2 px-3">Import</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <a href="{{ route('export.jvs') }}" class="text-center btn btn-info mx-2 py-2 px-3">
                    Export
                </a>
            </div>
        </div>
        <hr>

        <h5 class="mt-2 text-decoration-underline">Transactions</h5>
        <div class="row my-2 ">
            <div class="col-md-6">
                <form action="{{ route('import.transactions') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex flex-row">
                        <input type="file" name="transactions" required class="input-field">
                        <button type="submit" class="btn btn-info mx-2 py-2 px-3">Import</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <a href="{{ route('export.transactions') }}" class="text-center btn btn-info mx-2 py-2 px-3">
                    Export
                </a>
            </div>
        </div>
        <hr>

        <h5 class="mt-2 text-decoration-underline">Taxes</h5>
        <div class="row my-2 ">
            <div class="col-md-6">
                <form action="{{ route('import.taxes') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex flex-row">
                        <input type="file" name="taxes" required class="input-field">
                        <button type="submit" class="btn btn-info mx-2 py-2 px-3">Import</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <a href="{{ route('export.taxes') }}" class="text-center btn btn-info mx-2 py-2 px-3">
                    Export
                </a>
            </div>
        </div>
        <hr>

        <h5 class="mt-2 text-decoration-underline">Currencies</h5>
        <div class="row my-2 ">
            <div class="col-md-6">
                <form action="{{ route('import.currencies') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex flex-row">
                        <input type="file" name="currencies" required class="input-field">
                        <button type="submit" class="btn btn-info mx-2 py-2 px-3">Import</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <a href="{{ route('export.currencies') }}" class="text-center btn btn-info mx-2 py-2 px-3">
                    Export
                </a>
            </div>
        </div>
        <hr>

        <h5 class="mt-2 text-decoration-underline">Receipts</h5>
        <div class="row my-2 ">
            <div class="col-md-6">
                <form action="{{ route('import.receipts') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex flex-row">
                        <input type="file" name="receipts" required class="input-field">
                        <button type="submit" class="btn btn-info mx-2 py-2 px-3">Import</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <a href="{{ route('export.receipts') }}" class="text-center btn btn-info mx-2 py-2 px-3">
                    Export
                </a>
            </div>
        </div>
        <h6 class="mt-2">Receipt Items</h6>
        <div class="row my-2 ">
            <div class="col-md-6">
                <form action="{{ route('import.receipt_items') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex flex-row">
                        <input type="file" name="receipt_items" required class="input-field">
                        <button type="submit" class="btn btn-info mx-2 py-2 px-3">Import</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <a href="{{ route('export.receipt_items') }}" class="text-center btn btn-info mx-2 py-2 px-3">
                    Export
                </a>
            </div>
        </div>
        <h6 class="mt-2">Landed Costs</h6>
        <div class="row my-2 ">
            <div class="col-md-6">
                <form action="{{ route('import.landed_costs') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex flex-row">
                        <input type="file" name="landed_costs" required class="input-field">
                        <button type="submit" class="btn btn-info mx-2 py-2 px-3">Import</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <a href="{{ route('export.landed_costs') }}" class="text-center btn btn-info mx-2 py-2 px-3">
                    Export
                </a>
            </div>
        </div>
        <hr>

        <h5 class="mt-2 text-decoration-underline">VOCs</h5>
        <div class="row my-2 ">
            <div class="col-md-6">
                <form action="{{ route('import.vocs') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex flex-row">
                        <input type="file" name="vocs" required class="input-field">
                        <button type="submit" class="btn btn-info mx-2 py-2 px-3">Import</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <a href="{{ route('export.vocs') }}" class="text-center btn btn-info mx-2 py-2 px-3">
                    Export
                </a>
            </div>
        </div>
        <h6 class="mt-2">VOC Items</h6>
        <div class="row my-2 ">
            <div class="col-md-6">
                <form action="{{ route('import.voc_items') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex flex-row">
                        <input type="file" name="voc_items" required class="input-field">
                        <button type="submit" class="btn btn-info mx-2 py-2 px-3">Import</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <a href="{{ route('export.voc_items') }}" class="text-center btn btn-info mx-2 py-2 px-3">
                    Export
                </a>
            </div>
        </div>
        <hr>

        <h5 class="mt-2 text-decoration-underline">Payments</h5>
        <div class="row my-2 ">
            <div class="col-md-6">
                <form action="{{ route('import.payments') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex flex-row">
                        <input type="file" name="payments" required class="input-field">
                        <button type="submit" class="btn btn-info mx-2 py-2 px-3">Import</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <a href="{{ route('export.payments') }}" class="text-center btn btn-info mx-2 py-2 px-3">
                    Export
                </a>
            </div>
        </div>
        <h6 class="mt-2">Payment Items</h6>
        <div class="row my-2 ">
            <div class="col-md-6">
                <form action="{{ route('import.payment_items') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex flex-row">
                        <input type="file" name="payment_items" required class="input-field">
                        <button type="submit" class="btn btn-info mx-2 py-2 px-3">Import</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <a href="{{ route('export.payment_items') }}" class="text-center btn btn-info mx-2 py-2 px-3">
                    Export
                </a>
            </div>
        </div>
        <hr>

        <h5 class="mt-2 text-decoration-underline">Invoices</h5>
        <div class="row my-2 ">
            <div class="col-md-6">
                <form action="{{ route('import.invoices') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex flex-row">
                        <input type="file" name="invoices" required class="input-field">
                        <button type="submit" class="btn btn-info mx-2 py-2 px-3">Import</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <a href="{{ route('export.invoices') }}" class="text-center btn btn-info mx-2 py-2 px-3">
                    Export
                </a>
            </div>
        </div>
        <h6 class="mt-2">Invoice Items</h6>
        <div class="row my-2 ">
            <div class="col-md-6">
                <form action="{{ route('import.invoice_items') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex flex-row">
                        <input type="file" name="invoice_items" required class="input-field">
                        <button type="submit" class="btn btn-info mx-2 py-2 px-3">Import</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <a href="{{ route('export.invoice_items') }}" class="text-center btn btn-info mx-2 py-2 px-3">
                    Export
                </a>
            </div>
        </div>
        <hr>

        <h5 class="mt-2 text-decoration-underline">Credit/Debit Notes</h5>
        <div class="row my-2 ">
            <div class="col-md-6">
                <form action="{{ route('import.cdnotes') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex flex-row">
                        <input type="file" name="cdnotes" required class="input-field">
                        <button type="submit" class="btn btn-info mx-2 py-2 px-3">Import</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <a href="{{ route('export.cdnotes') }}" class="text-center btn btn-info mx-2 py-2 px-3">
                    Export
                </a>
            </div>
        </div>
        <h6 class="mt-2">Credit/Debit Note Items</h6>
        <div class="row my-2 ">
            <div class="col-md-6">
                <form action="{{ route('import.cdnote_items') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex flex-row">
                        <input type="file" name="cdnote_items" required class="input-field">
                        <button type="submit" class="btn btn-info mx-2 py-2 px-3">Import</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <a href="{{ route('export.invoice_items') }}" class="text-center btn btn-info mx-2 py-2 px-3">
                    Export
                </a>
            </div>
        </div>
    </div>
</div>
@endsection