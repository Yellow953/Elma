@extends('layouts.invoice')

@section('title', 'accounts')

@section('sub-title', 'trial_balance')

@section('content')
<div class="container">
    <div class="d-flex align-item-center justify-content-between">
        <a href="{{ url()->previous() }}" class="btn btn-secondary px-3 py-2">
            <i class="fa-solid fa-chevron-left"></i> Back </a>

        <form action="{{ route('accounts.export_trial_balance') }}" method="post">
            @csrf
            <input type="hidden" name="from_date" value="{{ $from_date }}">
            <input type="hidden" name="to_date" value="{{ $to_date }}">
            <input type="hidden" name="from_account" value="{{ $from_account }}">
            <input type="hidden" name="to_account" value="{{ $to_account }}">
            <input type="hidden" name="skip_empty" value="{{ $skip_empty }}">
            <button type="submit" class="btn btn-primary">Export to Excel</button>
        </form>
    </div>

    <div class="receipt-main">
        @include('layouts._invoice_header')

        <div class="container mt-4">
            <h2>Trial Balance</h2>

            <div class="row mb-3">
                <div class="col-md-6">
                    <h4>Account: </h4>
                    <div class="row">
                        <div class="col-6">
                            <h6>From:</h6> {{ $from_account ?? 'NO ACCOUNT' }}
                        </div>
                        <div class="col-6">
                            <h6>To:</h6> {{ $to_account ?? 'NO ACCOUNT' }}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h4>Date: </h4>
                    <div class="row">
                        <div class="col-6">
                            <h6>From:</h6> {{ $from_date ?? 'NO DATE' }}
                        </div>
                        <div class="col-6">
                            <h6>To:</h6> {{ $to_date ?? 'NO DATE' }}
                        </div>
                    </div>
                </div>
            </div>

            <table class="table text-center">
                <thead>
                    <tr>
                        <th>Account</th>
                        <th>Debit Total</th>
                        <th>Credit Total</th>
                        <th>Balance</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($trialBalance as $entry)
                    <tr>
                        <td>
                            {{ $entry['account']->account_number }} <br>
                            {{ $entry['account']->account_description }}
                        </td>
                        <td>{{ number_format($entry['debit_total'], 2) }}</td>
                        <td>{{ number_format($entry['credit_total'], 2) }}</td>
                        <td>{{ number_format($entry['balance'], 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-dark text-white">
                    <tr>
                        <th>Total</th>
                        <th>{{ number_format($all_debit, 2) }}</th>
                        <th>{{ number_format($all_credit, 2) }}</th>
                        <th>{{ number_format($all_balance, 2) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>
</div>
@endsection