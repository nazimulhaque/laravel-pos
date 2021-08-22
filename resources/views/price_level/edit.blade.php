@extends('layouts.admin')

@section('title', 'Edit Price Level')
@section('content-header', 'Edit Price Level')

@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('price_level.update', $price_level) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" id="description" placeholder="Description" value="{{ old('description', $price_level->description) }}">
                @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <button class="btn btn-primary" type="submit">Update</button>
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