@extends('layouts.invoice')

@section('title', 'suppliers')

@section('sub-title', 'statement_of_account')

@section('content')
<div class="container">
    <a href="{{ url()->previous() }}" class="btn btn-secondary px-3 py-2">
        <i class="fa-solid fa-chevron-left"></i> Back </a>

    <div class="receipt-main">
        @include('layouts._invoice_header')

        <div class="container">
            <div>
                <div class="row my-5">
                    <div class="col-md-6">
                        <strong>Account:</strong> {{ $account->account_number }} <br>
                        <strong>Currency: </strong>{{
                        ucwords($account->currency->code) }} <br>
                        <strong>Account Description: </strong> {{ Str::limit($account->account_description, 50) }} <br>
                    </div>
                    <div class="offset-md-3 col-md-3">
                        <strong>Supplier Name: </strong>{{ ucwords($supplier->name) }} <br>
                        <strong>VAT Number: </strong>{{ $supplier->vat_number }} <br>
                        <strong>Email: </strong>{{ $supplier->email }} <br>
                        <strong>Address: </strong>{{ Str::limit($supplier->address, 50) }} <br>
                    </div>
                </div>

                <div class="">
                    <div class="table-responsive overflow-auto">
                        <table class="table table-striped">
                            <thead class="text-center">
                                <tr style="font-size: 0.9rem">
                                    <th>Description</th>
                                    <th>Date</th>
                                    <th>Currency</th>
                                    <th>Debit</th>
                                    <th>Credit</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @forelse ($supplier->transactions as $transaction)
                                <tr>
                                    <td></td>
                                    <td>{{ $transaction->created_at->format('Y/m/d') }}</td>
                                    <td>{{ $transaction->currency->code }}</td>
                                    <td>{{ number_format($transaction->debit, 2) }}</td>
                                    <td>{{ number_format($transaction->credit, 2) }}</td>
                                    <td class="{{ $transaction->balance < 0 ? 'text-danger' : '' }}">{{
                                        number_format($transaction->balance, 2) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6">No Transactions Yet</td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot class="text-center">
                                <tr class="bg-dark text-white" style="font-size: 0.8rem">
                                    <th colspan="3">Total</th>
                                    <th>{{ number_format($total_debit, 2) }}</th>
                                    <th>{{ number_format($total_credit, 2) }}</th>
                                    <th>{{ number_format($total_balance, 2) }}</th>
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