@extends('layout')
@section('content')
    <h1>List supplier</h1>
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
                                    <form method="POST" action="{{ route('supplier.delete', ['id' => $supplier->id]) }}">
                                        @csrf
                                        @method('DELETE')<button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            <tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="{{ asset('jquery-3.6.4.min.js') }}"></script>

    <script>
        // Hàm để set hành động của modal (create hoặc edit)
        function setModalAction(action, supplierId = null) {
            if (action === 'create') {
                // Nếu là tạo mới, đặt lại biểu mẫu và thay đổi tiêu đề modal
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
                // Lấy dữ liệu nhà cung cấp bằng Ajax
                $.ajax({
                    type: 'GET',
                    url: '{{ url('supplier/update') }}/' + supplierId,
                    success: function(response) {
                        // Điền vào biểu mẫu với dữ liệu nhà cung cấp
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
            // Hiển thị modal
            $('#exampleModal').modal('show');
        }
        // Hàm để submit form
        function submitForm() {
            // Kiểm tra từng trường input
            var formIsValid = true;
            $('#CreateOrUpdateForm input[required]').each(function() {
                if (!this.validity.valid) {
                    formIsValid = false;
                    // Hiển thị thông báo cho trường bị bỏ trống
                    $(this).next('.error-message').text('Missing parameters');
                } else {
                    // Ẩn thông báo khi nhập đúng
                    $(this).next('.error-message').text('');
                }
            });
            // Nếu form không hợp lệ, dừng lại và không gửi Ajax request
            if (!formIsValid) {
                return;
            }
            // Lấy giá trị của actionType
            var actionType = $('#actionType').val();
            // Lấy giá trị của ID (nếu có)
            var supplierId = $('#supplierId').val();
            // Sử dụng Ajax để gửi dữ liệu form
            $.ajax({
                type: (actionType === 'create') ? 'POST' : 'PUT',
                // Sử dụng toán tử ba ngôi để chọn route phù hợp
                url: (actionType === 'create') ? '{{ route('supplier.handle-create') }}' :
                    '{{ url('supplier/update') }}/' + supplierId,
                // Điều chỉnh dữ liệu đang được gửi dựa trên actionType
                data: (actionType === 'create') ? $('#CreateOrUpdateForm').serialize() : ($('#CreateOrUpdateForm')
                    .serialize() + '&_method=' + (actionType === 'create' ? 'POST' : 'PUT') + '&_token=' + $(
                        'meta[name="csrf-token"]').attr('content')),
                success: function(response) {
                    // Đóng modal khi dữ liệu đã được lưu
                    $('#exampleModal').modal('hide');
                    // Hiển thị thông báo thành công
                    alert('Dữ liệu đã được lưu thành công!');
                },
                error: function(error) {
                    console.log(error.responseJSON);
                }
            });
        }
    </script>
@endsection
