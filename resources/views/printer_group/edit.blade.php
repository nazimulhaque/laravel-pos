@extends('layouts.admin')

@section('title', 'Edit Printer Group')
@section('content-header', 'Edit Printer Group')

@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('printer_group.update', $printer_group) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="type">Type</label>
                <input type="number" name="type" class="form-control @error('type') is-invalid @enderror" id="type" placeholder="Type" value="{{ old('type', $printer_group->type) }}">
                @error('type')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Name</label>
                <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" id="description" placeholder="Name" value="{{ old('description', $printer_group->description) }}">
                @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="client_print_order">Client Print Order</label>
                <input type="number" name="client_print_order" class="form-control @error('description') is-invalid @enderror" id="client_print_order" placeholder="ClientPrintOrder" value="{{ old('client_print_order', $printer_group->client_print_order) }}">
                @error('client_print_order')
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