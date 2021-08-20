@extends('layouts.admin')

@section('title', 'Location Details')
@section('content-header', 'Location Details')

@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('location_table_details.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="location_id">Location</label>
                <select name="location_id" class="form-control @error('location_id') is-invalid @enderror" id="location_id">
                    @foreach($location_list as $loc)
                    <option value="{{$loc->location_id}}" {{$loc->location_id == $location->location_id ? 'selected' : ''}}>{{$loc->location_name}}</option>
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
                <button class="btn btn-primary" type="button" id="btn_expand" onclick="toggleDivVisibility()">Add Location Tables</button>
            </div>

            <div class="form-group" id="location_tables_card_main" style="display: none;">
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

                <!-- Hidden element to pass the origination route name -->
                <input type="hidden" id="from_route" name="from_route" value="location">

                <button class="btn btn-primary" type="submit">Add</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        bsCustomFileInput.init();
        // Retrieve location and table details
        retrieveLocationDetails(document.getElementById("location_id").value);

        $('#location_id').on('change', function(e) {
            let locationId = e.target.value;
            retrieveLocationDetails(locationId);
        });
    });

    function retrieveLocationDetails(locationId) {
        // alert(locationId);
        $.ajax({
            url: "{{ route('location.new_location') }}",
            type: "GET",
            dataType: "JSON",
            data: {
                "_token": "{{ csrf_token() }}",
                "location_id": locationId
            },
            success: function(response) {
                // alert("Response: " + response);
                // alert("Response: " + JSON.parse(JSON.stringify(response)));
                let jsonData = JSON.parse(JSON.stringify(response));
                // alert(jsonData.location.location_name);
                populateLocationDetails(jsonData.location, jsonData.location_table_details);
            }
        })
    }

    function populateLocationDetails(location, locationTables) {
        // Display number of tables
        document.getElementById("number_of_tables").innerHTML = location.number_of_tables;

        let table = document.createElement('table');
        table.className = 'table';
        let check = false;

        if (locationTables.length > 0) {
            check = true;
            // Populate html table to display location details
            // Display heading
            table.appendChild(getThead());
            // Display rows
            table.appendChild(getTbody(locationTables));
            enableDelete(location.location_id);
            document.getElementById("location_details_card_body").innerHTML = "";
            document.getElementById("location_details_card_body").appendChild(table);
            document.getElementById("location_details_card_main").style.display = "block";
        } else {
            document.getElementById("location_details_card_main").style.display = "none";
        }

        if (check) {}

    }

    function getThead() {
        let thead = document.createElement('thead');

        let tr = document.createElement('tr');

        let td1 = document.createElement('td');
        let td2 = document.createElement('td');
        let td3 = document.createElement('td');
        let td4 = document.createElement('td');

        td1.appendChild(boldHTML("Area"));
        td2.appendChild(boldHTML("From"));
        td3.appendChild(boldHTML("To"));
        td4.appendChild(boldHTML("Actions"));

        tr.appendChild(td1);
        tr.appendChild(td2);
        tr.appendChild(td3);
        tr.appendChild(td4);

        thead.appendChild(tr);
        return thead;
    }

    function getTbody(locationTables) {
        let tbody = document.createElement('tbody');
        for (let key in locationTables) {
            let tr = document.createElement('tr');

            let td1 = document.createElement('td');
            let td2 = document.createElement('td');
            let td3 = document.createElement('td');
            let td4 = document.createElement('td');

            let text1 = document.createTextNode(locationTables[key]["area"]);
            let text2 = document.createTextNode(locationTables[key]["start_number"]);
            let text3 = document.createTextNode(locationTables[key]["end_number"]);

            td1.appendChild(text1);
            td2.appendChild(text2);
            td3.appendChild(text3);

            // Create action buttons
            let iconEdit = document.createElement("i");
            iconEdit.setAttribute("class", "fas fa-edit");

            let urlEdit = '{{ route("location_table_details.edit", ":slug") }}';
            urlEdit = urlEdit.replace(':slug', locationTables[key]["location_table_detail_id"]);

            let anchor = document.createElement("a");
            anchor.setAttribute("class", "btn btn-primary");
            anchor.setAttribute("href", urlEdit);
            // anchor.href = urlEdit;
            anchor.appendChild(iconEdit);
            td4.appendChild(anchor);

            let iconDelete = document.createElement("i");
            iconDelete.setAttribute("class", "fas fa-trash");

            let urlDelete = '{{ route("location_table_details.destroy", ":slug") }}';
            urlDelete = urlDelete.replace(':slug', locationTables[key]["location_table_detail_id"]);

            let button = document.createElement("button");
            button.setAttribute("type", "button");
            button.setAttribute("class", "btn btn-danger btn-delete");
            button.setAttribute("data-url", urlDelete);
            button.appendChild(iconDelete);
            td4.appendChild(button);

            tr.appendChild(td1);
            tr.appendChild(td2);
            tr.appendChild(td3);
            tr.appendChild(td4);

            tbody.appendChild(tr);
        }
        return tbody;
    }

    function enableDelete(locationId) {
        $(document).on('click', '.btn-delete', function() {
            $this = $(this);
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "Do you really want to delete this location details?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                reverseButtons: false
            }).then((result) => {
                if (result.value) {
                    $.post($this.data('url'), {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    }, function(res) {
                        $this.closest('tr').fadeOut(500, function() {
                            $(this).remove();
                            // let url = "{{ route('location.show', ':slug') }}";
                            // url = url.replace(':slug', locationId);
                            // document.location.href = url;
                        })
                    })
                }
            })
        })
    }

    function boldHTML(text) {
        var element = document.createElement("b");
        element.innerHTML = text;
        return element;
    }

    function toggleDivVisibility() {
        let x = document.getElementById("location_tables_card_main");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }

    function createElementFromHTML(htmlString) {
        var div = document.createElement('div');
        div.innerHTML = htmlString.trim();

        // Change this to div.childNodes to support multiple top-level nodes
        return div.firstChild;
    }
</script>

@endsection