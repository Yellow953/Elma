@extends('layouts.app')

@section('title', 'accounts')

@section('sub-title', 'New')

@section('content')
<div class="inner-container">
    <div class="card">
        <div class="card-header bg-info border-b">
            <h4 class="font-weight-bolder">New Account</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('accounts.create') }}" enctype="multipart/form-data">
                @csrf

                <div class="input-group input-group-outline row my-3">
                    <label for="account_number" class="col-md-5 col-form-label text-md-end">{{ __('Account Number *')
                        }}</label>

                    <div class="col-md-6">
                        <input id="account_number" type="text"
                            class="form-control @error('account_number') is-invalid @enderror" name="account_number"
                            required autocomplete="account_number" value="{{ old('account_number') }}" autofocus>

                        @error('account_number')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="currency_id" class="col-md-5 col-form-label text-md-end">{{ __('Currency *') }}</label>

                    <div class="col-md-6">
                        <select name="currency_id" id="currency_id" class="form-select select2">
                            <option value=""></option>
                            @foreach (Helper::get_currencies() as $currency)
                            <option value="{{ $currency->id }}" {{ old('currency_id')==$currency->id ? 'selected' : ''
                                }}>
                                {{ ucwords($currency->code) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="account_description" class="col-md-5 col-form-label text-md-end">{{ __('Account
                        Description *') }}</label>

                    <div class="col-md-6">
                        <input id="account_description" type="text"
                            class="form-control @error('account_description') is-invalid @enderror"
                            name="account_description" required value="{{ old('account_description') }}">

                        @error('account_description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="type" class="col-md-5 col-form-label text-md-end">{{ __('Type *') }}</label>

                    <div class="col-md-6">
                        <select name="type" id="type" class="form-select select2" required>
                        </select>
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="sub1" class="col-md-5 col-form-label text-md-end">{{ __('Sub 1') }}</label>

                    <div class="col-md-6">
                        <select name="sub1" id="sub1" class="form-select select2"></select>
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="sub2" class="col-md-5 col-form-label text-md-end">{{ __('Sub 2') }}</label>

                    <div class="col-md-6">
                        <select name="sub2" id="sub2" class="form-select select2"></select>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="offset-md-8 col-md-4">
                        <button type="submit" class="btn btn-info w-100">
                            {{ __('Create') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#account_number').inputmask('****-****-******', { placeholder: ' ' });
    });

    const userCurrencyId = "{{ auth()->user()->currency_id ?? '' }}";
    if (userCurrencyId) {
        document.getElementById('currency_id').value = userCurrencyId;
        document.getElementById('currency_id').dispatchEvent(new Event('input'));
    }

    const accountTypes = @json($account_types);

    function populateSelect(selectElement, options) {
        selectElement.innerHTML = '<option value="">Select</option>';
        options.forEach(option => {
            const opt = document.createElement('option');
            opt.value = option.id;
            opt.textContent = option.name;
            selectElement.appendChild(opt);
        });

        $(selectElement).select2();
    }

    const typeSelect = document.getElementById('type');
    const sub1Select = document.getElementById('sub1');
    const sub2Select = document.getElementById('sub2');

    const types = accountTypes.filter(type => type.level === 1);
    populateSelect(typeSelect, types);

    $('#type').on('select2:select', function() {
        const selectedTypeId = parseInt(this.value); 
        const sub1Options = accountTypes.filter(type => parseInt(type.parent_id) === selectedTypeId);
        populateSelect(sub1Select, sub1Options);
        
        populateSelect(sub2Select, []);  
    });

    $('#sub1').on('select2:select', function() {
        const selectedSub1Id = parseInt(this.value); 
        const sub2Options = accountTypes.filter(type => parseInt(type.parent_id) === selectedSub1Id);
        populateSelect(sub2Select, sub2Options);
    });
</script>
@endsection