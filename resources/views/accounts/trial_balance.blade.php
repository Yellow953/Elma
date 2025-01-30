@extends('layouts.invoice')

@section('title', 'accounts')

@section('sub-title', 'trial_balance')

@php
$grandTotalDebit = 0;
$grandTotalCredit = 0;
$grandTotalBalance = 0;
@endphp

@section('content')
<div class="receipt-main">
    <div class="container mt-4">
        <h2 class="text-center mb-4">Trial Balance</h2>

        <div class="border-custom">
            <table class="text-center w-100">
                <thead>
                    <tr class="border-bottom">
                        <th class="col-3 p-2">Client</th>
                        <th class="col-3 p-2">Total Debit</th>
                        <th class="col-3 p-2">Total Credit</th>
                        <th class="col-3 p-2">Balance</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($trialBalance as $entry)
                    @php
                    $grandTotalDebit += $entry['total_debit'];
                    $grandTotalCredit += $entry['total_credit'];
                    $grandTotalBalance += $entry['balance'];
                    @endphp

                    <tr>
                        <td class="p-2">{{ $entry['client'] }}</td>
                        <td class="p-2">${{ number_format($entry['total_debit'], 2) }}</td>
                        <td class="p-2">${{ number_format($entry['total_credit'], 2) }}</td>
                        <td class="p-2 {{ $entry['balance'] < 0 ? 'text-danger' : 'text-success' }}">
                            ${{ number_format($entry['balance'], 2) }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td class="p-2" colspan="6">No Transactions Yet</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class="border-top">
                        <th class="p-2"><strong>Grand Total</strong></th>
                        <th class="p-2">${{ number_format($grandTotalDebit ?? 0, 2) }}</th>
                        <th class="p-2">${{ number_format($grandTotalCredit ?? 0, 2) }}</th>
                        <th class="p-2 {{ $grandTotalBalance < 0 ? 'text-danger' : 'text-success' }}">
                            ${{ number_format($grandTotalBalance ?? 0, 2) }}
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection