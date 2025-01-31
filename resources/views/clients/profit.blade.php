@extends('layouts.invoice')

@section('title', 'clients')

@section('sub-title', 'profit')

@section('content')
<div class="container">
    <!-- Summary Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card card-custom p-3">
                <h3>Client Info</h3>

                <div class="info mx-4 mt-2">
                    <div class="mb-1">Name: {{ ucwords($client->name) }}</div>
                    <div class="mb-1">Phone: {{ $client->phone ?? 'N/A' }}</div>
                    <div class="mb-1">Email: {{ $client->email ?? 'N/A' }}</div>
                    <div class="mb-1">Address: {{ $client->address ?? 'N/A' }}</div>
                    <div class="mb-1">Vat Number: {{ $client->vat_number ?? 'N/A' }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-2 mb-1 summary-card">
                <h5>Total Revenue</h5>
                <p>${{ number_format($total_revenue, 2) }}</p>
            </div>

            <div class="card p-2 mb-1 summary-card">
                <h5>Total Expenses</h5>
                <p>${{ number_format($total_expenses, 2) }}</p>
            </div>

            <div class="card p-2 mb-1 summary-card">
                <h5>Total Profit</h5>
                <p>${{ number_format($total_profit, 2) }}</p>
            </div>
        </div>
    </div>

    <!-- Chart and Table -->
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card card-custom p-3">
                <h5 class="text-center">Invoices</h5>
                <div class="table-wrapper">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Shipment</th>
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

                            <tr onclick="window.location='{{ route('invoices.edit', $invoice->id) }}'"
                                style="cursor: pointer;">
                                <td>{{ $invoice->invoice_number }}</td>
                                <td>{{ $invoice->shipment->shipment_number }}</td>
                                <td>${{ $stats[0] }}</td>
                                <td>${{ $stats[1] }}</td>
                                <td>${{ $stats[2] }}</td>
                            </tr>
                            @empty
                            <tr class="text-center">
                                <td colspan="5">No Invoices Yet...</td>
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