@extends('layouts.app')

@section('title', 'settings')

@section('content')
<div class="container px-4 mt-4">
    <div class="row my-4">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <img src="{{ asset('assets/images/ports.png') }}" class="img-fluid rounded">
            </div>
        </div>
        <div class="col-md-8">
            <div class="card shadow-sm p-4">
                <h2 class="text-center text-info">Ports</h2>
                <form action="{{ route('settings.ports.create') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-4">
                        <div class="col-9 my-auto">
                            <input type="text" name="port" placeholder="Port Name" value="{{ old('port') }}"
                                class="form-control">
                        </div>
                        <div class="col-3">
                            <button type="submit" class="btn btn-info btn-sm w-100 my-auto">Create</button>
                        </div>
                    </div>
                </form>

                <div class="ports">
                    <table class="table rounded">
                        <thead class="bg-light text-info">
                            <tr>
                                <th>Port</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ports as $port)
                            <tr>
                                <td>
                                    {{ $port->title }}
                                </td>
                                <td>
                                    <a href="{{ route('settings.ports.destroy', $port->id) }}"
                                        class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="2">{{ $ports->links() }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <img src="{{ asset('assets/images/accounting.png') }}" class="img-fluid rounded">
            </div>
        </div>
        <div class="col-md-8">
            <div class="card shadow-sm p-4">
                <h2 class="text-center text-info">Configurations</h2>
                <form action="{{ route('settings.update') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group mt-3">
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

                    <div class="form-group mt-3">
                        <label for="revenue_account_id">Revenue Account</label>
                        <select name="revenue_account_id" class="form-control select2">
                            <option value=""></option>
                            @foreach ($accounts as $account)
                            <option value="{{ $account->id }}" {{ $revenue_account->value == $account->id ? 'selected' :
                                '' }}>{{ $account->account_number }} | {{
                                $account->account_description }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mt-3">
                        <label for="receivable_account_id">Receivable Account</label>
                        <select name="receivable_account_id" class="form-control select2">
                            <option value=""></option>
                            @foreach ($accounts as $account)
                            <option value="{{ $account->id }}" {{ $receivable_account->value == $account->id ?
                                'selected' :
                                '' }}>{{ $account->account_number }} | {{
                                $account->account_description }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mt-3">
                        <label for="payable_account_id">Payable Account</label>
                        <select name="payable_account_id" class="form-control select2">
                            <option value=""></option>
                            @foreach ($accounts as $account)
                            <option value="{{ $account->id }}" {{ $payable_account->value == $account->id ? 'selected' :
                                '' }}>{{ $account->account_number }} | {{
                                $account->account_description }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mt-3">
                        <label for="cash_account_id">Cash Account</label>
                        <select name="cash_account_id" class="form-control select2">
                            <option value=""></option>
                            @foreach ($accounts as $account)
                            <option value="{{ $account->id }}" {{ $cash_account->value == $account->id ? 'selected' :
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

    <div class="row my-4">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <img src="{{ asset('assets/images/backup.png') }}" class="img-fluid rounded">
            </div>
        </div>
        <div class="col-md-8">
            <div class="card shadow-sm p-4">
                <h2 class="text-center text-info">Backup</h2>
                <div class="mt-4">
                    <form action="{{ route('settings.backup.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-9">
                                <input type="file" name="file" required class="form-control">
                            </div>
                            <div class="col-3">
                                <button type="submit" class="btn btn-info w-100  mx-2 py-2 px-3">Import</button>
                            </div>
                        </div>
                    </form>
                    <p>
                        Download SQL File?
                        <a href="{{ route('settings.backup.export') }}"
                            class="text-center btn btn-info mx-2 py-2 px-3 my-auto">
                            Export
                        </a>
                    </p>
                </div>
            </div>
            <br><br>
        </div>
    </div>
</div>
@endsection