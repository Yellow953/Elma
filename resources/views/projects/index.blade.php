@extends('layouts.app')

@section('title', 'projects')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-12 col-md-8 my-1">
      <form action="{{ route('projects') }}" method="get" enctype="multipart/form-data"
        class="d-flex flex-row justify-content-start">
        <input type="text" name="name" id="name" class="form-control input-field my-auto border mx-1" required autofocus
          value="{{ request()->query('name') }}">
        <button type="submit" class="btn btn-info btn-custom">
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
        <a class="dropdown-item text-dark" href="{{ route('projects.new') }}">New Project</a>
        @if (auth()->user()->role == 'admin')
        <a class="dropdown-item text-dark" href="{{ route('export.projects') }}">Export Projects</a>
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
          <h4 class="mb-2">Filter Projects</h4>
          <form action="{{ route('projects') }}" method="get" enctype="multipart/form-data">
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
                    <label for="number">Number</label>
                    <div>
                      <input type="number" class="form-control border" name="number" placeholder="Number" min="0"
                        value="{{request()->query('number')}}">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="input-group input-group-outline my-2">
                  <div class="w-100">
                    <label for="status">Status</label>
                    <div>
                      <select name="status" class="form-select select2">
                        <option value=""></option>
                        <option value="new" {{request()->query('status') == 'new' ? 'selected' : ''}}>New</option>
                        <option value="pending" {{request()->query('status') == 'pending' ? 'selected' : ''}}>Pending
                        </option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="input-group input-group-outline my-2">
                  <div class="w-100">
                    <label for="delivery_date">Delivery Date</label>
                    <div>
                      <input type="date" class="form-control border" name="delivery_date"
                        value="{{request()->query('delivery_date')}}">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="input-group input-group-outline my-2">
                  <div class="w-100">
                    <label for="warehouse_id">Warehouse</label>
                    <div>
                      <select name="warehouse_id" class="form-select select2">
                        <option value=""></option>
                        @foreach (Helper::get_warehouses() as $warehouse)
                        <option value="{{ $warehouse->id }}" {{request()->query('warehouse_id') == $warehouse->id ?
                          'selected' : ''}}>{{ $warehouse->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="input-group input-group-outline my-2">
                  <div class="w-100">
                    <label for="client_id">Client</label>
                    <div>
                      <select name="client_id" class="form-select select2">
                        <option value=""></option>
                        @foreach (Helper::get_clients() as $client)
                        <option value="{{ $client->id }}" {{request()->query('client_id') == $client->id ? 'selected' :
                          ''}}>{{ $client->name }}</option>
                        @endforeach
                      </select>
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

<!-- End Navbar -->
<div class="container-fluid py-2">
  <div class="row">
    <div class="col-12">
      <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3">
          <div class="bg-gradient-info shadow-info border-radius-lg pt-4 pb-3">
            <h5 class="text-capitalize ps-3">Projects table</h5>
          </div>
        </div>
        <div class="card-body px-0 pb-2">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0 text-sm text-dark">
              <thead>
                <tr>
                  <th>Number</th>
                  <th>Project</th>
                  <th>Warehouse</th>
                  <th>Status</th>
                  <th>Delivery Date</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($projects as $project)
                <tr>
                  <td class="fw-bold">
                    {{ $project->number }}
                  </td>
                  <td>
                    <div class="d-flex px-2">
                      <div>
                        <a href="{{asset($project->main_image)}}"><img src="{{asset($project->main_image)}}"
                            class="avatar avatar-sm rounded-circle me-2" alt="spotify"></a>
                      </div>
                      <div class="my-auto" style="max-width: 200px;">
                        <h6 class="mb-0 text-sm w-100 overflow-auto">{{ucwords($project->name)}}
                        </h6>
                        @if($project->client_id)
                        <p class="text-secondary text-sm">{{ucwords($project->client->name)}}</p>
                        @endif
                      </div>
                    </div>
                  </td>
                  <td>
                    <span class="text-sm"> {{ ucwords($project->warehouse->name ?? 'N/A') }}</span>
                  </td>
                  <td>
                    @if ($project->status == "delivered")
                    <span class="text-white rounded p-2 bg-success">{{ucwords($project->status)}}</span>
                    @elseif ($project->status == "pending")
                    <span class="text-white rounded p-2 bg-warning">{{ucwords($project->status)}}</span>
                    @else
                    <span class="text-white rounded p-2 bg-secondary">{{ucwords($project->status)}}</span>
                    @endif
                  </td>
                  <td>{{$project->delivery_date}}
                  </td>
                  <td class="align-middle text-center max-w-200">
                    <div class="d-flex justify-content-center">
                      <a href="{{ route('projects.images', $project->id) }}" class="btn btn-secondary btn-custom"
                        title="Secondary Images">
                        <i class="fa-solid fa-image"></i>
                      </a>
                      <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-warning btn-custom"
                        title="Edit">
                        <i class="fa-solid fa-pen-to-square"></i>
                      </a>
                      <a href="{{ route('projects.history', $project->id) }}" class="btn btn-info btn-custom"
                        title="History">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                      </a>
                      <a href="{{ route('projects.so', $project->id) }}" class="btn btn-secondary btn-custom"
                        title="SOs">
                        <i class="fa-solid fa-file-lines"></i>
                      </a>

                      @if (auth()->user()->role == 'admin' && $project->can_delete())
                      <form method="GET" action="{{ route('projects.destroy', $project->id) }}">
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
                  <td colspan="5">No Projects Found</td>
                </tr>
                @endforelse
                <tr>
                  <td colspan="5">{{$projects->appends(['name' => request()->query('name'), 'number' =>
                    request()->query('number'), 'status' => request()->query('status'), 'delivery_date' =>
                    request()->query('delivery_date'), 'warehouse_id' => request()->query('warehouse_id'), 'client_id'
                    => request()->query('client_id')])->links()}}</td>
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