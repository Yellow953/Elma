@extends('layouts.invoice')

@section('title', 'journal_vouchers')

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
                        <strong>Journal Voucher Number:</strong> {{ $journal_voucher->id }} <br>
                        <strong>User:</strong>
                        {{ ucwords($journal_voucher->user->name) }} <br>
                        <strong>Date: </strong> {{ $journal_voucher->date }}
                    </div>
                    <div class="offset-md-3 col-md-3">
                        <strong>Batch: </strong>{{ $journal_voucher->batch }} <br>
                        <strong>Status: </strong>{{ ucwords($journal_voucher->status) }} <br>
                        <strong>Currency:</strong>{{ $journal_voucher->currency->code }} <br>
                    </div>
                    <div class="col-md-12 mt-3">
                        <strong>Description: </strong> {{ $journal_voucher->description }}
                    </div>
                </div>

                <div class="">
                    <div class="table-responsive overflow-auto">
                        <table class="table table-striped">
                            <thead class="text-center">
                                <tr style="font-size: 0.9rem">
                                    <th>Account</th>
                                    <th>Currency</th>
                                    <th>Debit</th>
                                    <th>Credit</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @forelse ($journal_voucher->transactions as $transaction)
                                <tr>
                                    <td class="col-4">{{ $transaction->account->account_number }} <br>
                                        {{ $transaction->account->account_description }}
                                    </td>
                                    <td class="col-2">{{ $transaction->currency->code }}</td>
                                    <td class="col-2">{{ number_format($transaction->debit, 2) }}</td>
                                    <td class="col-2">{{ number_format($transaction->credit, 2) }}</td>
                                    <td class="col-2 {{ $transaction->balance < 0 ? 'text-danger' : '' }}">{{
                                        number_format($transaction->balance, 2) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5">No Transactions Yet</td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot class="text-center">
                                <tr class="bg-dark text-white" style="font-size: 0.8rem">
                                    <th colspan="2">Total</th>
                                    <th>{{ number_format($total_debit, 2) }}</th>
                                    <th>{{ number_format($total_credit, 2) }}</th>
                                    <th>
                                        {{ number_format($total_balance, 2) }}
                                        {{ $journal_voucher->currency->symbol }}
                                    </th>
                                </tr>
                                <tr class="bg-dark text-white" style="font-size: 0.8rem">
                                    <th colspan="2">Foreign Total</th>
                                    <th>{{ number_format($total_foreign_debit, 2) }}</th>
                                    <th>{{ number_format($total_foreign_credit, 2) }}</th>
                                    <th>
                                        {{ number_format($total_foreign_balance, 2) }}
                                        {{ $journal_voucher->foreign_currency->symbol }}
                                    </th>
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