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
            <!-- System Behaviour -->
            <h6 class="mb-2">System Behaviour</h6>

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
        </div>
    </div>
</div>

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
