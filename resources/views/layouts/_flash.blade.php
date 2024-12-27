@if ($message = Session::get('success'))
<div class="alert alert-success alert-block auto-dismiss">
    <strong class="my-auto">{{ $message }}</strong>
    <button type="button" class="close my-auto btn btn-shadow-none" data-dismiss="alert"><i
            class="fa-solid fa-x"></i></button>
</div>
@endif

@if (session('status'))
<div class="alert alert-success alert-block auto-dismiss">
    <strong class="my-auto">{{ session('status') }}</strong>
    <button type="button" class="close my-auto btn btn-shadow-none" data-dismiss="alert"><i
            class="fa-solid fa-x"></i></button>
</div>
@endif

@if ($message = Session::get('error'))
<div class="alert alert-danger alert-block auto-dismiss">
    <strong class="my-auto">{{ $message }}</strong>
    <button type="button" class="close my-auto btn btn-shadow-none" data-dismiss="alert"><i
            class="fa-solid fa-x"></i></button>
</div>
@endif

@if ($message = Session::get('danger'))
<div class="alert alert-danger alert-block auto-dismiss">
    <strong class="my-auto">{{ $message }}</strong>
    <button type="button" class="close my-auto btn btn-shadow-none" data-dismiss="alert"><i
            class="fa-solid fa-x"></i></button>
</div>
@endif

@if ($message = Session::get('warning'))
<div class="alert alert-warning alert-block auto-dismiss">
    <strong class="my-auto">{{ $message }}</strong>
    <button type="button" class="close my-auto btn btn-shadow-none" data-dismiss="alert"><i
            class="fa-solid fa-x"></i></button>
</div>
@endif

@if ($message = Session::get('info'))
<div class="alert alert-info alert-block auto-dismiss">
    <strong class="my-auto">{{ $message }}</strong>
    <button type="button" class="close my-auto btn btn-shadow-none" data-dismiss="alert"><i
            class="fa-solid fa-x"></i></button>
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="close my-auto btn btn-shadow-none" data-dismiss="alert"><i
            class="fa-solid fa-x"></i></button>
</div>
@endif