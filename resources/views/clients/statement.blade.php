@extends('layouts.invoice')

@section('title', 'clients')

@section('sub-title', 'statement_of_account')

@section('content')
<div class="receipt-main">
    <div class="container">
        <h5 class="mb-5">REG#3802724</h5>

        <div class="row my-5 px-3 d-flex">
            <div class="col border-custom p-0 d-flex flex-column">
                <table class="w-100 m-0 flex-grow-1">
                    <tr class="border-none">
                        <th class="w-custom p-2">Account</th>
                        <td colspan="2" class="py-2 px-4 border-left">
                            {{ $account->account_number }}
                        </td>
                    </tr>
                    <tr class="border-none">
                        <th class="w-custom p-2">Currency</th>
                        <td colspan="2" class="py-2 px-4 border-left">
                            {{ ucwords($account->currency->code) }}
                        </td>
                    </tr>
                    <tr class="border-none">
                        <th class="w-custom p-2">Account Description</th>
                        <td colspan="2" class="py-2 px-4 border-left">
                            {{ Str::limit($account->account_description, 50) }}
                        </td>
                    </tr>
                </table>
            </div>

            <div class="col-1"></div>

            <div class="col border-custom p-0 d-flex flex-column">
                <table class="w-100 m-0 flex-grow-1">
                    <tr class="border-none">
                        <th class="w-custom p-2">Client Name</th>
                        <td colspan="2" class="py-1 px-4 border-left">
                            {{ ucwords($client->name) }}
                        </td>
                    </tr>
                    <tr class="border-none">
                        <th class="w-custom p-2">VAT Number</th>
                        <td colspan="2" class="py-1 px-4 border-left">
                            {{ $client->vat_number }}
                        </td>
                    </tr>
                    <tr class="border-none">
                        <th class="w-custom p-2">Email</th>
                        <td colspan="2" class="py-1 px-4 border-left">
                            {{ $client->email }}
                        </td>
                    </tr>
                    <tr class="border-none">
                        <th class="w-custom p-2">Address</th>
                        <td colspan="2" class="py-1 px-4 border-left">
                            {{ Str::limit($client->address, 50) }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="border-custom">
            <table class="w-100">
                <thead class="text-center">
                    <tr class="border-bottom">
                        <th class="col-4 p-2">Description</th>
                        <th class="p-2">Date</th>
                        <th class="p-2">Currency</th>
                        <th class="p-2">Debit</th>
                        <th class="p-2">Credit</th>
                        <th class="p-2">Balance</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @forelse ($transactions as $transaction)
                    <tr>
                        <td class="p-2">
                            {{ $transaction->title }} <br>
                            {{ $transaction->description }}
                        </td>
                        <td class="p-2">{{ $transaction->created_at->format('Y/m/d') }}</td>
                        <td class="p-2">{{ $transaction->currency->code }}</td>
                        <td class="p-2">{{ number_format($transaction->debit, 2) }}</td>
                        <td class="p-2">{{ number_format($transaction->credit, 2) }}</td>
                        <td class="p-2 {{ $total + $transaction->balance < 0 ? 'text-danger' : '' }}">{{
                            number_format($total += $transaction->balance, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td class="p-2" colspan="6">No Transactions Yet</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot class="text-center">
                    <tr class="border-top">
                        <th class="p-2" colspan="3">Total</th>
                        <th class="p-2">{{ number_format($transactions->sum('debit'), 2) }}</th>
                        <th class="p-2">{{ number_format($transactions->sum('credit'), 2) }}</th>
                        <th class="p-2">{{ number_format($transactions->sum('balance'), 2) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection