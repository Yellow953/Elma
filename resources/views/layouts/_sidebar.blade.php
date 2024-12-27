<aside
  class="sidenav navbar navbar-vertical navbar-expand-xs border-0 fixed-start my-2 mx-1 bg-gradient-dark custom-scroller"
  id="sidenav-main">
  <div class="sidenav-header">
    <a class="navbar-brand m-0 p-0 d-flex flex-row justify-content-center" href="{{ route('dashboard') }}">
      <img src="{{asset('/assets/images/logos/logo_yellow.png')}}" alt="Logo" width="75" height="75">
    </a>
  </div>
  <hr class="horizontal light m-0">

  <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
    <ul class="navbar-nav">
      <li class="nav-item mt-3">
        <h5 class="ps-4 ms-2 text-uppercase title-nav">Inventory</h5>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('items*') ? 'active bg-gradient-info' : '' }} ignore-confirm"
          data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false"
          aria-controls="collapseExample">
          <span><i class="fa-solid fa-cubes"></i></span>
          Items
        </a>
      </li>
      <div class="collapse {{ request()->routeIs('items*') ? 'show' : '' }}" id="collapseExample">
        <li class="nav-item">
          <a class="mx-5 nav-link {{ request()->routeIs('items') ? 'active bg-gradient-info' : '' }}"
            href="{{route('items')}}">
            <span class="text-bold">{{ucwords('all')}}</span>
          </a>
        </li>
        @foreach ($warehouses as $warehouse)
        <li class="nav-item">
          <a class="mx-5 nav-link {{(Request::url() === route('items.warehouse', $warehouse->name)) ? 'active bg-gradient-info' : '' }}"
            href="{{route('items.warehouse', $warehouse->name)}}">
            <span class="text-bold">{{ucwords($warehouse->name)}}</span>
          </a>
        </li>
        @endforeach
      </div>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('po*') ? 'active bg-gradient-info' : '' }}" href="{{ route('po') }}">
          <span><i class="fa-solid fa-folder"></i></span>
          PO
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('so*') ? 'active bg-gradient-info' : '' }}" href="{{ route('so') }}">
          <span><i class="fa-solid fa-folder"></i></span>
          SO
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('tro*') ? 'active bg-gradient-info' : '' }}" href="{{ route('tro') }}">
          <span><i class="fa-solid fa-folder"></i></span>
          TRO
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('projects*') ? 'active bg-gradient-info' : '' }}"
          href="{{ route('projects') }}">
          <span><i class="fa-solid fa-screwdriver-wrench"></i></span>
          Projects
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('notifications*') ? 'active bg-gradient-info' : '' }} ignore-confirm"
          data-toggle="collapse" href="#collapseExample1" role="button" aria-expanded="false"
          aria-controls="collapseExample1">
          <span><i class="fa-solid fa-bell"></i></span>
          Notifications
        </a>
      </li>
      <div class="collapse {{ request()->routeIs('notifications*') ? 'show' : '' }}" id="collapseExample1">
        <li class="nav-item">
          <a class="mx-5 nav-link {{ request()->routeIs('notifications') ? 'active bg-gradient-info' : '' }}"
            href="{{ route('notifications') }}">
            <span class="text-bold">All</span>
          </a>
        </li>
        @foreach ($warehouses as $warehouse)
        <li class="nav-item">
          <a class="mx-5 nav-link {{(Request::url() === route('notifications.individual', $warehouse->name)) ? 'active bg-gradient-info' : '' }}"
            href="{{route('notifications.individual', $warehouse->name)}}">
            <span class="text-bold">{{ucwords($warehouse->name)}}</span>
          </a>
        </li>
        @endforeach
      </div>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('logs*') ? 'active bg-gradient-info' : '' }} ignore-confirm"
          data-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false"
          aria-controls="collapseExample2">
          <span><i class="fa-solid fa-receipt"></i></span>
          Logs
        </a>
      </li>
      <div class="collapse {{ request()->routeIs('logs*') ? 'show' : '' }}" id="collapseExample2">
        <li class="nav-item">
          <a class="mx-5 nav-link {{ request()->routeIs('logs') ? 'active bg-gradient-info' : '' }}"
            href="{{ route('logs') }}">
            <span class="text-bold">All</span>
          </a>
        </li>
        @foreach ($warehouses as $warehouse)
        <li class="nav-item">
          <a class="mx-5 nav-link {{(Request::url() === route('logs.individual', $warehouse->name)) ? 'active bg-gradient-info' : '' }}"
            href="{{route('logs.individual', $warehouse->name)}}">
            <span class="text-bold">{{ucwords($warehouse->name)}}</span>
          </a>
        </li>
        @endforeach
      </div>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('requests*') ? 'active bg-gradient-info' : '' }} ignore-confirm"
          data-toggle="collapse" href="#collapseExample3" role="button" aria-expanded="false"
          aria-controls="collapseExample3">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
              class="bi bi-signpost-2-fill" viewBox="0 0 16 16">
              <path
                d="M7.293.707A1 1 0 0 0 7 1.414V2H2a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h5v1H2.5a1 1 0 0 0-.8.4L.725 8.7a.5.5 0 0 0 0 .6l.975 1.3a1 1 0 0 0 .8.4H7v5h2v-5h5a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1H9V6h4.5a1 1 0 0 0 .8-.4l.975-1.3a.5.5 0 0 0 0-.6L14.3 2.4a1 1 0 0 0-.8-.4H9v-.586A1 1 0 0 0 7.293.707z" />
            </svg>
          </div>
          <span class="nav-link-text ms-1">Requests</span>
        </a>
      </li>
      <div class="collapse {{ request()->routeIs('requests*') ? 'show' : '' }}" id="collapseExample3">
        <li class="nav-item">
          <a class="mx-5 nav-link {{ request()->routeIs('requests') ? 'active bg-gradient-info' : '' }}"
            href="{{ route('requests') }}">
            <span class="text-bold">All</span>
          </a>
        </li>
        @foreach ($warehouses as $warehouse)
        <li class="nav-item">
          <a class="mx-5 nav-link {{(Request::url() === route('requests.individual', $warehouse->name)) ? 'active bg-gradient-info' : '' }}"
            href="{{route('requests.individual', $warehouse->name)}}">
            <span class="text-bold">{{ucwords($warehouse->name)}}</span>
          </a>
        </li>
        @endforeach
      </div>

      @if(auth()->user()->role == 'admin' || auth()->user()->role == 'accountant')
      <li class="nav-item mt-3">
        <h5 class="ps-4 ms-2 text-uppercase title-nav">Accounting</h5>
      </li>
      <li class="nav-item mt-3">
        <h6 class="title-sub-nav">Transactions</h6>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('accounts*') ? 'active bg-gradient-info' : '' }}"
          href="{{ route('accounts') }}">
          <span><i class="fa-solid fa-calculator"></i></span>
          Accounts
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('journal_vouchers*') ? 'active bg-gradient-info' : '' }}"
          href="{{ route('journal_vouchers') }}">
          <span><i class="fa-solid fa-cash-register"></i></span>
          Journal Vouchers
        </a>
      </li>

      <li class="nav-item mt-3">
        <h6 class="title-sub-nav">Purchase</h6>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('suppliers*') ? 'active bg-gradient-info' : '' }}"
          href="{{ route('suppliers') }}">
          <span><i class="fa-solid fa-users"></i></span>
          Suppliers
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('receipts*') ? 'active bg-gradient-info' : '' }}"
          href="{{ route('receipts') }}">
          <span><i class="fa-solid fa-receipt"></i></span>
          Receipts
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('payments*') ? 'active bg-gradient-info' : '' }}"
          href="{{ route('payments') }}">
          <span><i class="fa-solid fa-money-bill"></i></span>
          Payments
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('voc*') ? 'active bg-gradient-info' : '' }}" href="{{ route('voc') }}">
          <span><i class="fa-solid fa-cart-shopping"></i></span>
          VOC
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('debit_notes*') ? 'active bg-gradient-info' : '' }}"
          href="{{ route('debit_notes') }}">
          <span><i class="fa-solid fa-percent"></i></span>
          Debit Notes
        </a>
      </li>

      <li class="nav-item mt-3">
        <h6 class="title-sub-nav">Sales</h6>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('clients*') ? 'active bg-gradient-info' : '' }}"
          href="{{ route('clients') }}">
          <span><i class="fa-solid fa-users"></i></span>
          Clients
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('invoices*') ? 'active bg-gradient-info' : '' }}"
          href="{{ route('invoices') }}">
          <span><i class="fa-solid fa-receipt"></i></span>
          Invoices
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('cash_receipts*') ? 'active bg-gradient-info' : '' }}"
          href="{{ route('cash_receipts') }}">
          <span><i class="fa-solid fa-money-bill"></i></span>
          Cash Receipts
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('credit_notes*') ? 'active bg-gradient-info' : '' }}"
          href="{{ route('credit_notes') }}">
          <span><i class="fa-solid fa-percent"></i></span>
          Credit Notes
        </a>
      </li>

      <li class="nav-item mt-3">
        <h5 class="ps-4 ms-2 text-uppercase title-nav">Admin</h5>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('currencies*') ? 'active bg-gradient-info' : '' }}"
          href="{{ route('currencies') }}">
          <span><i class="fa-solid fa-coins"></i></span>
          Currencies
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('taxes*') ? 'active bg-gradient-info' : '' }}"
          href="{{ route('taxes') }}">
          <span><i class="fa-solid fa-landmark"></i></span>
          Taxes
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('users*') ? 'active bg-gradient-info' : '' }}"
          href="{{ route('users') }}">
          <span><i class="fa-solid fa-users"></i></span>
          Users
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('warehouses*') ? 'active bg-gradient-info' : '' }}"
          href="{{ route('warehouses') }}">
          <span><i class="fa-solid fa-warehouse"></i></span>
          Warehouses
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('statistics*') ? 'active bg-gradient-info' : '' }}"
          href="{{ route('statistics') }}">
          <span><i class="fa-solid fa-chart-pie"></i></span>
          Statistics
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('backup*') ? 'active bg-gradient-info' : '' }}"
          href="{{ route('backup') }}">
          <span><i class="fa-solid fa-database"></i></span>
          Backup
        </a>
      </li>
      @endif
    </ul>
  </div>
</aside>