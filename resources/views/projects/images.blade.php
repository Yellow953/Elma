@extends('layouts.app')

@section('title', 'projects')

@section('sub-title', 'secondary_images')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 col-md-8 offset-md-2">
            <div class="card m-3">
                <div class="card-header">
                    <h4 class="font-weight-bolder text-center text-info">Secondary Images <small
                            class="mx-3 text-danger">(click to remove)</small></h4>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-center">
                        @forelse ($project->secondary_images as $secondary_image)
                        <form method="GET" action="{{ route('secondary_images.destroy', $secondary_image->id) }}">
                            @csrf
                            <a class="image-wrapper show_confirm">
                                <img src="{{asset($secondary_image->path)}}" alt="" class="img-fluid m-1"
                                    style="width:150px; height:150px">
                                <span class="delete-overlay text-danger">Delete</span>
                            </a>
                        </form>
                        @empty
                        No secondary Images yet...
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="card m-3">
                <div class="card-header">
                    <h4 class="font-weight-bolder text-center text-info">New Secondary Image</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('secondary_images.create') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="project_id" value="{{ $project->id }}">

                        <div class="input-group input-group-outline row  my-1">
                            <label for="pictures" class="col-md-5 col-form-label text-md-end">{{ __('Pictures')
                                }}</label>

                            <div class="col-md-6">
                                <input id="pictures" class="form-control" name="images[]" type="file" multiple required>

                                @error('pictures')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="offset-md-8">
                                <button type="submit" class="btn btn-info">
                                    {{ __('Upload') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection