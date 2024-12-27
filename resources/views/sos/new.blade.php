@extends('layouts.app')

@section('title', 'so')

@section('sub-title', 'new')

@section('content')
<div class="inner-container">
    <div class="d-flex justify-content-around">
        <a href="{{ route('projects.new') }}" class="btn btn-info">New Project</a>
    </div>

    <div class="card">
        <div class="card-header bg-info border-b">
            <h4 class="font-weight-bolder">New SO</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('so.create') }}" enctype="multipart/form-data">
                @csrf
                <div class="input-group input-group-outline row my-3">
                    <label for="project_id" class="col-md-5 col-form-label text-md-end">{{ __('Project
                        *') }}</label>

                    <div class="col-md-6">
                        <select name="project_id" id="project_id" required class="form-select select2">
                            <option value=""></option>
                            @foreach ($projects as $project)
                            <option value="{{ $project->id }}" {{ $project->id == old('project_id') ?
                                'selected':'' }}>{{ $project->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3 ">
                    <label for="technician" class="col-md-5 col-form-label text-md-end">{{ __('Technician')
                        }}</label>

                    <div class="col-md-6">
                        <input id="technician" type="text"
                            class="form-control @error('technician') is-invalid @enderror" name="technician"
                            value="{{ old('technician') }}" autocomplete="technician">

                        @error('technician')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3 ">
                    <label for="job_number" class="col-md-5 col-form-label text-md-end">{{ __('Job Number')
                        }}</label>

                    <div class="col-md-6">
                        <input id="job_number" type="number" min="0"
                            class="form-control @error('job_number') is-invalid @enderror" name="job_number"
                            value="{{ old('job_number') }}" autocomplete="job_number">

                        @error('job_number')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3 ">
                    <label for="description" class="col-md-5 col-form-label text-md-end">{{ __('Description')
                        }}</label>

                    <div class="col-md-6">
                        <input id="description" type="text"
                            class="form-control @error('description') is-invalid @enderror" name="description"
                            value="{{ old('description') }}">

                        @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3 ">
                    <label for="date" class="col-md-5 col-form-label text-md-end">{{ __('Date') }}</label>

                    <div class="col-md-6">
                        <input id="date" type="date" class="form-control date-input @error('date') is-invalid @enderror"
                            name="date" value="{{ old('date') ?? date('Y-m-d') }}">

                        @error('date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="offset-md-8 col-md-4">
                        <button type="submit" class="btn btn-info w-100">
                            {{ __('Create') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection