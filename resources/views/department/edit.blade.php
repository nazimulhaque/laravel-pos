@extends('layouts.admin')

@section('title', 'Edit Department')
@section('content-header', 'Edit Department')

@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('department.update', $department) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="department_name">Name</label>
                <input type="text" name="department_name" class="form-control @error('department_name') is-invalid @enderror" id="department_name" placeholder="Name" value="{{ old('department_name', $department->department_name) }}">
                @error('department_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="parent_department_id">Parent Department</label>
                <select name="parent_department_id" class="form-control @error('parent_department_id') is-invalid @enderror" id="parent_department_id">
                    <option value="" selected>Select</option>
                    @foreach($department_list as $dept)
                    <option value="{{$dept->department_id}}" {{$dept->department_id == $department->parent_department_id ? 'selected' : ''}} {{$dept->department_id == $department->department_id ? 'disabled' : ''}} {{$dept->parent_department_id > 0 ? 'hidden' : ''}}>
                        {{$dept->department_name}}
                    </option>
                    @endforeach
                </select>
                @error('parent_department_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" placeholder="description">{{ old('description', $department->description) }}</textarea>
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