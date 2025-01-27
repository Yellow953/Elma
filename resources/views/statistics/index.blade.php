@extends('layouts.app')

@section('title', 'statistics')

@section('content')
<div class="container px-4 mt-4">
    <div class="row my-4">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <img src="{{ asset('assets/images/sales_order.png') }}" class="img-fluid rounded">
            </div>
        </div>
        <div class="col-md-8">
            <div class="card shadow-sm p-4">
                <h4 class="text-center text-info">Monthly Report</h4>
                <form action="{{ route('statistics.monthly_report') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mt-3">
                                <label for="month">Month</label>
                                <select name="month" class="form-control select2" required>
                                    <option value="" disabled selected>Select Month</option>
                                    <option value="January">January</option>
                                    <option value="February">February</option>
                                    <option value="March">March</option>
                                    <option value="April">April</option>
                                    <option value="May">May</option>
                                    <option value="June">June</option>
                                    <option value="July">July</option>
                                    <option value="August">August</option>
                                    <option value="September">September</option>
                                    <option value="October">October</option>
                                    <option value="November">November</option>
                                    <option value="December">December</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mt-3">
                                <label for="year">Select Year</label>
                                <input type="number" id="year" name="year" class="form-control" placeholder="e.g., 2025"
                                    min="2020" max="2222" required value="{{ old('year') ?? 2025 }}">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-info">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row my-4">
        <div class="col-md-8">
            <div class="card shadow-sm p-4">
                <h4 class="text-center text-info">Net Profit</h4>
                <form action="{{ route('statistics.net_profit') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mt-3">
                                <label for="month">Month</label>
                                <select name="month" class="form-control select2" required>
                                    <option value="" disabled selected>Select Month</option>
                                    <option value="January">January</option>
                                    <option value="February">February</option>
                                    <option value="March">March</option>
                                    <option value="April">April</option>
                                    <option value="May">May</option>
                                    <option value="June">June</option>
                                    <option value="July">July</option>
                                    <option value="August">August</option>
                                    <option value="September">September</option>
                                    <option value="October">October</option>
                                    <option value="November">November</option>
                                    <option value="December">December</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mt-3">
                                <label for="year">Select Year</label>
                                <input type="number" id="year" name="year" class="form-control" placeholder="e.g., 2025"
                                    min="2020" max="2222" required value="{{ old('year') ?? 2025 }}">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-info">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <img src="{{ asset('assets/images/accounting.png') }}" class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>
@endsection