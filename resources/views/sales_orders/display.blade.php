@extends('layouts.invoice')

@section('title', 'sales_orders')

@section('title', 'show')

@section('content')
<div class="container">
    <div class="row">
        <div class="receipt-main col-xs-10 col-sm-10 col-md-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3">
            <div class="row">
                <div class="receipt-header">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="receipt-left">
                            <img class="img-responsive logo" alt="Logo"
                                src="{{ asset('assets/images/logos/logo.png') }}">
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                        <div class="receipt-right">
                            <h5>Elma</h5>
                            <p>+49 1520 4820 649 <i class="fa fa-phone"></i></p>
                            <p>yellowtech953@gmail.com <i class="fa fa-envelope-o"></i></p>
                            <p>Germany, Berlin <i class="fa fa-location-arrow"></i></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="receipt-header receipt-header-mid">
                    <div class="col-xs-8 col-sm-8 col-md-8 text-left">
                        <div class="receipt-right">
                            <h5><b>Date: {{ $sales_order->date }}</b></h5>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="receipt-left">
                            <h3>{{$sales_order->name }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <h3 class="text-blue">Items</h3>
            <div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sales_order->items as $item)
                        <tr>
                            <td>
                                {{$item->item->itemcode}}
                            </td>
                            <td>{{number_format($item->quantity, 2)}}</td>
                            <td>{{number_format($item->sell_price, 2)}}$</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td><b>Sub Total </b></td>
                            <td><b>{{number_format($sub_total, 2)}} $</b></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><b>Vat</b></td>
                            <td><b>0%</b></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><b>Total</b></td>
                            <td><b>{{number_format($total, 2)}} $</b></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><b>Total LBP</b></td>
                            <td><b>{{number_format($total_lbp)}} LBP</b></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection