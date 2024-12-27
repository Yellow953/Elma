<nav class="navbar navbar-main navbar-expand-lg p-0 mx-4 mb-2 shadow-none" id="navbarBlur" navbar-scroll="true">
    <div class="navigation">
        <div class="navigation-links">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i>
                        Dashboard</a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route(View::yieldContent('title')) }}">{{
                        Helper::format_text(View::yieldContent('title')) }}</a></li>
                @if (!empty(View::yieldContent('sub-title')))
                <li class="breadcrumb-item">{{ Helper::format_text(View::yieldContent('sub-title')) }}</li>
                @endif
            </ol>
            <a href="{{ url()->previous() }}" class="btn btn-secondary btn-custom px-3 text-white">
                <i class="fa-solid fa-caret-left"></i>
                back
            </a>
        </div>
        <div>
            <ul class="navbar-nav justify-content-end">
                <li class="nav-item ps-3 d-flex d-xl-none align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0 text-info" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </li>
            </ul>
            <h3 class="mt-2">{{ Helper::format_text(View::yieldContent('title')) }}</h3>
        </div>
    </div>
</nav>