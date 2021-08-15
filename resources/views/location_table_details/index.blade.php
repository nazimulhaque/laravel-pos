@extends('layouts.admin')

@section('title', 'Location Table List')
@section('content-header', 'Location Table List')
@section('content-actions')
<a href="{{route('location_table_details.create')}}" class="btn btn-primary">Add Location Details</a>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
@endsection
@section('content')
<div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Location</th>
                    <th>No. of Tables</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Area</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($location_table_details as $tables)
                <tr>
                    <td>{{$location_list->firstWhere('location_id', $tables->location_id)->location_name}}</td>
                    <td>{{$location_list->firstWhere('location_id', $tables->location_id)->number_of_tables}}</td>
                    <td>{{$tables->start_number}}</td>
                    <td>{{$tables->end_number}}</td>
                    <td>{{$tables->area}}</td>
                    <td>
                        <a href="{{ route('location_table_details.edit', $tables) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                        <button class="btn btn-danger btn-delete" data-url="{{route('location_table_details.destroy', $tables)}}"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $location_table_details->render() }}
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script>
    $(document).ready(function() {
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
                        _token: '{{csrf_token()}}'
                    }, function(res) {
                        $this.closest('tr').fadeOut(500, function() {
                            $(this).remove();
                        })
                    })
                }
            })
        })
    })
</script>
@endsection