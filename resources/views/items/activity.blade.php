@extends('layouts.app')

@section('title', 'items')

@section('sub-title', 'activity')

@section('content')
<div class="container-fluid py-2">
  <div class="row">
    <div class="offset-1 col-10">
      <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3">
          <div class="bg-gradient-info shadow-info border-radius-lg pt-4 pb-3">
            <h5 class="text-capitalize ps-3">Item Activity ({{$item->itemcode}})</h5>
            <h5 class="mx-5">Quantity: {{number_format($item->quantity, 2)}} </h5>
          </div>
        </div>
        <div class="card-body px-3 pb-4">
          <div class="timeline">
            @forelse ($logs as $l)
            <div class="timeline-item">
              <p class="text-center alert alert-warning py-1 m-0">{{$l->text}}</p>
            </div>
            @empty
            <div class="mx-4">
              No Activity Yet
            </div>
            @endforelse
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection