@extends('layouts.app')

@section('title', 'items')

@section('sub-title', 'track')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Item Tracking Results</h2>
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h3 class="card-title">Item Details</h3>
                    <div class="row">
                        <p><strong>Serial Number:</strong> <span>{{ $serial_number }}</span></p>
                        <p><strong>Item Name:</strong> <span>{{ ucwords($item->name) }}</span></p>
                        <p><strong>Warehosue:</strong> <span>{{ ucwords($item->warehouse->name) }}</span></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Tracking History</h3>
                    <div class="timeline">
                        @foreach ($result as $r)
                        <div class="timeline-item">
                            <p class="mb-0 text-dark"><strong>{{ $r->created_at }}</strong></p>
                            <p>
                                {{ ucwords($item->name) }}
                                @if ($r->invoice_id)
                                sold to Client {{ ucwords($r->invoice->client->name) }} in Invoice {{
                                $r->invoice->invoice_number }}
                                @elseif ($r->receipt_id)
                                purshased from Supplier {{ ucwords($r->receipt->supplier->name) }} in Receipt {{
                                $r->receipt->receipt_number }}
                                @endif
                            </p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection