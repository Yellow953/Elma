<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{asset('/assets/images/logos/logo.png')}}">

    <title>
        Stockify | Company Setup
    </title>

    <link rel="shortcut icon" href="{{asset('assets/images/logos/logo.png')}}" type="image/x-icon">

    {{-- Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Code+Pro:wght@500&display=swap" rel="stylesheet">

    <!-- CSS Files -->
    <link id="pagestyle" href="{{asset('/assets/css/material-dashboard.css?v=3.0.2')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('/assets/css/custom.css')}}">
</head>

<body>
    <main class="main-content">
        <div class="page-header align-items-start min-vh-100"
            style="background-image: url({{ asset('/assets/images/warehouse.png')}});">
            <div class="container my-auto">
                <div class="row">
                    <div class="col-md-6 mx-auto">
                        <div class="card">
                            <div class="card-header p-0 position-relative mt-n4 mx-3">
                                <div class="bg-gradient-info shadow-info border-radius-lg py-3 pe-1">
                                    <h4 class="text-dark font-weight-bolder text-center mb-2">Company Setup</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('settings.create') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="login-form-body">
                                        @include('layouts._flash')

                                        <div class="px-4" style="height: 40vh; overflow: auto;">
                                            <label for="name">Name *</label>
                                            <div class="input-group input-group-outline mb-2">
                                                <input id="name" type="text"
                                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                                    value="{{ old('name') }}" required autocomplete="name" autofocus>
                                                @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <label for="email">Email *</label>
                                            <div class="input-group input-group-outline mb-2">
                                                <input id="email" type="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    name="email" value="{{ old('email') }}" required
                                                    autocomplete="email">
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <label for="phone">Phone Number *</label>
                                            <div class="input-group input-group-outline mb-2">
                                                <input id="phone" type="text"
                                                    class="form-control @error('phone') is-invalid @enderror"
                                                    name="phone" value="{{ old('phone') }}" required
                                                    autocomplete="phone">
                                                @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <label for="address">Address *</label>
                                            <div class="input-group input-group-outline mb-2">
                                                <input id="address" type="text"
                                                    class="form-control @error('address') is-invalid @enderror"
                                                    name="address" value="{{ old('address') }}" required
                                                    autocomplete="address">
                                                @error('address')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <label for="vat_number">Vat Number</label>
                                            <div class="input-group input-group-outline mb-2">
                                                <input id="vat_number" type="number"
                                                    class="form-control @error('vat_number') is-invalid @enderror"
                                                    name="vat_number" value="{{ old('vat_number') }}" min="0"
                                                    autocomplete="vat_number">
                                                @error('vat_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <label for="website">Website</label>
                                            <div class="input-group input-group-outline mb-2">
                                                <input id="website" type="text"
                                                    class="form-control @error('website') is-invalid @enderror"
                                                    name="website" value="{{ old('website') }}" autocomplete="website">
                                                @error('website')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <label for="image">Logo</label>
                                            <div class="input-group input-group-outline mb-2">
                                                <input id="image" type="file"
                                                    class="form-control @error('image') is-invalid @enderror"
                                                    name="image">

                                                @error('image')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="monthly_growth_factor">Growth Factor *
                                                    <span class="info-button" data-toggle="tooltip"
                                                        data-placement="right"
                                                        title="The growth factor represents the company's monthly growth. For example, a growth factor of 1.0 means no growth, 1.1 means a 10% growth, and below 1.0 indicates a decline.">
                                                        <i class="fas fa-info-circle"></i>
                                                    </span>
                                                </label>
                                                <input type="range" required
                                                    class="form-control-range growth-factor-input"
                                                    id="monthly_growth_factor" min="0" max="10" step="0.01"
                                                    value="{{ $company->monthly_growth_factor }}"
                                                    oninput="updateGrowthFactor()">
                                            </div>
                                            <div id="growthFactorValue" class="growth-factor-value">
                                                Growth Factor: <span id="factorDisplay">1.0</span>
                                            </div>


                                            <div class="my-4 d-flex align-items-center">
                                                <input id="allow_past_dates" type="checkbox" class="mx-2"
                                                    name="allow_past_dates" checked>
                                                <label for="allow_past_dates" class="my-auto">Allow Past Dates</label>
                                            </div>
                                        </div>

                                        <div class="w-100">
                                            <button id="form_submit" class="btn btn-info w-100"
                                                type="submit">Continue</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
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
</body>

</html>