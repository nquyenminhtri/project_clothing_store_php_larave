@extends('layout')
@section('content')
    <div style="margin-left:1%;withd:100%;height:50px;display:flex; margin-top:-20px" class="row">
        <h4 style="width:50%;" id="idTest">List Supplier</h4>
        <div style="width:40%;" class="col-md-6">

            <input style="width:100%;" type="text" class="form-control" id="search" placeholder="Enter keywords">
        </div>
    </div>
    <!-- Hidden Inputs -->
    <input type="hidden" id="supplierId" name="supplierId" value="">
    <input type="hidden" id="actionType" name="actionType" value="create">

    <!-- Button trigger modal for Create -->
    <button type="button" class="waves-effect waves-light btn-primary btn-outline-primary btn btn-primary btn-click"
        onclick="setModalAction('create')">
        <i class="icofont icofont-user-alt-3"></i>Create new supplier
    </button>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create new supplier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="CreateOrUpdateForm" method='POST' action="">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control"
                                    placeholder="Enter the supplier name !" required>
                                <span class="error-message"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Address</label>
                            <div class="col-sm-10">
                                <input type="text" name="address" class="form-control" placeholder="Enter the address !"
                                    required>
                                <span class="error-message"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Phone</label>
                            <div class="col-sm-10">
                                <input type="text" name="phone" class="form-control"
                                    placeholder="Enter the phone number !" required>
                                <span class="error-message"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="description" placeholder="Description"
                                    required>
                                <span class="error-message"></span>
                            </div>
                        </div>
                    </form>
                </div>
                <button type="button" class="btn waves-effect waves-light btn-primary btn-outline-primary btn-create"
                    onclick="submitForm()">
                    <i class="icofont icofont-user-alt-3"></i><span id="btnActionText">Create</span>
                </button>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-block table-border-style">
            <div class="table-responsive">
                <table id="tableContainer" class="table table-hover">
                    <thead>
                        <tr>
                            <th>Number</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Phone </th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($supplierList as $supplier)
                            <tr>
                                <td> {{ $supplier->id }}</td>
                                <td>{{ $supplier->name }}</td>
                                <td>{{ $supplier->address }}</td>
                                <td>{{ $supplier->phone }}</td>
                                <td>{{ $supplier->description }}</td>
                                <td style="display:flex;align-items: center;">
                                    <a href="#" onclick="setModalAction('edit', {{ $supplier->id }})"><button
                                            type="button" class="btn btn-warning">Edit</button></a>
                                    |
                                    <form id="deleteForm_{{ $supplier->id }}"
                                        onsubmit="return confirm('Are you sure you want to delete this supplier?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger"
                                            onclick="deleteSupplier({{ $supplier->id }})">Delete</button>
                                    </form>

                                </td>
                            <tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @php
        $deleteMethod = method_field('DELETE');
    @endphp
    <script>
        function setModalAction(action, supplierId = null) {
            if (action === 'create') {
                $('#supplierId').val('');
                $('#actionType').val('create');
                $('#CreateOrUpdateForm').attr('action', '{{ route('supplier.handle-create') }}');
                $('#CreateOrUpdateForm')[0].reset();
                $('#exampleModalLabel').text('Create a new supplier');
                $('#btnActionText').text('Create');
            } else if (action === 'edit') {
                $('#actionType').val('edit');
                $('#supplierId').val(supplierId);
                $('#CreateOrUpdateForm').attr('action', '{{ url('supplier/update') }}/' + supplierId);
                $('#exampleModalLabel').text('Edit supplier');
                $('#btnActionText').text('Save');
                $.ajax({
                    type: 'GET',
                    url: '{{ url('supplier/update') }}/' + supplierId,
                    success: function(response) {
                        $('#CreateOrUpdateForm input[name="name"]').val(response.name);
                        $('#CreateOrUpdateForm input[name="address"]').val(response.address);
                        $('#CreateOrUpdateForm input[name="phone"]').val(response.phone);
                        $('#CreateOrUpdateForm input[name="description"]').val(response.description);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
            $('#exampleModal').modal('show');
        }

        function submitForm() {
            var formIsValid = true;
            $('#CreateOrUpdateForm input[required]').each(function() {
                if (!this.validity.valid) {
                    formIsValid = false;
                    $(this).next('.error-message').text('Missing parameters');
                } else {
                    $(this).next('.error-message').text('');
                }
            });
            if (!formIsValid) {
                return;
            }
            // Get value actionType
            var actionType = $('#actionType').val();
            // Get value of ID (if any)
            var supplierId = $('#supplierId').val();
            $.ajax({
                type: (actionType === 'create') ? 'POST' : 'PUT',
                url: (actionType === 'create') ? '{{ route('supplier.handle-create') }}' :
                    '{{ url('supplier/update') }}/' + supplierId,
                data: (actionType === 'create') ? $('#CreateOrUpdateForm').serialize() : ($('#CreateOrUpdateForm')
                    .serialize() + '&_method=' + (actionType === 'create' ? 'POST' : 'PUT') + '&_token=' + $(
                        'meta[name="csrf-token"]').attr('content')),
                success: function(response) {

                    if (response.success) {
                        fillDataTable(response.data);
                    }

                    $('#exampleModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Data saved successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                },

                error: function(error) {
                    console.log(error.responseJSON);
                }
            });
        }

        function deleteSupplier(supplierId) {
            // Send Ajax to delete
            $.ajax({
                type: 'DELETE',
                url: '/supplier/delete/' + supplierId,
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        // If deletion is successful, call the Ajax function again to update the data table
                        fillDataTable(response.data);
                        alert('Data deleted success!');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Can not delete!',
                            timer: 1500
                        });
                    }
                },
                error: function(error) {
                    console.log(error.responseJSON);
                }
            });
        }

        function fillDataTable(data) {
            $('#tableContainer tbody').empty();
            var deleteRoute = '{{ route('supplier.delete', ['id' => ':id']) }}';
            var deleteMethod = '{{ method_field('DELETE') }}';

            $.each(data, function(index, supplier) {
                console.log('Supplier Name:', supplier.name);

                var deleteUrl = deleteRoute.replace(':id', supplier.id);

                var row = '<tr>' +
                    '<td>' + supplier.id + '</td>' +
                    '<td>' + supplier.name + '</td>' +
                    '<td>' + supplier.address + '</td>' +
                    '<td>' + supplier.phone + '</td>' +
                    '<td>' + supplier.description + '</td>' +
                    '<td style="display:flex;align-items: center;">' +
                    '<a href="#" onclick="setModalAction(\'edit\', ' + supplier.id + ')">' +
                    '<button type="button" class="btn btn-warning">Edit</button>' +
                    '</a> | ' +
                    '<form id="deleteForm_' + supplier.id +
                    '" onsubmit="return confirm(\'Are you sure you want to delete this supplier?\');" >' +
                    '@csrf' +
                    '@method('DELETE')' +
                    '<button type="button" class="btn btn-danger" onclick="deleteSupplier(' + supplier.id +
                    ')">Delete</button>' +
                    '</form>' +
                    '</td>' +
                    '</tr>';

                // Add row to table tbody
                $('#tableContainer tbody').append(row);
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            // Lắng nghe sự kiện khi người dùng nhập vào ô tìm kiếm
            $('#search').on('input', function() {
                var searchText = $(this).val().toLowerCase();

                // Lọc dữ liệu trong bảng dựa trên từ khóa tìm kiếm
                $('tbody tr').each(function() {
                    var rowData = $(this).text().toLowerCase();
                    // Nếu từ khóa tìm kiếm tồn tại trong dòng dữ liệu, hiển thị dòng đó, ngược lại ẩn đi
                    $(this).toggle(rowData.includes(searchText));
                });
            });
        });
    </script>
    @php
        $hideCardContent = true;
    @endphp
@endsection
