@extends('layouts.app')

@section('title', 'settings')

@section('content')
<div class="container px-4 mt-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <img src="{{ asset('assets/images/accounting.png') }}" class="img-fluid rounded">
            </div>
        </div>
        <div class="col-md-8">
            <div class="card shadow-sm p-4">
                <h2 class="text-center text-info mb-4">Configurations</h2>
                <form action="{{ route('settings.update') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="expense_account_id">Expense Account</label>
                        <select name="expense_account_id" class="form-control select2">
                            <option value=""></option>
                            @foreach ($accounts as $account)
                            <option value="{{ $account->id }}" {{ $expense_account->value == $account->id ? 'selected' :
                                '' }}>{{ $account->account_number }} | {{
                                $account->account_description }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-info">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection