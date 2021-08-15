@extends('layouts.admin')

@section('title', 'Add Location Table Details')
@section('content-header', 'Add Location Table Details')

@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('location_table_details.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="location_id">Location</label>
                <select name="location_id" class="form-control @error('location_id') is-invalid @enderror" id="location_id" onchange="getNumberOfTables(this.value)">
                    @foreach($location_list as $loc)
                    <option value="{{$loc->location_id}}">{{$loc->location_name}}</option>
                    @endforeach
                </select>
                @error('location_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div style="display:flex; flex-direction: row; justify-content: left; align-items: center">
                <p><strong>No. of Tables:&nbsp;&nbsp;</strong></p>
                <p name="number_of_tables" id="number_of_tables"></p>
            </div>

            <div class="form-group">
                <label for="area">Area</label>
                <input type="text" name="area" class="form-control @error('area') is-invalid @enderror" id="area" placeholder="Area" value="{{ old('area') }}">
                @error('area')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="start_number">From</label>
                <input type="number" min="1" name="start_number" class="form-control @error('start_number') is-invalid @enderror" id="start_number" placeholder="From" value="{{ old('start_number') }}">
                @error('start_number')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="end_number">To</label>
                <input type="number" min="1" name="end_number" class="form-control @error('end_number') is-invalid @enderror" id="end_number" placeholder="To" value="{{ old('end_number') }}">
                @error('end_number')
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

        getNumberOfTables(document.getElementById("location_id").value);
    });

    function getNumberOfTables(locationId) {
        var locationList = <?php echo json_encode($location_list); ?>;
        for (var key in locationList) {
            if (locationList[key] instanceof Object) {
                if (locationList[key]["location_id"] == locationId)
                    document.getElementById("number_of_tables").innerHTML = locationList[key]["number_of_tables"];
            }
        }
    }
</script>

@endsection