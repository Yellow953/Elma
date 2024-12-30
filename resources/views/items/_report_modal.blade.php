<!-- The Modal -->
<div class="modal" id="item_report_modal">
    <!-- Modal content -->
    <div class="modal-content">
        <div class="modal-header bg-info text-dark">
            <h2 class="modal-title">Item Report</h2>
            <span class="close" onclick="closeModal('item_report_modal')">&times;</span>
        </div>
        <div class="modal-body">
            <form action="{{ route('items.report') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group input-group-outline my-2">
                            <div class="w-100">
                                <label for="item_id[]">Items *</label>
                                <div>
                                    <select name="item_id[]" class="form-control select2" required multiple>
                                        <option value=""></option>
                                        @foreach (Helper::get_items() as $item)
                                        <option value="{{ $item->id }}">{{ ucwords($item->name) }}</option>
                                        @endforeach
                                    </select>
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

                <div class="d-flex justify-content-end mt-3">
                    <button type="submit" class="btn btn-info py-2 px-3 mx-2 text-dark">Generate</button>
                </div>
            </form>
        </div>
    </div>
</div>
