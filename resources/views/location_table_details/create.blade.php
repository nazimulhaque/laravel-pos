@extends('layouts.admin')

@section('title', 'Location Table Details')
@section('content-header', 'Location Table Details')

@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('location_table_details.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="location_id">Location</label>
                <select name="location_id" class="form-control @error('location_id') is-invalid @enderror" id="location_id" onchange="getTableDetails(this.value)">
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

            <div class="card" id="location_details_card_main" style="display: none;">
                <div class="card-body" id="location_details_card_body">
                </div>
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

        getTableDetails(document.getElementById("location_id").value);
    });

    function getTableDetails(locationId) {
        // Retrieve and display number of tables
        var locationList = <?php echo json_encode($location_list); ?>;

        for (var key in locationList) {
            if (locationList[key] instanceof Object) {
                if (locationList[key]["location_id"] == locationId) {
                    document.getElementById("number_of_tables").innerHTML = locationList[key]["number_of_tables"];
                }
            }
        }

        // Retrieve data and create table to display location details
        var locationTables = <?php echo json_encode($location_table_details); ?>;

        // Display heading
        var table = document.createElement('table');
        table.className = 'table';
        var check = false;
        for (var key in locationTables) {
            if (locationTables[key] instanceof Object) {
                if (locationTables[key]["location_id"] == locationId) {
                    var thead = document.createElement('thead');

                    var tr = document.createElement('tr');

                    var td1 = document.createElement('td');
                    var td2 = document.createElement('td');
                    var td3 = document.createElement('td');

                    var text1 = document.createTextNode('Area');
                    var text2 = document.createTextNode('From');
                    var text3 = document.createTextNode('To');

                    td1.appendChild(boldHTML("Area"));
                    td2.appendChild(boldHTML("From"));
                    td3.appendChild(boldHTML("To"));

                    tr.appendChild(td1);
                    tr.appendChild(td2);
                    tr.appendChild(td3);

                    thead.appendChild(tr);
                    table.appendChild(thead);
                    check = true;
                    break;
                }
            }
        }
        var x = document.getElementById("location_details_card_main");
        if (check) {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }

        // Display rows
        var tbody = document.createElement('tbody');
        for (var key in locationTables) {
            if (locationTables[key] instanceof Object) {
                if (locationTables[key]["location_id"] == locationId) {
                    var tr = document.createElement('tr');

                    var td1 = document.createElement('td');
                    var td2 = document.createElement('td');
                    var td3 = document.createElement('td');

                    var text1 = document.createTextNode(locationTables[key]["area"]);
                    var text2 = document.createTextNode(locationTables[key]["start_number"]);
                    var text3 = document.createTextNode(locationTables[key]["end_number"]);

                    td1.appendChild(text1);
                    td2.appendChild(text2);
                    td3.appendChild(text3);

                    tr.appendChild(td1);
                    tr.appendChild(td2);
                    tr.appendChild(td3);

                    tbody.appendChild(tr);
                }
            }
        }
        if (check) {
            table.appendChild(tbody);
            document.getElementById("location_details_card_body").innerHTML = "";
            document.getElementById("location_details_card_body").appendChild(table);
        }
    }

    function boldHTML(text) {
        var element = document.createElement("b");
        element.innerHTML = text;
        return element;
    }
</script>

@endsection