<!-- The Modal -->
<div class="modal" id="closing_modal">
    <!-- Modal content -->
    <div class="modal-content">
        <div class="modal-header bg-info text-dark">
            <h2 class="modal-title">Closing</h2>
            <span class="close" onclick="closeModal('closing_modal')">&times;</span>
        </div>
        <div class="modal-body">
            <form action="{{ route('accounts.closing') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-2">
                            <div class="w-100">
                                <label for="from_account">From Account *</label>
                                <div>
                                    <input id="from_account" type="text" class="form-control border" name="from_account"
                                        required value="{{request()->query('from_account')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-2">
                            <div class="w-100">
                                <label for="to_account">To Account *</label>
                                <div>
                                    <input id="to_account" type="text" required class="form-control border"
                                        name="to_account" value="{{request()->query('to_account')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-2">
                            <div class="w-100">
                                <label for="from_date">From Date *</label>
                                <div>
                                    <input id="from_date" type="date" required class="form-control border"
                                        name="from_date" value="{{request()->query('from_date')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-2">
                            <div class="w-100">
                                <label for="to_date">To Date *</label>
                                <div>
                                    <input id="to_date" type="date" class="form-control border" name="to_date" required
                                        value="{{request()->query('to_date')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-2">
                            <div class="w-100">
                                <label for="profit_account">Profit Account *</label>
                                <div>
                                    <select name="profit_account" id="profit_account" required
                                        class="form-select select2">
                                        <option value=""></option>
                                        @foreach (Helper::get_accounts() as $account)
                                        <option value="{{ $account->id }}" {{ request()->query('profit_account') ==
                                            $account->id ? 'selected' : '' }}>{{ $account->account_number }} | {{
                                            $account->account_description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-2">
                            <div class="w-100">
                                <label for="loss_account">Loss Account *</label>
                                <div>
                                    <select name="loss_account" id="loss_account" required class="form-select select2">
                                        <option value=""></option>
                                        @foreach (Helper::get_accounts() as $account)
                                        <option value="{{ $account->id }}" {{ request()->query('loss_account') ==
                                            $account->id ? 'selected' : '' }}>{{ $account->account_number }} | {{
                                            $account->account_description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="offset-md-3 col-md-6">
                        <div class="input-group input-group-outline my-2">
                            <div class="w-100">
                                <label for="closing_datetime">Closing DateTime *</label>
                                <div>
                                    <input id="closing_datetime" type="datetime-local" class="form-control border"
                                        name="closing_datetime" required
                                        value="{{request()->query('closing_datetime')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    <button type="submit" class="btn btn-info py-2 px-3 mx-2 text-dark">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#from_account').inputmask('****-****-******', { placeholder: ' ' });
        $('#to_account').inputmask('****-****-******', { placeholder: ' ' });
    });
</script>