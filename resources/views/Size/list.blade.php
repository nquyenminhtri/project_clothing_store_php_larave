@extends('layout')
@section('content')
    <div style="margin-left:1%;withd:100%;height:50px;display:flex; margin-top:-20px" class="row">
        <h4 style="width:50%;">List Size</h4>
        <div style="width:40%;" class="col-md-6">

            <input style="width:100%;" type="text" class="form-control" id="search" placeholder="Enter keywords">
        </div>
    </div>
    <!-- Hidden Inputs -->
    <input type="hidden" id="sizeId" name="sizeId" value="">
    <input type="hidden" id="actionType" name="actionType" value="create">

    <!-- Button trigger modal for Create -->
    <button type="button" class="waves-effect waves-light btn-primary btn-outline-primary btn btn-primary btn-click"
        onclick="setModalAction('create')">
        <i class="icofont icofont-user-alt-3"></i>Create new size
    </button>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create new size</h5>
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
                                    placeholder="Enter the size name !" required>
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
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sizeList as $size)
                            <tr>
                                <td> {{ $size->id }}</td>
                                <td>{{ $size->name }}</td>
                                <td style="display:flex;align-items: center;">
                                    <a href="#" onclick="setModalAction('edit', {{ $size->id }})"><button
                                            type="button" class="btn btn-warning">Edit</button></a>
                                    |
                                    <form method="POST" action="{{ route('size.delete', ['id' => $size->id]) }}">
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



    <script>
        // Hàm để set hành động của modal (create hoặc edit)
        function setModalAction(action, sizeId = null) {
            if (action === 'create') {
                // Nếu là tạo mới, đặt lại biểu mẫu và thay đổi tiêu đề modal
                $('#sizeId').val('');
                $('#actionType').val('create');
                $('#CreateOrUpdateForm').attr('action', '{{ route('size.handle-create') }}');
                $('#CreateOrUpdateForm')[0].reset();
                $('#exampleModalLabel').text('Create a new size');
                $('#btnActionText').text('Create');
            } else if (action === 'edit') {
                $('#actionType').val('edit');
                $('#sizeId').val(sizeId);
                $('#CreateOrUpdateForm').attr('action', '{{ url('size/update') }}/' + sizeId);
                $('#exampleModalLabel').text('Edit size');
                $('#btnActionText').text('Save');
                // Lấy dữ liệu nhà cung cấp bằng Ajax
                $.ajax({
                    type: 'GET',
                    url: '{{ url('size/update') }}/' + sizeId,
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
            var sizeId = $('#sizeId').val();
            // Sử dụng Ajax để gửi dữ liệu form
            $.ajax({
                type: (actionType === 'create') ? 'POST' : 'PUT',
                // Sử dụng toán tử ba ngôi để chọn route phù hợp
                url: (actionType === 'create') ? '{{ route('size.handle-create') }}' : '{{ url('size/update') }}/' +
                    sizeId,
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
