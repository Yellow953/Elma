@extends('layouts.app')

@section('title', 'receipts')

@section('sub-title', 'return')

@section('content')

<link rel="stylesheet" href="{{ asset('assets/css/stepper.css') }}">

<div class="inner-container w-100 m-0 p-5">
    <div class="card">
        <div class="card-header bg-info border-b">
            <h4 class="font-weight-bolder">Return Receipt</h4>
        </div>
        <div class="card-body">
            <div class="container px-0 px-md-5">
                <div class="stepwizard col-12 my-4">
                    <div class="stepwizard-row setup-panel">
                        <div class="stepwizard-step">
                            <a href="#step-1" type="button"
                                class="btn btn-circle btn-info ignore-confirm disabled">1</a>
                            <p>Receipt</p>
                        </div>
                        <div class="stepwizard-step">
                            <a href="#step-2" type="button"
                                class="btn btn-circle btn-default ignore-confirm disabled">2</a>
                            <p>Items</p>
                        </div>
                        <div class="stepwizard-step">
                            <a href="#step-3" type="button"
                                class="btn btn-circle btn-default ignore-confirm disabled">3</a>
                            <p>Confirm</p>
                        </div>
                    </div>
                </div>

                <form role="form" action="{{ route('receipts.return_save') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="row setup-content" id="step-1">
                        <div class="offset-md-2 col-md-8">
                            <h3>Receipt</h3>
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <p class="text-center">Please select the Receipt you want to return</p>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Receipt *</label>
                                    <select name="receipt_id" id="receipt_id" required="required"
                                        class="form-select select2">
                                        <option value=""></option>
                                        @foreach ($receipts as $receipt)
                                        <option value="{{ $receipt->id }}" {{ $receipt->id == old('receipt_id') ?
                                            'selected':'' }}>{{ $receipt->receipt_number }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="d-flex justify-content-end mt-4">
                                    <button class="btn btn-info nextBtn ignore-confirm" type="button">Next</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row setup-content" id="step-2">
                        <div class="offset-md-2 col-md-8">
                            <div class="col-md-12">
                                <h3>Items</h3>

                                <div class="col-md-12">
                                    <p class="text-center">
                                        Please select the items you want to return from this Receipt
                                    </p>
                                </div>

                                <div class="d-flex align-items-center justify-content-start  mt-4">
                                    <input type="checkbox" name="return_all" {{ old('return_all') ? 'checked' : '' }}
                                        id="return_all" />
                                    <label for="return_all" class="mt-1">Return All</label>
                                </div>
                                <hr>

                                <table class="table table-bordered table-striped" id="items-table">
                                    <thead>
                                        <tr>
                                            <td class="col-2"></td>
                                            <td class="col-5">Item</td>
                                            <td class="col-5">Quantity</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>

                                <h6 class="my-2 mt-4">Landed Costs</h6>
                                <table class="table table-bordered table-striped" id="landed-costs-table">
                                    <thead>
                                        <tr>
                                            <td class="col-2"></td>
                                            <td class="col-5">Name</td>
                                            <td class="col-5">Amount</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-between mt-4">
                                    <button class="btn btn-secondary prevBtn ignore-confirm"
                                        type="button">Previous</button>
                                    <button class="btn btn-info nextBtn ignore-confirm" type="button">Next</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row setup-content" id="step-3">
                        <div class="offset-md-2 col-md-8">
                            <div class="col-md-12">
                                <h3>Confirm</h3>

                                <div class="col-md-12">
                                    <p class="text-center">Are you sure you want to return the selected items in this
                                        Receipt?</p>
                                </div>

                                <div class="d-flex justify-content-between mt-4">
                                    <button class="btn btn-secondary prevBtn ignore-confirm"
                                        type="button">Previous</button>
                                    <button class="btn btn-success btn-lg pull-right" type="submit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/stepper.js') }}"></script>

<script>
    $(document).ready(function () {
        $('#return_all').on('click', function () {
            var isChecked = $(this).prop('checked');
            $('input[name^="items"]').prop('checked', isChecked).trigger('change');
            $('input[name^="landed_costs"]').prop('checked', isChecked).trigger('change');
        });

        $('#receipt_id').on('change', function () {
            var receipt_id = $(this).val();
            if (receipt_id) {
                $.ajax({
                    url: '/receipts/' + receipt_id + '/items',
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $('#items-table tbody').empty();
                        $.each(data, function (key, value) {
                            var checkbox = $('<input type="checkbox" name="items[' + key + ']">').on('change', function() {
                                var checked = $(this).prop('checked');
                                if (checked) {
                                    var idInput = $('<input type="hidden" name="items[' + key + '][id]" value="' + value.id + '">');
                                    $(this).closest('tr').append(idInput);
                                } else {
                                    $(this).closest('tr').find('input[name="items[' + key + '][id]"]').remove();
                                }
                            });
                            var quantityInput = $('<input type="number" name="items[' + key + '][quantity]" class="form-control" value="' + value.quantity + '" max="' + value.quantity + '" step="any" min="0">');
                            var row = $('<tr>').append(
                                $('<td>').append(checkbox),
                                $('<td>').text(value.name),
                                $('<td>').append(quantityInput)
                            );
                            $('#items-table tbody').append(row);
                        });
                    }
                });

                $.ajax({
                    url: '/receipts/' + receipt_id + '/landed_costs',
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $('#landed-costs-table tbody').empty();
                        $.each(data, function (key, value) {
                            var checkbox = $('<input type="checkbox" name="landed_costs[' + key + ']">').on('change', function() {
                                var checked = $(this).prop('checked');
                                if (checked) {
                                    var idInput = $('<input type="hidden" name="landed_costs[' + key + '][id]" value="' + value.id + '">');
                                    $(this).closest('tr').append(idInput);
                                } else {
                                    $(this).closest('tr').find('input[name="landed_costs[' + key + '][id]"]').remove();
                                }
                            });
                            var amountInput = $('<input type="number" name="landed_costs[' + key + '][amount]" class="form-control" value="' + value.amount + '" max="' + value.amount + '" step="any" min="0">');
                            var row = $('<tr>').append(
                                $('<td>').append(checkbox),
                                $('<td>').text(value.name),
                                $('<td>').append(amountInput)
                            );
                            $('#landed-costs-table tbody').append(row);
                        });
                    }
                });
            }
        });
    });
</script>

@endsection