@extends('layouts.admin')

@section('title', 'Add Location')
@section('content-header', 'Add Location')

@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('location.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="location_name">Name</label>
                <input type="text" name="location_name" class="form-control @error('location_name') is-invalid @enderror" id="location_name" placeholder="Name" value="{{ old('location_name') }}">
                @error('location_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <button class="btn btn-primary" type="submit">Add</button>
        </form>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script>
    $(document).ready(function() {
        bsCustomFileInput.init();
    });
</script>
@endsection