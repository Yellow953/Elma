@extends('layouts.app')

@section('title', 'accounts')

@section('sub-title', 'Statement Of Account')

@section('content')
<div class="container pt-5">
    <div class="modal-content">
        <div class="modal-header bg-info text-dark">
            <h2 class="modal-title">Trial Balance</h2>
        </div>
        <div class="modal-body">
            <form action="{{ route('accounts.trial_balance') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-2">
                            <div class="w-100">
                                <label for="from_account">From Account *</label>
                                <div>
                                    <input id="tb_from_account" type="text" class="form-control border"
                                        name="from_account" required value="{{request()->query('from_account')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-2">
                            <div class="w-100">
                                <label for="to_account">To Account</label>
                                <div>
                                    <input id="tb_to_account" type="text" class="form-control border" name="to_account"
                                        value="{{request()->query('to_account')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-2">
                            <div class="w-100">
                                <label for="from_date">From Date</label>
                                <div>
                                    <input id="from_date" type="date" class="form-control border" name="from_date"
                                        value="{{request()->query('from_date')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-outline my-2">
                            <div class="w-100">
                                <label for="to_date">To Date</label>
                                <div>
                                    <input id="to_date" type="date" class="form-control border" name="to_date"
                                        value="{{request()->query('to_date')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group input-group-outline my-2">
                            <div class="w-100">
                                <div>
                                    <input type="checkbox" name="skip_empty" {{request()->query('skip_empty') ?
                                    'checked' : ''}}>
                                    <label for="skip_empty">Skip Empty</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group input-group-outline my-2">
                            <div class="w-100">
                                <div>
                                    <input type="checkbox" name="mvt" {{request()->query('mvt') ? 'checked' : ''}}>
                                    <label for="mvt">MVT</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group input-group-outline my-2">
                            <div class="w-100">
                                <div>
                                    <input type="checkbox" name="bbf" {{request()->query('bbf') ? 'checked' : ''}}>
                                    <label for="bbf">BBF</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    <button type="submit" class="btn btn-info py-2 px-3 mx-2 text-dark">Generate</button>
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
@endsection