@extends('layouts.app')

@section('title', 'so')

@section('sub-title', 'edit')

@section('content')
<div class="inner-container">
    <div class="d-flex justify-content-around">
        <a href="{{ route('projects.new') }}" class="btn btn-info">New Project</a>
    </div>

    <div class="card">
        <div class="card-header bg-info border-b">
            <h4 class="font-weight-bolder">Edit SO</h4>
        </div>
        <div class="card-body p-0 px-3 mt-3">
            <form method="POST" action="{{ route('so.update', $so->id) }}" enctype="multipart/form-data">
                @csrf

                <div class="input-group input-group-outline row my-3">
                    <label for="project_id" class="col-md-5 col-form-label text-md-end">{{ __('Project
                        *') }}</label>

                    <div class="col-md-6">
                        <select name="project_id" id="project_id" required class="form-select select2">
                            <option value=""></option>
                            @foreach ($projects as $project)
                            <option value="{{ $project->id }}" {{ $project->id == $so->project_id ?
                                'selected':'' }}>{{ $project->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="technician" class="col-md-5 col-form-label text-md-end">{{ __('Technician')
                        }}</label>

                    <div class="col-md-6">
                        <input id="technician" type="text"
                            class="form-control @error('technician') is-invalid @enderror" name="technician"
                            value="{{ $so->technician }}" autocomplete="technician">

                        @error('technician')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="job_number" class="col-md-5 col-form-label text-md-end">{{ __('Job Number')
                        }}</label>

                    <div class="col-md-6">
                        <input id="job_number" type="number" min="0"
                            class="form-control @error('job_number') is-invalid @enderror" name="job_number"
                            value="{{ $so->job_number }}" autocomplete="job_number">

                        @error('job_number')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="description" class="col-md-5 col-form-label text-md-end">{{ __('Description')
                        }}</label>

                    <div class="col-md-6">
                        <input id="description" type="text"
                            class="form-control @error('description') is-invalid @enderror" name="description"
                            value="{{ $so->description }}">

                        @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="date" class="col-md-5 col-form-label text-md-end">{{ __('Date') }}</label>

                    <div class="col-md-6">
                        <input id="date" type="date" value="{{$so->date}}"
                            class="form-control date-input @error('date') is-invalid @enderror" name="date">

                        @error('date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-around mt-3">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-info">Submit</button>
                </div>
            </form>

            <h3 class="text-blue text-center mt-4">Items</h3>
            <div class="container">
                <div class="row my-3">
                    <div class="col-md-3">
                        <a href="{{ route('so.so_export_items', $so->id) }}" class="btn btn-info">Export Items</a>
                    </div>

                    <form action="{{ route('so.so_export_items', $so->id) }}" method="POST"
                        enctype="multipart/form-data" class="col-md-9">
                        @csrf
                        <div class="d-flex justify-content-end">
                            <input id="file" type="file"
                                class=" form-control border @error('file') is-invalid @enderror" name="file">

                            @error('file')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                            <button type="submit" class="btn btn-info mx-2">Import Items</button>
                        </div>
                    </form>
                </div>

                <form action="{{ route('so.edit', $so->id) }}" method="get" class="mb-3">
                    @csrf
                    <div class="input-group input-group-outline">
                        <label for="search" class="my-auto">
                            <h4 class="px-5">Item</h4>
                        </label>
                        <input type="text" class="form-control" name="search" value="{{request()->query('search')}}"
                            placeholder="Type here...">
                        <button type="submit" class="btn btn-info m-1 rounded">
                            Search
                        </button>
                    </div>
                </form>

                @if ($soItems->count() != 0)

                @if (!request()->query('search'))
                <div class="row">
                    <div class="offset-9 col-3">
                        <a href="{{ route('so.return_all', $so->id) }}" class="btn btn-danger ignore-confirm">Return
                            All</a>
                    </div>
                </div>
                @endif

                <table class="table table-striped bg-white">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($soItems as $item)
                        <tr>
                            <td>
                                {{$item->item->itemcode}}
                            </td>
                            <td>
                                {{number_format($item->quantity, 2)}}
                            </td>
                            <td>
                                <a href="{{ route('so.return', $item->id) }}"
                                    class="btn btn-danger ignore-confirm">Return</a>
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="3">{{$soItems->links()}}</td>
                        </tr>
                    </tbody>
                </table>
                @else
                <div class="text-center my-5">
                    No Items Found...
                </div><br>
                @endif
            </div>

        </div>
    </div>
</div>

@endsection
