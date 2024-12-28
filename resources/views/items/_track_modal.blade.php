<!-- The Modal -->
<div class="modal" id="item_track_modal">
    <!-- Modal content -->
    <div class="modal-content">
        <div class="modal-header bg-info text-dark">
            <h2 class="modal-title">Track Item Serial Number</h2>
            <span class="close" onclick="closeModal('item_track_modal')">&times;</span>
        </div>
        <div class="modal-body">
            <form action="{{ route('items.track') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group input-group-outline my-2">
                            <div class="w-100">
                                <label for="item_id">Item *</label>
                                <div>
                                    <select name="item_id" class="form-control select2" required>
                                        <option value=""></option>
                                        @foreach (Helper::get_items() as $item)
                                        <option value="{{ $item->id }}" {{ request()->query('item_id') == $item->id ?
                                            'selected' : '' }}>{{ ucwords($item->itemcode) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="input-group input-group-outline my-2">
                            <div class="w-100">
                                <label for="serial_number">Serial Number *</label>
                                <div>
                                    <input id="serial_number" type="text" class="form-control border"
                                        name="serial_number" value="{{ request()->query('serial_number')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    <button type="submit" class="btn btn-info py-2 px-3 mx-2 text-dark">Track</button>
                </div>
            </form>
        </div>
    </div>
</div>
