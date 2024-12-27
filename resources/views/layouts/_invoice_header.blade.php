@php
$company = Helper::get_company();
@endphp

<div class="receipt-header">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="receipt-left">
                    <img class="img-responsive logo" alt="Logo" src="{{ asset($company->logo) }}">
                </div>
            </div>
            <div class="col-md-6 text-right">
                <div class="receipt-right">
                    <h5>{{ ucwords($company->name)}}</h5>
                    <p><a href="mailto:{{ $company->email }}" class="text-dark text-decoration-none">{{
                            $company->email }} <i class="fa fa-envelope"></i></a></p>
                    <p><a href="tel:{{ $company->phone }}" class="text-dark text-decoration-none">{{
                            $company->phone }} <i class="fa fa-phone"></i></a></p>

                    <p><a href="#" class="text-dark text-decoration-none">{{ $company->address }} <i
                                class="fa fa-location-arrow"></i></a></p>
                    @if ($company->website)
                    <p><a href="{{ $company->website }}" class="text-dark text-decoration-none">{{
                            $company->website }} <i class="fa fa-globe"></i></a>
                    </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>