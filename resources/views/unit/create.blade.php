@extends('layouts.admin')

@section('title', 'Add Unit')
@section('content-header', 'Add Unit')

@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('unit.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="description">Name</label>
                <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" id="description" placeholder="Name" value="{{ old('description') }}">
                @error('description')
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