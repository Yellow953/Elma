@extends('layouts.app')

@section('title', 'dashboard')

@section('content')
<div class="container-fluid px-2 px-md-4">
    <div class="page-header min-height-300 border-radius-xl mt-4"
        style="background-image: url({{asset('/assets/images/shipping.png')}});"></div>

    <div class="card card-body m-3 mx-md-4 mt-n6">
        <h1 class="text-center">Elma</h1>
        <div class="row mt-3">
            <div class="col-md-4 mb-xl-0 mb-4">
                <div class="card my-3">
                    <div class="card-header p-3 pt-2 bg-gradient-dark border-radius">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-info shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-white">Total Users</p>
                            <h4 class="m-3 text-white">
                                @if ($total_users)
                                {{number_format($total_users)}}
                                @else
                                No Record
                                @endif
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-xl-0 mb-4">
                <div class="card my-3">
                    <div class="card-header p-3 pt-2 bg-gradient-dark border-radius">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-info shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-white">Total Suppliers</p>
                            <h4 class="m-3 text-white">
                                @if ($total_suppliers)
                                {{number_format($total_suppliers)}}
                                @else
                                No Record
                                @endif
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-xl-0 mb-4">
                <div class="card my-3">
                    <div class="card-header p-3 pt-2 bg-gradient-dark border-radius">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-info shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-white">Total Clients</p>
                            <h4 class="m-3 text-white">
                                @if ($total_clients)
                                {{number_format($total_clients)}}
                                @else
                                No Record
                                @endif
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-xl-0 mb-4">
                <div class="card my-3">
                    <div class="card-header p-3 pt-2 bg-gradient-dark border-radius">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-info shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                            <i class="fa-solid fa-folder-minus"></i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-white">Total SOs</p>
                            <h4 class="m-3 text-white">
                                @if ($total_sales_orders)
                                {{number_format($total_sales_orders)}}
                                @else
                                No Record
                                @endif
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-xl-0 mb-4">
                <div class="card my-3">
                    <div class="card-header p-3 pt-2 bg-gradient-dark border-radius">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-info shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                            <i class="fa-solid fa-folder-plus"></i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-white">Total POs</p>
                            <h4 class="m-3 text-white">
                                @if ($total_purchase_orders)
                                {{number_format($total_purchase_orders)}}
                                @else
                                No Record
                                @endif
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-xl-0 mb-4">
                <div class="card my-3">
                    <div class="card-header p-3 pt-2 bg-gradient-dark border-radius">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-info shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                            <i class="fa-solid fa-cubes"></i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-white">Total Items</p>
                            <h4 class="m-3 text-white">
                                @if ($total_items)
                                {{number_format($total_items)}}
                                @else
                                No Record
                                @endif
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-xl-0 mb-4">
                <div class="card my-3">
                    <div class="card-header p-3 pt-2 bg-gradient-dark border-radius">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-info shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                            <i class="fa-solid fa-truck"></i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-white">Total Shipments</p>
                            <h4 class="m-3 text-white">
                                @if ($total_shipments)
                                {{number_format($total_shipments)}}
                                @else
                                No Record
                                @endif
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-xl-0 mb-4">
                <div class="card my-3">
                    <div class="card-header p-3 pt-2 bg-gradient-dark border-radius">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-info shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                            <i class="fa-solid fa-receipt"></i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-white">Total Receipts</p>
                            <h4 class="m-3 text-white">
                                @if ($total_receipts)
                                {{number_format($total_receipts)}}
                                @else
                                No Record
                                @endif
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-xl-0 mb-4">
                <div class="card my-3">
                    <div class="card-header p-3 pt-2 bg-gradient-dark border-radius">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-info shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                            <i class="fa-solid fa-receipt"></i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-white">Total Invoices</p>
                            <h4 class="m-3 text-white">
                                @if ($total_invoices)
                                {{number_format($total_invoices)}}
                                @else
                                No Record
                                @endif
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-xl-0 mb-4">
                <div class="card my-3">
                    <div class="card-header p-3 pt-2 bg-gradient-dark border-radius">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-info shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                            <i class="fa-solid fa-money-bill"></i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-white">Total Payments</p>
                            <h4 class="m-3 text-white">
                                @if ($total_payments)
                                {{number_format($total_payments)}}
                                @else
                                No Record
                                @endif
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-xl-0 mb-4">
                <div class="card my-3">
                    <div class="card-header p-3 pt-2 bg-gradient-dark border-radius">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-info shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                            <i class="fa-solid fa-money-bill"></i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-white">Total Expenses</p>
                            <h4 class="m-3 text-white">
                                @if ($total_expenses)
                                {{number_format($total_expenses)}}
                                @else
                                No Record
                                @endif
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection