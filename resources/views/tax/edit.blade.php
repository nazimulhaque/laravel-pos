@extends('layouts.admin')

@section('title', 'Edit Tax')
@section('content-header', 'Edit Tax')

@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('tax.update', $tax) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="description">Name</label>
                <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" id="description" placeholder="Name" value="{{ old('description', $tax->description) }}">
                @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="rate">Rate</label>
                <input type="text" name="rate" class="form-control @error('rate') is-invalid @enderror" id="rate" placeholder="Rate" value="{{ old('rate', $tax->rate) }}">
                @error('rate')
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