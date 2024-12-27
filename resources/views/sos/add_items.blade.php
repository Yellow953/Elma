@extends('layouts.app')

@section('title', 'so')

@section('sub-title', 'add_items')

@section('content')

<script src="{{asset('assets/js/so.js')}}"></script>

<div class="container-fluid my-5">
    <div class="row">
        <div class="col-md-6">
            <div class="card p-3 m-1">
                <div class="card-header px-2">
                    <h4 class="font-weight-bolder">Add Item</h4>
                    <div class="d-flex justify-content-between">
                        <h5>Search</h5>
                        <form action="" method="POST">
                            <input type="text" class="form-control border" placeholder="Search Items" id="live_search"
                                name="live_search">
                        </form>
                    </div>
                </div>
                <div class="card-body max-h-custom">

                    <table class="table table-hover" id="live_result">
                    </table><!-- end of table -->
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-3 m-1 mb-2">
                <div class="card-header p-2">
                    <h4 class="font-weight-bolder">Itemcode</h4>
                </div>
                <div class="card-body p-1">
                    <form id="search-form">
                        @csrf
                        <input type="text" name="search" id="search" placeholder="Search..." autofocus
                            class="form-control border">
                    </form>
                </div>
            </div>

            <div class="card p-3 m-1">
                <div class="card-header p-2">
                    <h4 class="font-weight-bolder">{{ $so->name }}</h4>
                    <div class="d-flex justify-between">
                        <div class="mx-2">Project: {{ucwords($so->project->name)}}</div>
                        <div class="mx-2">Technician: {{ucwords($so->technician)}}</div>
                        <div class="mx-2">Description: {{$so->description}}</div>
                    </div>
                </div>
                <div class="card-body p-2">
                    <form action="{{ route('so.SaveItems', $so->id) }}" method="post">

                        {{ csrf_field() }}
                        {{ method_field('post') }}

                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">Item</th>
                                    <th class="text-center">Quantity</th>
                                </tr>
                            </thead>

                            <tbody class="so-list">
                            </tbody>

                            @foreach ($so_items as $so_item)
                            <tr>
                                <td>{{$so_item->item->itemcode}}</td>
                                <td class="text-center">{{number_format($so_item->quantity, 2)}}</td>
                            </tr>
                            @endforeach
                        </table><!-- end of table -->

                        <div class="w-100 text-end" id="end_result">
                            <button class="btn btn-info btn-block my-3 ignore-confirm"
                                id="add-so-form-btn">Save</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- requests --}}
            <div class="card p-3 m-1 my-3">
                <div class="card-body">
                    <h5>Requests ({{ $requests->count() }})</h5>
                    @foreach ($requests as $r)
                    <div class="bg-light rounded p-3 m-1">
                        <span class="text-sm">
                            {{ucwords($r->user->name)}}
                            is requesting to remove
                            {{number_format($r->quantity, 2)}} of
                            {{$r->item->itemcode}}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
            {{-- end requests --}}
        </div>
    </div>
</div>

{{-- <div class="scroll">
    <a href="#live_search" class="btn my-3 text-info">
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
            class="bi bi-arrow-up-circle-fill" viewBox="0 0 16 16">
            <path
                d="M16 8A8 8 0 1 0 0 8a8 8 0 0 0 16 0zm-7.5 3.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z" />
        </svg>
    </a>
    <a href="#end_result" class="btn my-3 text-info">
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
            class="bi bi-arrow-down-circle-fill" viewBox="0 0 16 16">
            <path
                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z" />
        </svg>
    </a>
</div> --}}

{{-- itemcode search --}}
<script>
    // disable enter key
                // $(document).ready(function() {
                //     $(window).keydown(function(event){
                //         if(event.keyCode == 13) {
                //         event.preventDefault();
                //         return false;
                //         }
                //     });
                // });
            
                $("#search").on("input", function () {
                var searchTerm = $("#search").val();
                
                $.ajax({
                    type: "GET",
                    url: "{{ route('so.search') }}",
                    data: { search: searchTerm,  so_id: {{ $so->id }} },
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        item = $(`#item-${data.id}`);
            
                        var html = `<tr>
                                    <td>${item.data("name")}</td>
                                    <td><input type="number" step="any" min="0" name="items[${item.data(
                                        "id"
                                    )}][quantity]" class="form-control input-sm item-quantity border" min="1" value="1"></td>
                                    <td><button class="btn btn-danger remove-item-btn" data-id="${item.data(
                                        "id"
                                    )}"><i class="fa-solid fa-trash"></i></button></td>
                                </tr>`;
                        $(".so-list").append(html);
            
                        // clear form
                        $("#search").val('');
                    },
                    error: function(xhr, status, error) {
                        // handle error response
                    }
                });
            });
</script>
{{-- end barcode search --}}

{{-- live search --}}
<script>
    $(document).ready(function() {
                    $('#live_search').on('keyup', function() {
                    liveSearch();
                    });

                    liveSearch();
                });

                function liveSearch() {
                    var liveSearchValue = $('#live_search').val();
                    $.ajax({
                    url: '{{ route("so.live_search") }}',
                    method: 'GET',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        live_search: liveSearchValue,
                        so_id: {{$so->id}},
                    },
                    success: function(data) {
                        generateTableRows(data);
                    },
                    });
                }

                function generateTableRows(data) {
                let htmlView = '';

                if (data.length <= 0) {
                    htmlView += `
                    <tr>
                        <th class="w-300">Itemcode</th>
                        <th class="text-center">Quantity</th>
                        <th>Add</th>
                    </tr>   
                    <tr>
                        <td colspan="3">No data.</td>
                    </tr>`;
                } else {
                    htmlView += `
                    <tr>
                        <th class="w-300">Itemcode</th>
                        <th class="text-center">Quantity</th>
                        <th>Add</th>
                    </tr>`;

                    var existingItemIds = []; // Array to store existing item IDs

                    $(".so-list tr").each(function () {
                    var itemId = $(this).find(".remove-item-btn").data("id");
                    existingItemIds.push(itemId);
                    });

                    for (let i = 0; i < data.length; i++) {
                    if (existingItemIds.includes(data[i].id)) {
                        continue; // Skip if the item ID already exists
                    }

                    htmlView += `
                        <tr>
                        <td class="word-break">${data[i].itemcode}</td>
                        <td class="text-center">${data[i].quantity}</td>
                        <td>
                            <a href="" id="item-${data[i].id}" data-name="${data[i].itemcode}"
                            data-id="${data[i].id}"                             class="btn bg-success btn-success add-item-btn">
                            <i class="fa-solid fa-plus"></i>
                            </a>
                        </td>
                        </tr>
                    `;
                    }
                }
                $('#live_result').html(htmlView);
                }
</script>
{{-- end live search --}}

<script>
    // Add item btn
                $("body").on("click", ".add-item-btn", function (e) {
                    e.preventDefault();
                    var name = $(this).data("name");
                    var id = $(this).data("id");
                    
                    $(this).removeClass("btn-success bg-success").addClass("btn-default disabled");

                    var html = `
                        <tr>
                        <td>${name}</td>
                        <td>
                            <input type="number" step="any" min="0" name="items[${id}][quantity]" class="form-control input-sm item-quantity border" value="1">
                        </td>
                        ><td>
                            <button class="btn btn-danger remove-item-btn" data-id="${id}"><i class="fa-solid fa-trash"></i></button>
                        </td>
                        </tr>`;

                    $(".so-list").append(html);
                });
</script>
@endsection