@if (auth()->user()->role == 'admin')
<div class="fixed-plugin sidedrawer">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2 ignore-confirm" title="Settings">
        <i class="fa-solid fa-gear"></i>
    </a>
    <div class="card shadow-lg sidedrawer-body custom-scroller">
        <div class="card-header pb-0 pt-3">
            <div class="float-start">
                <h5 class="mt-3 mb-0">Settings</h5>
            </div>
            <div class="float-end mt-4">
                <button class="btn btn-link text-dark p-0 fixed-plugin-close-button ignore-confirm">
                    <i class="fa-solid fa-xmark" style="font-size: 20px"></i>
                </button>
            </div>
            <!-- End Toggle Button -->
        </div>
        <hr class="horizontal dark my-1">
        <div class="card-body pt-sm-3 pt-0">
            @php
            $company = Helper::get_company();
            @endphp

            <!-- System Behaviour -->
            <h6 class="mt-4 mb-2">System Behaviour</h6>

            <form action="{{ route('company.toggle_allow_past_dates') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <button type="submit" class="btn btn-shadow-none d-flex my-auto">
                    <div class="my-auto mx-2">Allow Past Dates</div>
                    <label class="switch my-auto">
                        <input type="checkbox" {{ $company->allow_past_dates ? 'checked' : '' }}>
                        <span class="slider round"></span>
                    </label>
                </button>
            </form>

            <form action="{{ route('currencies.switch') }}" method="POST">
                @csrf

                @php
                $currencies = Helper::get_currencies();
                @endphp

                <input type="hidden" name="currency_id"
                    value="{{ Auth::user()->currency_id == $currencies[0]->id ? $currencies[1]->id : $currencies[0]->id }}">

                <button type="submit" class="btn btn-shadow-none d-flex my-auto">
                    <div class="my-auto mx-2">{{ $currencies[0]->code }}</div>
                    <label class="switch my-auto">
                        <input type="checkbox" name="active" {{ Auth::user()->currency_id == $currencies[1]->id ?
                        'checked' : '' }}>
                        <span class="slider round"></span>
                    </label>
                    <div class="my-auto mx-2">{{ $currencies[1]->code }}</div>
                </button>
            </form>

            <!-- Company Information -->
            <h6 class="mt-4 mb-2">Company Information</h6>

            <form method="POST" action="{{ route('company.update') }}" enctype="multipart/form-data">
                @csrf
                <label for="name">Name *</label>
                <div class="input-group input-group-outline mb-2">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                        value="{{ $company->name }}" required autocomplete="name" autofocus>
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <label for="email">Email *</label>
                <div class="input-group input-group-outline mb-2">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ $company->email }}" required autocomplete="email">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <label for="phone">Phone Number *</label>
                <div class="input-group input-group-outline mb-2">
                    <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone"
                        value="{{ $company->phone }}" required autocomplete="phone">
                    @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <label for="address">Address *</label>
                <div class="input-group input-group-outline mb-2">
                    <input id="address" type="text" class="form-control @error('address') is-invalid @enderror"
                        name="address" value="{{ $company->address }}" required autocomplete="address">
                    @error('address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <label for="vat_number">Vat Number</label>
                <div class="input-group input-group-outline mb-2">
                    <input id="vat_number" type="number" class="form-control @error('vat_number') is-invalid @enderror"
                        name="vat_number" value="{{ $company->vat_number }}" min="0" autocomplete="vat_number">
                    @error('vat_number')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <label for="website">Website</label>
                <div class="input-group input-group-outline mb-2">
                    <input id="website" type="text" class="form-control @error('website') is-invalid @enderror"
                        name="website" value="{{ $company->website }}" autocomplete="website">
                    @error('website')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <label for="image">Logo</label>
                <div class="input-group input-group-outline mb-2">
                    <input id="image" type="file" class="form-control @error('image') is-invalid @enderror"
                        name="image">

                    @error('image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="monthly_growth_factor">Growth Factor
                        <span class="info-button" data-toggle="tooltip" data-placement="right"
                            title="The growth factor represents the company's monthly growth. For example, a growth factor of 1.0 means no growth, 1.1 means a 10% growth, and below 1.0 indicates a decline.">
                            <i class="fas fa-info-circle"></i>
                        </span>
                    </label>
                    <input type="range" class="form-control-range growth-factor-input" id="monthly_growth_factor"
                        min="0" max="10" step="0.01" value="{{ $company->monthly_growth_factor }}"
                        oninput="updateGrowthFactor()">
                </div>
                <div id="growthFactorValue" class="growth-factor-value">
                    Growth Factor: <span id="factorDisplay">1.0</span>
                </div>

                <div class="d-flex mt-4">
                    <button id="form_submit" class="btn btn-info btn-block w-100" type="submit">Save
                        Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    @if (!$company->allow_past_dates)
    
        var today = new Date();

        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();

        today = yyyy + '-' + mm + '-' + dd;

        var inputs = document.getElementsByClassName("date-input");

        for (var i = 0; i < inputs.length; i++) {
            inputs[i].min = today;
        }
    
    @endif

    function updateGrowthFactor() {
      var rangeInput = document.getElementById('monthly_growth_factor');
      var factorDisplay = document.getElementById('factorDisplay');
      var growthFactorValue = document.getElementById('growthFactorValue');

      var value = parseFloat(rangeInput.value).toFixed(2);
      factorDisplay.textContent = value;

      if (value >= 1.0) {
        growthFactorValue.style.color = 'green';
      } else {
        growthFactorValue.style.color = 'red';
      }
    }

    updateGrowthFactor();
</script>
@endif