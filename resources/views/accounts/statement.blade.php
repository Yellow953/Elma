@extends('layouts.invoice')

@section('title', 'accounts')

@section('sub-title', 'statement_of_account')

@section('content')
<div class="container">
    <a href="{{ url()->previous() }}" class="btn btn-secondary px-3 py-2">
        <i class="fa-solid fa-chevron-left"></i> Back </a>

    <div class="receipt-main">
        @include('layouts._invoice_header')

        <div class="container">
            <div>
                <div class="mb-5">
                    <strong>Account:</strong>
                    {{ $account->account_number }}
                    <span class="float-right"> <strong>Type: </strong>{{ ucwords($account->type) }}</span>
                    <p><strong>Account Description: </strong> <span class="float-right"><strong>Currency: </strong>{{
                            ucwords($account->currency->code) }}</span> <br> {{ $account->account_description }}</p>
                </div>

                <div class="">
                    <div class="table-responsive overflow-auto">
                        <table class="table table-striped">
                            <thead class="text-center">
                                <tr style="font-size: 0.9rem">
                                    <th>Date</th>
                                    <th>Currency</th>
                                    <th>Debit</th>
                                    <th>Credit</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @forelse ($account->transactions as $transaction)
                                <tr>
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
                                <tr class="bg-dark text-white" style="font-size: 0.8rem">
                                    <th colspan="3">Foreign Total</th>
                                    <th>{{ number_format($total_foreign_debit, 2) }}</th>
                                    <th>{{ number_format($total_foreign_credit, 2) }}</th>
                                    <th>{{ number_format($total_foreign_balance, 2) }}</th>
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