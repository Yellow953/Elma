<!-- The Modal -->
<div class="modal" id="batch">
    <!-- Modal content -->
    <div class="modal-content">
        <div class="modal-header bg-info text-dark">
            <h2 class="modal-title">Batch Post</h2>
            <span class="close" onclick="closeModal('batch')">&times;</span>
        </div>
        <div class="modal-body">
            <form action="{{ route('journal_vouchers.batch_post') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="input-group input-group-outline my-2">
                    <div class="w-100">
                        <label for="batch">Batch</label>
                        <div>
                            <input type="text" class="form-control border" name="batch" placeholder="Batch"
                                value="{{request()->query('batch')}}">
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    <button type="submit" class="btn btn-info py-2 px-3 mx-2 text-dark">Post</button>
                </div>
            </form>
        </div>
    </div>
</div>