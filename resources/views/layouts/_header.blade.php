@php
$user = auth()->user();
$currencies = Helper::get_currencies();
@endphp

<!-- header area start -->
<header class="my-1 mx-1 mx-md-3">
    <div class="container-fluid border-0 border-radius-xl m-1 m-md-2 py-1 px-3 bg-gradient-dark">
        <div class="d-flex justify-content-between align-items-center py-2">
            <form action="{{ route('navigate') }}" method="POST" enctype="multipart/form-data" id="redirectForm">
                @csrf
                <input type="hidden" name="route" value="">
                <input type="text" name="routes-search" id="routes-search" class="typeahead tt-query" autocomplete="off"
                    spellcheck="false" value="{{ request()->query('routes-search') }}">
            </form>

            <div class="user-profile pull-right m-0 d-flex px-1 px-md-3">
                <div class="d-flex align-items-center dropdown-toggle text-white" data-toggle="dropdown">
                    <img class="avatar user-thumb" src="{{ asset('assets/images/default_profile.png') }}" alt="avatar">
                    <h5 class="d-none d-md-block user-name text-white mx-2 my-auto">{{
                        ucwords($user->name) }}</h5>
                </div>

                <div class="dropdown-menu dropdown-menu-right mt-4">
                    <a href="{{ route('profile') }}" class="dropdown-item text-dark">{{ ucwords($user->name)
                        }}</a>
                    
                    <a href="#" class="dropdown-item text-dark" id="currencyDropdown" role="button" 
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex justify-content-between px-2">
                            Currency
                            <span>{{ $user->currency->code }}</span>
                        </span>
                    </a>
                    <!-- Begin: Menu sub -->
                    <div class="dropdown-menu w-100" aria-labelledby="currencyDropdown">
                        @foreach ($currencies as $currency)
                            <!-- Begin: Menu item -->
                            <a class="dropdown-item" href="{{ route('currencies.switch', $currency->id) }}">
                                {{ $currency->code }}
                            </a>
                            <!-- End: Menu item -->
                        @endforeach
                    </div>
                    <!-- End: Menu sub -->

                    <a class="dropdown-item text-dark" href="{{ route('logout') }}"
                        onclick="event.preventDefault();document.getElementById('logout-form').submit();"> {{
                        __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- header area end -->

<script>
    // start typeahead
    $(document).ready(function(){
        var routes = <?php echo json_encode(Helper::get_route_names()); ?>;

        var routes = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            local: routes
        });

        $('#routes-search').typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        },
        {
            name: 'routes',
            source: routes
        });

        $('#routes-search').on('typeahead:selected', function(event, suggestion, dataset) {
            $('#redirectForm input[name="route"]').val(suggestion);
            $('#redirectForm').submit();
        });
    });
    // end typeahead
</script>
