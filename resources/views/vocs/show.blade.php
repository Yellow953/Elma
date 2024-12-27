@extends('layouts.invoice')

@section('title', 'voc')

@section('sub-title', 'show')

@section('content')
<div class="container">
    <a href="{{ url()->previous() }}" class="btn btn-secondary px-3 py-2">
        <i class="fa-solid fa-chevron-left"></i> Back </a>

    <div class="receipt-main">
        @include('layouts._invoice_header')

        <div class="container">
            <div>
                <div class="row mb-5">
                    <div class="col-md-6">
                        <strong>VOC Number:</strong> {{ $voc->voc_number }} <br>
                        <strong>Supplier: </strong> {{ $voc->supplier->name }} <br>
                        <strong>Supplier Invoice: </strong> {{ $voc->supplier_invoice }} <br>
                        <strong>Date: </strong> {{ $voc->date }} <br>
                        <strong>Description: </strong> {{ $voc->description }}
                    </div>
                    <div class="offset-md-3 col-md-3">
                        <strong>Type: </strong>{{ $voc->type }} <br>
                        <strong>Tax: </strong>{{ $voc->tax->name }} <br>
                        <strong>Currency: </strong>{{ $voc->currency->code }} <br>
                        <strong>Foreign Currency: </strong>{{ $voc->foreign_currency->code }}
                    </div>
                </div>

                <div class="">
                    <div class="table-responsive overflow-auto">
                        <table class="table table-striped">
                            <thead class="text-center">
                                <tr style="font-size: 0.9rem">
                                    <th>Account</th>
                                    <th>Amount</th>
                                    <th>Tax</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @forelse ($voc->voc_items as $item)
                                <tr>
                                    <td>{{ $item->account->account_number }}
                                    </td>
                                    <td>{{ number_format($item->amount, 2) }}</td>
                                    <td>{{ number_format($item->tax, 2) }}</td>
                                    <td>{{ number_format($item->total, 2) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4">No VOC Items Yet</td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot class="text-center">
                                <tr class="bg-dark text-white" style="font-size: 0.9rem">
                                    <th colspan="3">Total</th>
                                    <th>{{ number_format($total, 2) }}</th>
                                </tr>
                                <tr class="bg-dark text-white" style="font-size: 0.9rem">
                                    <th colspan="3">Foreign Total</th>
                                    <th>{{ number_format($total_foreign, 2) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection