@extends('layouts.app')

@section('title', 'statistics')

@section('content')
<div class="container">
    <div class="card card-body m-3 mx-md-4">
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
            <div class="col-md-4 mb-xl-0 mb-4">
                <div class="card my-3">
                    <div class="card-header p-3 pt-2 bg-gradient-dark border-radius">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-info shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                            <i class="fa-solid fa-folder-minus"></i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-white">Total Sales Orders</p>
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
            <div class="col-md-4 mb-xl-0 mb-4">
                <div class="card my-3">
                    <div class="card-header p-3 pt-2 bg-gradient-dark border-radius">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-info shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                            <i class="fa-solid fa-folder-plus"></i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-white">Total Purchase Orders</p>
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
            <div class="col-md-4 mb-xl-0 mb-4">
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
            <div class="col-md-4 mb-xl-0 mb-4">
                <div class="card my-3">
                    <div class="card-header p-3 pt-2 bg-gradient-dark border-radius">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-info shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                            <i class="fa-solid fa-receipt"></i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-white">Total JVs</p>
                            <h4 class="m-3 text-white">
                                @if ($total_jvs)
                                {{number_format($total_jvs)}}
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
            <div class="col-md-4 mb-xl-0 mb-4">
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
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <h2 class="my-4">Inventory</h2>
        <div class="col-md-6">
            <div class="card p-4 mt-4">
                <h3 class="mb-4">Top Selling Products</h3>
                <canvas id="topSellingProductsChart" width="400" height="200"></canvas>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card p-4 mt-4">
                <h3 class="mb-4">Inventory Turnover</h3>
                <canvas id="monthlyTurnoverChart" width="400" height="200"></canvas>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card p-4 mt-4">
                <h3 class="mb-4">Stock Out Analysis</h3>
                <canvas id="stockOutChart" width="400" height="200"></canvas>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card p-4 mt-4">
                <h3 class="mb-4">Stock In Analysis</h3>
                <canvas id="stockInChart" width="400" height="200"></canvas>
            </div>
        </div>

        <div class="col-md-6 offset-md-3">
            <div class="card p-4 mt-4">
                <h3 class="mb-4">Active Stock Analysis</h3>
                <canvas id="deadStockChart" width="400" height="200"></canvas>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card p-4 mt-4">
                <h3 class="mb-4">Forecasted Demand vs. Actual Sales</h3>
                <canvas id="demandForecastChart" width="400" height="200"></canvas>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card p-4 mt-4">
                <h3 class="mb-4">Monthly Sales Forecast by Product</h3>
                <canvas id="salesForecastByProductChart" width="400" height="200"></canvas>
            </div>
        </div>

        <h2 class="my-4">Accounting</h2>
        <div class="col-md-6">
            <div class="card p-4 mt-4">
                <h3 class="mb-4">Monthly Revenue and Expenses Trend</h3>
                <canvas id="revenueExpensesTrendChart" width="400" height="200"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-4 mt-4">
                <h3 class="mb-4">Monthly Revenue vs. Expenses</h3>
                <canvas id="revenueVsExpensesChart" width="400" height="200"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-4 mt-4">
                <h3 class="mb-4">Sales to Top Customers</h3>
                <canvas id="topCustomersChart" width="400" height="200"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-4 mt-4">
                <h3 class="mb-4">Purchases from Top Suppliers</h3>
                <canvas id="topSuppliersChart" width="400" height="200"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-4 mt-4">
                <h3 class="mb-4">Revenue by Customer:</h3>
                <canvas id="receivablesDistributionChart" width="400" height="200"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-4 mt-4">
                <h3 class="mb-4">Expense by Supplier</h3>
                <canvas id="payablesDistributionChart" width="400" height="200"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-4 mt-4">
                <h3 class="mb-4">Net Profit Margin</h3>
                <canvas id="netProfitMarginChart" width="400" height="200"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-4 mt-4">
                <h3 class="mb-4">Stock Valuation</h3>
                <canvas id="stockValuationChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
</div>
<br>

<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@3"></script>
<script>
    $(document).ready(function() {
            // Fetch and render Inventory Top Selling Products
            $.ajax({
                url: '{{ route("inventory.topSellingProducts") }}',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    var ctx = document.getElementById('topSellingProductsChart').getContext('2d');
                    var topSellingProductsChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: response.labels,
                            datasets: [
                                {
                                    label: 'Current Month',
                                    data: response.currentMonthData,
                                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    borderWidth: 1
                                },
                                {
                                    label: 'Previous Month',
                                    data: response.previousMonthData,
                                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                    borderColor: 'rgba(255, 99, 132, 1)',
                                    borderWidth: 1
                                }
                            ]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching top selling products:', error);
                }
            });

            // Fetch and render Monthly Inventory Turnover Ratio
            $.ajax({
                url: '{{ route("inventory.monthlyTurnoverRatio") }}',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    var ctx = document.getElementById('monthlyTurnoverChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: response.labels,
                            datasets: [{
                                label: 'Monthly Turnover Ratio',
                                data: response.data,
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching monthly turnover ratio:', error);
                }
            });

            // Fetch and render Stock Out Analysis
            $.ajax({
                url: '{{ route("inventory.stockOutAnalysis") }}',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    var labels = response.map(item => item.month);
                    var data = response.map(item => item.stock_out_count);

                    var ctx = document.getElementById('stockOutChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Stock Out Incidents',
                                data: data,
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching stock out data:', error);
                }
            });

            // Fetch and render Stock In Analysis
            $.ajax({
                url: '{{ route("inventory.stockInAnalysis") }}',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    var labels = response.map(item => item.month);
                    var data = response.map(item => item.stock_in_count);

                    var ctx = document.getElementById('stockInChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Stock In Incidents',
                                data: data,
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching stock in data:', error);
                }
            });

            // Fetch and render Dead Stock Analysis
            $.ajax({
                url: '{{ route("inventory.deadStockAnalysis") }}',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    var ctx = document.getElementById('deadStockChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: ['Active Stock', 'Dead Stock'],
                            datasets: [{
                                data: [response.active_stock, response.dead_stock],
                                backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(255, 99, 132, 0.2)'],
                                borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)'],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(tooltipItem) {
                                            return tooltipItem.label + ': ' + tooltipItem.raw;
                                        }
                                    }
                                }
                            }
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching dead stock data:', error);
                }
            });

            // Fetch and render Demand Forecasting data
            $.ajax({
                url: '{{ route("inventory.demandForecasting") }}',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Prepare data for Forecasted Demand vs. Actual Sales Line Chart
                    const labels = response.actual_sales.map(item => item.month);
                    const actualSalesData = response.actual_sales.map(item => item.total_sales);
                    const forecastedDemandData = response.forecasted_demand.map(item => item.forecasted_sales);

                    var ctx1 = document.getElementById('demandForecastChart').getContext('2d');
                    new Chart(ctx1, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [
                                {
                                    label: 'Actual Sales',
                                    data: actualSalesData,
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    fill: false
                                },
                                {
                                    label: 'Forecasted Demand',
                                    data: forecastedDemandData,
                                    borderColor: 'rgba(255, 99, 132, 1)',
                                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                    fill: false
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                x: {
                                    type: 'time',
                                    time: {
                                        unit: 'month'
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(tooltipItem) {
                                            return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
                                        }
                                    }
                                }
                            }
                        }
                    });

                    // Prepare data for Monthly Sales Forecast by Product Bar Chart
                    const productLabels = response.sales_forecast_by_product.map(item => item.itemcode);
                    const productSalesData = response.sales_forecast_by_product.map(item => item.total_sales);

                    var ctx2 = document.getElementById('salesForecastByProductChart').getContext('2d');
                    new Chart(ctx2, {
                        type: 'bar',
                        data: {
                            labels: productLabels,
                            datasets: [
                                {
                                    label: 'Sales',
                                    data: productSalesData,
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                x: {
                                    type: 'category',
                                    title: {
                                        display: true,
                                        text: 'Product'
                                    }
                                },
                                y: {
                                    title: {
                                        display: true,
                                        text: 'Sales'
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(tooltipItem) {
                                            return tooltipItem.label + ': ' + tooltipItem.raw;
                                        }
                                    }
                                }
                            }
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching demand forecasting data:', error);
                }
            });

            // -----------------------------------------------------------------

            // Fetch and render Revenue and Expenses data
            $.ajax({
                url: '{{ route("accounting.revenueExpenses") }}',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Prepare data for Monthly Revenue and Expenses Trend Line Chart
                    const labels = response.revenue.map(item => item.month);
                    const revenueData = response.revenue.map(item => item.revenue);
                    const expensesData = response.expenses.map(item => item.expense);

                    var ctx1 = document.getElementById('revenueExpensesTrendChart').getContext('2d');
                    new Chart(ctx1, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [
                                {
                                    label: 'Revenue',
                                    data: revenueData,
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    fill: false
                                },
                                {
                                    label: 'Expenses',
                                    data: expensesData,
                                    borderColor: 'rgba(255, 99, 132, 1)',
                                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                    fill: false
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                x: {
                                    type: 'time',
                                    time: {
                                        unit: 'month'
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(tooltipItem) {
                                            return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
                                        }
                                    }
                                }
                            }
                        }
                    });

                    // Prepare data for Monthly Comparison of Revenue vs. Expenses Bar Chart
                    var ctx2 = document.getElementById('revenueVsExpensesChart').getContext('2d');
                    new Chart(ctx2, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [
                                {
                                    label: 'Revenue',
                                    data: revenueData,
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1
                                },
                                {
                                    label: 'Expenses',
                                    data: expensesData,
                                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                    borderColor: 'rgba(255, 99, 132, 1)',
                                    borderWidth: 1
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                x: {
                                    type: 'category',
                                    title: {
                                        display: true,
                                        text: 'Month'
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Amount'
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(tooltipItem) {
                                            return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
                                        }
                                    }
                                }
                            }
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching revenue and expenses:', error);
                }
            });

            // Fetch and render data for top customers and suppliers
            $.ajax({
                url: '{{ route("accounting.topCustomersSuppliers") }}',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Prepare data for Sales to Top Customers Bar Chart
                    const customerLabels = response.topCustomers.map(customer => customer.name);
                    const salesData = response.topCustomers.map(customer => customer.total_sales);

                    var ctx1 = document.getElementById('topCustomersChart').getContext('2d');
                    new Chart(ctx1, {
                        type: 'bar',
                        data: {
                            labels: customerLabels,
                            datasets: [{
                                label: 'Total Sales',
                                data: salesData,
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false,
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(tooltipItem) {
                                            return 'Total Sales: ' + tooltipItem.raw;
                                        }
                                    }
                                }
                            }
                        }
                    });

                    // Prepare data for Purchases from Top Suppliers Bar Chart
                    const supplierLabels = response.topSuppliers.map(supplier => supplier.name);
                    const purchaseData = response.topSuppliers.map(supplier => supplier.total_purchases);

                    var ctx2 = document.getElementById('topSuppliersChart').getContext('2d');
                    new Chart(ctx2, {
                        type: 'bar',
                        data: {
                            labels: supplierLabels,
                            datasets: [{
                                label: 'Total Purchases',
                                data: purchaseData,
                                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                                borderColor: 'rgba(153, 102, 255, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false,
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(tooltipItem) {
                                            return 'Total Purchases: ' + tooltipItem.raw;
                                        }
                                    }
                                }
                            }
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });

            // Fetch and render data for receivables distribution
            $.ajax({
                url: '{{ route("accounting.receivablesDistribution") }}',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    const customerLabels = response.receivables.map(customer => customer.name);
                    const receivablesData = response.receivables.map(customer => customer.total_receivables);

                    var ctx = document.getElementById('receivablesDistributionChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: customerLabels,
                            datasets: [{
                                label: 'Receivables Distribution',
                                data: receivablesData,
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(255, 159, 64, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(tooltipItem) {
                                            return tooltipItem.label + ': ' + tooltipItem.raw;
                                        }
                                    }
                                }
                            }
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });

            // Fetch and render data for payables distribution
            $.ajax({
                url: '{{ route("accounting.payablesDistribution") }}',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    const supplierLabels = response.payables.map(supplier => supplier.name);
                    const payablesData = response.payables.map(supplier => supplier.total_payables);

                    var ctx = document.getElementById('payablesDistributionChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: supplierLabels,
                            datasets: [{
                                label: 'Payables Distribution',
                                data: payablesData,
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(255, 159, 64, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(tooltipItem) {
                                            return tooltipItem.label + ': ' + tooltipItem.raw;
                                        }
                                    }
                                }
                            }
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });

            // Fetch and render data for Net Profit Margin
            $.ajax({
                url: '{{ route("accounting.netProfitMargin") }}',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    var ctx = document.getElementById('netProfitMarginChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: Object.keys(response),
                            datasets: [{
                                label: 'Net Profit Margin (%)',
                                data: Object.values(response),
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });

            // Fetch and render data for Stock Valuation
            $.ajax({
                url: '{{ route("accounting.stockValuation") }}',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    var ctx = document.getElementById('stockValuationChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: Object.keys(response),
                            datasets: [{
                                label: 'Stock Valuation',
                                data: Object.values(response),
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        });
</script>
@endsection