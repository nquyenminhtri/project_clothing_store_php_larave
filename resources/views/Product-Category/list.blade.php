@extends('layout')
@section('content')
    <div style="margin-left:1%;withd:100%;height:50px;display:flex; margin-top:-20px" class="row">
        <h4 style="width:50%;">List Product Category</h4>
        <div style="width:40%;" class="col-md-6">
            <input style="width:100%;" type="text" class="form-control" id="search" placeholder="Enter keywords">
        </div>
    </div>
    <!-- Hidden Inputs -->
    <input type="hidden" id="productCategoryId" name="productCategoryId" value="">
    <input type="hidden" id="actionType" name="actionType" value="create">
    <input type="hidden" id="hiddenFileName" name="hiddenFileName" value="">
    <!-- Button trigger modal for Create -->
    <button type="button" class="waves-effect waves-light btn-primary btn-outline-primary btn btn-primary btn-click"
        onclick="setModalAction('create')">
        <i class="icofont icofont-user-alt-3"></i>Create new Product Category
    </button>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create new Product Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="CreateOrUpdateForm" enctype="multipart/form-data" method='POST' action="">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control"
                                    placeholder="Enter the full name !" required>
                                <div class="error-message"></div>
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
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productCategoryList as $productCategory)
                            <tr>
                                <td> {{ $productCategory->id }}</td>
                                <td>{{ $productCategory->name }}</td>
                                <td style="display:flex;align-items: center;">
                                    <a href="#" onclick="setModalAction('edit', {{ $productCategory->id }})"><button
                                            type="button" class="btn btn-warning">Edit</button></a>
                                    |
                                    <form method="POST"
                                        action="{{ route('product-category.delete', ['id' => $productCategory->id]) }}">
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
    @php
        $deleteMethod = method_field('DELETE');
    @endphp
    <script>
        function handleFileChange() {
            if (this.files && this.files.length > 0) {
                var fileName = this.files[0].name;
                $('#hiddenFileName').val(fileName);
                $('#fileNameDisplay').text('Selected file: ' + fileName);
            }
        }
        // Hàm để set hành động của modal (create hoặc edit)
        function setModalAction(action, productCategoryId = null) {

            if (action === 'create') {
                // Nếu là tạo mới, đặt lại biểu mẫu và thay đổi tiêu đề modal
                $('#productCategoryId').val('');
                $('#actionType').val('create');
                $('#CreateOrUpdateForm').attr('action', '{{ route('product-category.handle-create') }}');
                $('#CreateOrUpdateForm')[0].reset();
                $('#CreateOrUpdateForm input[name="password"]').closest('.form-group').show();
                $('#exampleModalLabel').text('Create a new product category');
                $('#btnActionText').text('Create');
            } else if (action === 'edit') {
                $('#actionType').val('edit');
                $('#productCategoryId').val(productCategoryId);
                $('#CreateOrUpdateForm').attr('action', '{{ url('product-category/update') }}/' + productCategoryId);
                $('#exampleModalLabel').text('Edit productCategory');
                $('#btnActionText').text('Save');
                // Lấy dữ liệu bằng Ajax

                $.ajax({
                    type: 'GET',
                    url: '{{ url('product-category/update') }}/' + productCategoryId,
                    success: function(response) {
                        console.log(response.data.name);
                        // Điền vào biểu mẫu với dữ liệu
                        $('#CreateOrUpdateForm input[name="name"]').val(response.data.name);
                        $('#CreateOrUpdateForm input[name="user_name"]').val(response.data.user_name);
                        $('#CreateOrUpdateForm input[name="password"]').closest('.form-group').hide();

                        $('#hiddenFileName').val(response.data.image);
                        $('#fileNameDisplay').text(response.data.image);

                        // Thêm các dòng tương ứng với các trường dữ liệu khác
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

            var actionType = $('#actionType').val();
            // Lấy giá trị của ID (nếu có)
            var productCategoryId = $('#productCategoryId').val();

            // Tạo một đối tượng FormData để chứa dữ liệu form
            var formData = new FormData($('#CreateOrUpdateForm')[0]);
            console.log('dsfs', formData);
            // Sử dụng Ajax để gửi dữ liệu form
            // Lấy giá trị của CSRF token
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            // Xây dựng URL dựa trên actionType
            var url = (actionType === 'create') ? '{{ route('product-category.handle-create') }}' :
                '{{ url('product-category/update') }}/' + productCategoryId;

            // Nếu là phương thức PUT, thêm CSRF token vào URL và sử dụng `_method`
            if (actionType === 'edit') {
                url = '{{ url('product-category/update') }}/' + productCategoryId;
                formData.append('_method', 'PUT'); // Thêm phương thức PUT
            }
            console.log('check url:', url);
            // Sử dụng updateUrl trong Ajax request
            $.ajax({
                type: (actionType === 'create') ? 'POST' :
                'POST', // Sử dụng phương thức POST cho cả create và update
                url: url,
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                contentType: false,
                processData: false,
                success: function(response) {
                    if (!response.success) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed!',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500 // Tự động đóng sau 1.5 giây
                        });
                    } else {
                        fillDataTable(response.data);
                        $('#exampleModal').modal('hide');
                        // Hiển thị thông báo thành công với SweetAlert
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Data saved successfully!',
                            showConfirmButton: false,
                            timer: 1500 // Tự động đóng sau 1.5 giây
                        });
                    }
                },
                error: function(error) {
                    console.log(error.responseJSON);
                }
            });
        }

        function handleDelete(productCategoryId) {
            $.ajax({
                type: 'DELETE',
                url: '/product-category/delete/' + productCategoryId,
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        fillDataTable(response.data);
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Product Category deleted success!',
                            timer: 1300
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Product Category deleted failed!',
                            timer: 1300
                        });
                    }

                },
                error: function(error) {
                    console.log(error.responseJSON);
                }
            })
        }

        function fillDataTable(data) {
            $('#tableContainer tbody').empty();
            var deleteRoute = '{{ route('product-category.delete', ['id' => ':id']) }}';
            var deleteMethod = '{{ method_field('DELETE') }}';
            $.each(data, function(index, productCategory) {
                var deleteUrl = deleteRoute.replace(':id', productCategory.id);
                var row = '<tr>' +
                    '<td>' + productCategory.id + '</td>' +
                    '<td>' + productCategory.name + '</td>' +
                    '<td style="display:flex;align-items: center;">' +
                    '<a href="#" onclick="setModalAction(\'edit\', ' + productCategory.id + ')">' +
                    '<button type="button" class="btn btn-warning">Edit</button>' +
                    '</a> | ' +
                    '<form id="deleteForm_' + productCategory.id +
                    '" onsubmit="return confirm(\'Are you sure you want to delete this productCategory?\');" >' +
                    '@csrf' +
                    '@method('DELETE')' +
                    '<button type="button" class="btn btn-danger" onclick="handleDelete(' + productCategory.id +
                    ')">Delete</button>' +
                    '</form>' +
                    '</td>' +
                    '</tr>';
                $('#tableContainer tbody').append(row);
            })
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
