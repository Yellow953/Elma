@extends('layouts.app')

@section('title', 'projects')

@section('sub-title', 'so')

@section('content')
<div class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="offset-md-1 col-md-10 mt-2">
                <div class="card">
                    <div class="card-header bg-info border-b">
                        <h4 class="font-weight-bolder mx-5">Project SOs</h4>
                    </div>
                    <div class="card-body">
                        @forelse ($sos as $so)
                        <div class="alert alert-light m-1">
                            <div class="row w-100 text-center align-items-center">
                                <div class="col-4">
                                    <h4>{{ $so->name }}</h4>
                                </div>
                                <div class="col-4">
                                    <h4 class="text-secondary">{{ $so->date }}</h4>
                                </div>
                                <div class="col-4">
                                    <a href="{{ route('so.show', $so->id) }}" class="btn btn-info">Details</a>
                                </div>
                            </div>
                        </div>
                        @empty
                        No SOs yet
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection