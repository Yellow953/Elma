@extends('layouts.app')

@section('title', 'so')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-12 col-md-8 my-1">
      <form action="{{ route('so') }}" method="get" enctype="multipart/form-data"
        class="d-flex flex-row justify-content-start">
        <input type="text" name="name" id="name" class="form-control input-field my-auto border mx-1" required autofocus
          value="{{ request()->query('name') }}">
        <button type="submit" class="btn btn-info btn-custom my-auto">
          <i class="fa-solid fa-magnifying-glass"></i>
        </button>
      </form>
    </div>
    <div class="col-6 col-md-2 d-flex justify-content-end">
      <button class="btn btn-info py-2 px-3 text-dark ignore-confirm" type="button" id="actionsDropdown"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Actions
      </button>
      <div class="dropdown-menu dropdown-menu-right mt-2" aria-labelledby="actionsDropdown">
        <a class="dropdown-item text-dark" href="{{ route('so.new') }}">New SO</a>
        @if (auth()->user()->role == 'admin')
        <a class="dropdown-item text-dark" href="{{ route('export.sos') }}">Export SOs</a>
        <a class="dropdown-item text-dark" href="{{ route('export.so_items') }}">Export SO Items</a>
        @endif
      </div>
    </div>
    <div class="col-6 col-md-2">
      <div class="d-flex justify-content-end">
        <button class="btn btn-secondary py-2 px-3 mx-2 text-dark ignore-confirm" type="button" id="filterDropdown"
          data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Filter
        </button>
        <div class="dropdown-menu dropdown-menu-right mt-2 p-4" aria-labelledby="filterDropdown" style="width: 300px">
          <h4 class="mb-2">Filter SOs</h4>
          <form action="{{ route('so') }}" method="get" enctype="multipart/form-data">
            <div class="row">
              <div class="col-md-6">
                <div class="input-group input-group-outline my-2">
                  <div class="w-100">
                    <label for="name">Name</label>
                    <div>
                      <input type="text" class="form-control border" name="name" placeholder="Name"
                        value="{{request()->query('name')}}">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="input-group input-group-outline my-2">
                  <div class="w-100">
                    <label for="job_number">Job Number</label>
                    <div>
                      <input type="number" class="form-control border" name="job_number" placeholder="Job Number"
                        min="0" value="{{request()->query('job_number')}}">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="input-group input-group-outline my-2">
                  <div class="w-100">
                    <label for="technician">Technician</label>
                    <div>
                      <input type="text" class="form-control border" name="technician" placeholder="Technician"
                        value="{{request()->query('technician')}}">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="input-group input-group-outline my-2">
                  <div class="w-100">
                    <label for="description">Description</label>
                    <div>
                      <input type="text" class="form-control border" name="description" placeholder="Job Number"
                        value="{{request()->query('description')}}">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="input-group input-group-outline my-2">
                  <div class="w-100">
                    <label for="project_id">Project</label>
                    <div>
                      <select name="project_id" class="form-select select2">
                        <option value=""></option>
                        @foreach (Helper::get_projects() as $project)
                        <option value="{{ $project->id }}" {{request()->query('project_id') == $project->id ? 'selected'
                          : ''}}>{{ $project->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="input-group input-group-outline my-2">
                  <div class="w-100">
                    <label for="date">Date</label>
                    <div>
                      <input type="date" class="form-control border" name="date" value="{{request()->query('date')}}">
                    </div>
                  </div>
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
      </div>
    </div>
  </div>
</div>

<div class="container-fluid py-2">
  <div class="row">
    <div class="col-12">
      <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3">
          <div class="bg-gradient-info shadow-info border-radius-lg pt-4 pb-3">
            <h5 class="text-capitalize ps-3">SO table</h5>
          </div>
        </div>
        <div class="card-body px-0 pb-2">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0 text-sm text-dark">
              <thead>
                <tr>
                  <th>SO</th>
                  <th>Project</th>
                  <th>Technician</th>
                  <th>Date</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($sos as $so)
                <tr class="rounded">
                  <td>
                    <h6 class="my-auto">{{$so->name}}</h6>
                  </td>
                  <td style="max-width: 200px;">
                    <p class="w-100 overflow-auto">
                      {{ucwords($so->project->name)}}
                    </p>
                  </td>
                  <td>
                    <p>{{ucwords($so->technician)}}</p>
                    @if($so->job_number)
                    <p>Job Number : {{$so->job_number}}</p>
                    @endif
                  </td>
                  <td>
                    <p>{{$so->date}}</p>
                  </td>
                  <td>
                    <div class="d-flex flex-row justify-content-center">
                      <a href="{{ route('so.AddItems', $so->id) }}" class="btn btn-info btn-custom" title="Add Items">
                        <i class="fa-solid fa-plus"></i>
                      </a>
                      <a href="{{ route('so.show', $so->id) }}" class="btn btn-info btn-custom" title="Show">
                        <i class="fa-solid fa-eye"></i>
                      </a>
                      <a href="{{ route('so.activity', $so->id) }}" class="btn btn-secondary btn-custom"
                        title="Activity">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                      </a>
                      <a href="{{ route('so.quantities', $so->id) }}" class="btn btn-secondary btn-custom"
                        title="Quantities">
                        <i class="fa-solid fa-hashtag"></i>
                      </a>
                      <a href="{{ route('so.edit', $so->id) }}" title="Edit" class="btn btn-warning btn-custom">
                        <i class="fa-solid fa-pen-to-square"></i>
                      </a>
                      @if (auth()->user()->role != 'user' && $so->invoice == null)
                      <a href="{{ route('so.new_invoice', $so->id) }}" class="btn btn-success btn-custom"
                        title="New Invoice">
                        <i class="fa-solid fa-receipt"></i>
                      </a>
                      @endif
                      @if (auth()->user()->role == 'admin' && $so->can_delete())
                      <form method="GET" action="{{ route('so.destroy', $so->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-danger show_confirm btn-custom" data-toggle="tooltip"
                          title='Delete'>
                          <i class="fa-solid fa-trash"></i>
                        </button>
                      </form>
                      @endif
                    </div>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="5">
                    No SOs Found
                  </td>
                </tr>
                @endforelse
                <tr>
                  <td colspan="5">{{$sos->appends(['name' => request()->query('name'), 'project_id' =>
                    request()->query('project_id'), 'technician' => request()->query('technician'), 'job_number' =>
                    request()->query('job_number'), 'description' => request()->query('description'), 'date' =>
                    request()->query('date')])->links()}}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection