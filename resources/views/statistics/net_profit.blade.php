@extends('layouts.invoice')

@section('title', 'clients')

@section('sub-title', 'profit')

@section('content')
<div class="container">
    <h2 class="text-primary text-center mb-4">Net Profit ({{ $month . ', ' . $year }})</h2>

    <!-- Summary Section -->
    <div class="row my-4">
        <div class="col-md-4">
            <div class="card p-2 mb-1 summary-card">
                <h5>Total Revenue</h5>
                <p>${{ number_format($total_revenue, 2) }}</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-2 mb-1 summary-card">
                <h5>Total Expenses</h5>
                <p>${{ number_format($total_expenses, 2) }}</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-2 mb-1 summary-card">
                <h5>Internal Expenses</h5>
                <p>${{ number_format($internal_expenses, 2) }}</p>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card p-2 mb-1 summary-card">
                <h5>Total Profit</h5>
                <p>${{ number_format($total_profit, 2) }}</p>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card p-2 mb-1 summary-card">
                <h5>Net Profit</h5>
                <p>${{ number_format($net_profit, 2) }}</p>
            </div>
        </div>
    </div>

    <!-- Chart and Table -->
    <div class="row">
        <div class="col-md-8 mb-4">
            <div class="card card-custom p-3">
                <h5 class="text-center">Invoices</h5>
                <div class="table-wrapper">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Shipment</th>
                                <th>Client</th>
                                <th>Expenses</th>
                                <th>Revenue</th>
                                <th>Profit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($invoices as $invoice)
                            @php
                            $stats = $invoice->stats();
                            @endphp
                            <tr>
                                <td>{{ $invoice->invoice_number }}</td>
                                <td>{{ $invoice->shipment->shipment_number }}</td>
                                <td>{{ ucwords($invoice->client->name) }}</td>
                                <td>${{ $stats[0] }}</td>
                                <td>${{ $stats[1] }}</td>
                                <td>${{ $stats[2] }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">No Invoices Found...</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card card-custom p-3">
                <h5 class="text-center">Internal Expenses</h5>
                <div class="table-wrapper">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>Title</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($expenses as $expense)
                            <tr>
                                <td>{{ $expense->title }}</td>
                                <td>{{ $expense->amount }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2">No Expenses Found...</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection