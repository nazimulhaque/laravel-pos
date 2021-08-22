@extends('layouts.admin')

@section('title', 'Printer Group List')
@section('content-header', 'Printer Group List')
@section('content-actions')
<a href="{{route('printer_group.create')}}" class="btn btn-primary">Add Printer Group</a>
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
                    <th>Type</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($printer_groups as $printer_group)
                <tr>
                    <td>{{$printer_group->type}}</td>
                    <td>{{$printer_group->description}}</td>
                    <td>
                        <a href="{{ route('printer_group.edit', $printer_group) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                        <button class="btn btn-danger btn-delete" data-url="{{route('printer_group.destroy', $printer_group)}}"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $printer_groups->render() }}
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
                text: "Do you really want to delete this Printer Group?",
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