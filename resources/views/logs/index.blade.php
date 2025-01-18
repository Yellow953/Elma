@extends('layouts.app')

@section('title', 'logs')

@section('actions')
@can('logs.export')
<a class="btn btn-sm btn-info mx-1" href="{{ route('logs.export') }}">Export Logs</a>
@endcan
@endsection

@section('filter')
<button class="btn btn-secondary py-2 px-3 mx-2 text-dark ignore-confirm" type="button" id="filterDropdown"
    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Filter
</button>
<div class="dropdown-menu dropdown-menu-right mt-2 p-4" aria-labelledby="filterDropdown" style="width: 300px">
    <h4 class="mb-2">Filter Logs</h4>
    <form action="{{ route('logs') }}" method="get" enctype="multipart/form-data">
        @csrf

        <div class="input-group input-group-outline my-2">
            <div class="w-100">
                <label for="text">Text</label>
                <div>
                    <input type="text" class="form-control border" name="text" placeholder="Text"
                        value="{{request()->query('text')}}">
                </div>
            </div>
        </div>
        <div class="input-group input-group-outline my-2">
            <div class="w-100">
                <label for="startDate">Start Date</label>
                <div>
                    <input type="date" class="form-control border" name="startDate"
                        value="{{request()->query('startDate')}}">
                </div>
            </div>
        </div>
        <div class="input-group input-group-outline my-2">
            <div class="w-100">
                <label for="endDate">End Date</label>
                <div>
                    <input type="date" class="form-control border" name="endDate"
                        value="{{request()->query('endDate')}}">
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-around mt-3">
            <button type="reset"
                class="btn btn-secondary py-2 px-3 mx-2 text-dark ignore-confirm reset-button">reset</button>
            <button type="submit" class="btn btn-info py-2 px-3 mx-2 text-dark">apply</button>
        </div>
    </form>
</div>
@endsection

@section('content')
<!-- End Navbar -->
<div class="container-fluid py-2">
    <div class="d-flex align-items-center justify-content-end">
        @yield('actions')

        @yield('filter')
    </div>

    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <div class="card mt-4" id="logs">
                <div class="card-header p-4">
                    <h5 class="mb-0">Logs</h5>
                </div>
                <div class="card-body p-5 py-0">
                    <div class="timeline">
                        @forelse ($logs as $l)
                        <div class="timeline-item">
                            <div
                                class="alert alert-secondary alert-{{Str::contains($l->text, 'edited') ? 'warning' : ''}} alert-dismissible text-white mx-0">
                                <span class="text-sm">{{$l->text}}</span>
                            </div>
                        </div>
                        @empty
                        <div class="m-5 ">
                            No Logs Found
                        </div>
                        @endforelse
                    </div>
                    <div class="w-50">{{ $logs->appends(request()->all())->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection