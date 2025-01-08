<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 fixed-start my-2 mx-1 bg-gradient-dark custom-scroller"
    id="sidenav-main">
    <div class="sidenav-header">
        <a class="navbar-brand m-0 p-0" href="{{ route('dashboard') }}">
            <img src="{{ asset('assets/images/logo.png') }}" alt="" class="logo-nav p-4">
        </a>
    </div>
    <hr class="horizontal light m-0">

    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item mt-3">
                <h5 class="ps-4 ms-2 text-uppercase title-nav">Data</h5>
            </li>

            @can('items.read')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('items*') ? 'active bg-gradient-info' : '' }}"
                    href="{{ route('items') }}">
                    <span><i class="fa-solid fa-cubes"></i></span>
                    Items
                </a>
            </li>
            @endcan

            @can('clients.read')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('clients*') ? 'active bg-gradient-info' : '' }}"
                    href="{{ route('clients') }}">
                    <span><i class="fa-solid fa-users"></i></span>
                    Clients
                </a>
            </li>
            @endcan

            @can('suppliers.read')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('suppliers*') ? 'active bg-gradient-info' : '' }}"
                    href="{{ route('suppliers') }}">
                    <span><i class="fa-solid fa-users"></i></span>
                    Suppliers
                </a>
            </li>
            @endcan

            @can('shipments.read')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('shipments*') ? 'active bg-gradient-info' : '' }}"
                    href="{{ route('shipments') }}">
                    <span><i class="fa-solid fa-truck"></i></span>
                    Shipments
                </a>
            </li>
            @endcan

            <li class="nav-item mt-3">
                <h5 class="ps-4 ms-2 text-uppercase title-nav">Accounting</h5>
            </li>

            @can('accounts.read')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('accounts*') ? 'active bg-gradient-info' : '' }}"
                    href="{{ route('accounts') }}">
                    <span><i class="fa-solid fa-calculator"></i></span>
                    Accounts
                </a>
            </li>
            @endcan

            <li class="nav-item mt-3">
                <h6 class="title-sub-nav">Purchase</h6>
            </li>

            @can('purchase_orders.read')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('purchase_orders*') ? 'active bg-gradient-info' : '' }}"
                    href="{{ route('purchase_orders') }}">
                    <span><i class="fa-solid fa-folder"></i></span>
                    Purchase Orders
                </a>
            </li>
            @endcan

            @can('receipts.read')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('receipts*') ? 'active bg-gradient-info' : '' }}"
                    href="{{ route('receipts') }}">
                    <span><i class="fa-solid fa-receipt"></i></span>
                    Receipts
                </a>
            </li>
            @endcan

            @can('payments.read')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('payments*') ? 'active bg-gradient-info' : '' }}"
                    href="{{ route('payments') }}">
                    <span><i class="fa-solid fa-money-bill"></i></span>
                    Payments
                </a>
            </li>
            @endcan

            @can('debit_notes.read')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('debit_notes*') ? 'active bg-gradient-info' : '' }}"
                    href="{{ route('debit_notes') }}">
                    <span><i class="fa-solid fa-percent"></i></span>
                    Debit Notes
                </a>
            </li>
            @endcan

            <li class="nav-item mt-3">
                <h6 class="title-sub-nav">Sales</h6>
            </li>

            @can('sales_orders.read')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('sales_orders*') ? 'active bg-gradient-info' : '' }}"
                    href="{{ route('sales_orders') }}">
                    <span><i class="fa-solid fa-folder"></i></span>
                    Sales Orders
                </a>
            </li>
            @endcan

            @can('invoices.read')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('invoices*') ? 'active bg-gradient-info' : '' }}"
                    href="{{ route('invoices') }}">
                    <span><i class="fa-solid fa-receipt"></i></span>
                    Invoices
                </a>
            </li>
            @endcan

            @can('cash_receipts.read')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('cash_receipts*') ? 'active bg-gradient-info' : '' }}"
                    href="{{ route('cash_receipts') }}">
                    <span><i class="fa-solid fa-money-bill"></i></span>
                    Cash Receipts
                </a>
            </li>
            @endcan

            @can('credit_notes.read')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('credit_notes*') ? 'active bg-gradient-info' : '' }}"
                    href="{{ route('credit_notes') }}">
                    <span><i class="fa-solid fa-percent"></i></span>
                    Credit Notes
                </a>
            </li>
            @endcan

            <li class="nav-item mt-3">
                <h5 class="ps-4 ms-2 text-uppercase title-nav">System</h5>
            </li>

            @can('currencies.read')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('currencies*') ? 'active bg-gradient-info' : '' }}"
                    href="{{ route('currencies') }}">
                    <span><i class="fa-solid fa-coins"></i></span>
                    Currencies
                </a>
            </li>
            @endcan

            @can('taxes.read')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('taxes*') ? 'active bg-gradient-info' : '' }}"
                    href="{{ route('taxes') }}">
                    <span><i class="fa-solid fa-landmark"></i></span>
                    Taxes
                </a>
            </li>
            @endcan

            @can('users.read')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('users*') ? 'active bg-gradient-info' : '' }}"
                    href="{{ route('users') }}">
                    <span><i class="fa-solid fa-users"></i></span>
                    Users
                </a>
            </li>
            @endcan

            @can('logs.read')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('logs*') ? 'active bg-gradient-info' : '' }}"
                    href="{{ route('logs') }}">
                    <span><i class="fa-solid fa-receipt"></i></span>
                    Logs
                </a>
            </li>
            @endcan

            @can('statistics.all')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('statistics*') ? 'active bg-gradient-info' : '' }}"
                    href="{{ route('statistics') }}">
                    <span><i class="fa-solid fa-chart-pie"></i></span>
                    Statistics
                </a>
            </li>
            @endcan

            @can('settings.all')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('settings*') ? 'active bg-gradient-info' : '' }}"
                    href="{{ route('settings') }}">
                    <span><i class="fa-solid fa-gear"></i></span>
                    Settings
                </a>
            </li>
            @endcan

            @can('backups.all')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('backup*') ? 'active bg-gradient-info' : '' }}"
                    href="{{ route('backup') }}">
                    <span><i class="fa-solid fa-database"></i></span>
                    Backup
                </a>
            </li>
            @endcan
        </ul>
    </div>
</aside>