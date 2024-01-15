@extends('layout')
@section('content')
    <div style="margin-left:1%;withd:100%;height:50px;display:flex; margin-top:-20px" class="row">
        <h4 style="width:50%;">List Product</h4>
        <div style="width:40%;" class="col-md-6">

            <input style="width:100%;" type="text" class="form-control" id="search" placeholder="Enter keywords">
        </div>
    </div>
    <!-- Hidden Inputs -->
    <input type="hidden" id="productId" name="productId" value="">
    <input type="hidden" id="actionType" name="actionType" value="create">
    <input type="hidden" id="hiddenFileName" name="hiddenFileName" value="">
    <!-- Button trigger modal for Create -->
    <button type="button" class="waves-effect waves-light btn-primary btn-outline-primary btn btn-primary btn-click"
        onclick="setModalAction('create')">
        <i class="icofont icofont-user-alt-3"></i>Create new product
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create new product</h5>
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
                                <input type="text" name="name" class="form-control" placeholder="Enter the name !"
                                    required>
                                <div class="error-message"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Category product</label>
                            <div class="col-sm-10">
                                <select name="category_id" class="form-control">
                                    @foreach ($productCategoryList as $productCategory)
                                        <option value="{{ $productCategory->id }}">{{ $productCategory->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <input type="text" name="description" class="form-control"
                                    placeholder="Enter the description !" required>
                                <div class="error-message"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Price</label>
                            <div class="col-sm-10">
                                <input type="text" name="price" class="form-control" placeholder="Enter the price !"
                                    required>
                                <div class="error-message"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Image</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" name="image"
                                    onchange="handleFileChange.call(this)" require="true">
                                <div id="fileNameDisplay"></div>

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
                            <th>Description</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productList as $product)
                            <tr>
                                <td> {{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->description }}</td>
                                <td>{{ $product->productProductCategory->name }}</td>
                                <td>{{ $product->price }}</td>
                                <td><img style="width: 100px; height: 100px;"
                                        src="{{ asset('product-images/' . $product->image) }}" alt="no image"></td>
                                <td style="display:flex;align-items: center;">
                                    <a href="{{ route('product.detail-list', ['id' => $product->id]) }}"><button
                                            class="btn waves-effect waves-light btn-info btn-outline-info"><i
                                                class="fas fa-info-circle"></i></button></a>|
                                    <a href="{{ route('productImage.detail-list', ['productId' => $product->id]) }}"><button
                                            class="btn btn-primary waves-effect waves-light">All photo</button></a>|
                                    <a href="#" onclick="setModalAction('edit', {{ $product->id }})"><button
                                            type="button" class="btn btn-warning"><i
                                                class="far fa-edit"></i></button></a>
                                    |
                                    <form id="deleteForm_{{ $product->id }}"
                                        onsubmit="return confirm('Are you sure you want to delete this product?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger"
                                            onclick="handleDelete({{ $product->id }})">Delete</button>
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
    <script src="{{ asset('jquery-3.6.4.min.js') }}"></script>
    <script>
        function handleFileChange() {
            if (this.files && this.files.length > 0) {
                var fileName = this.files[0].name;
                $('#hiddenFileName').val(fileName);
                $('#fileNameDisplay').text('Selected file: ' + fileName);
            }
        }
        // Hàm để set hành động của modal (create hoặc edit)
        function setModalAction(action, productId = null) {

            if (action === 'create') {
                // Nếu là tạo mới, đặt lại biểu mẫu và thay đổi tiêu đề modal
                $('#productId').val('');
                $('#actionType').val('create');
                $('#CreateOrUpdateForm').attr('action', '{{ route('product.handle-create') }}');
                $('#CreateOrUpdateForm')[0].reset();
                $('#exampleModalLabel').text('Create a new product');
                $('#btnActionText').text('Create');
            } else if (action === 'edit') {
                $('#actionType').val('edit');
                $('#productId').val(productId);
                $('#CreateOrUpdateForm').attr('action', '{{ url('product/update') }}/' + productId);
                $('#exampleModalLabel').text('Edit product');
                $('#btnActionText').text('Save');
                // Lấy dữ liệu bằng Ajax

                $.ajax({
                    type: 'GET',
                    url: '{{ url('product/update') }}/' + productId,
                    success: function(response) {
                        console.log(response.data);
                        // Điền vào biểu mẫu với dữ liệu
                        $('#CreateOrUpdateForm input[name="name"]').val(response.data.name);
                        $('#CreateOrUpdateForm input[name="description"]').val(response.data.description);
                        $('#CreateOrUpdateForm input[name="category_id"]').val(response.data.category_id);
                        $('#CreateOrUpdateForm input[name="price"]').val(response.data.price);
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
            var productId = $('#productId').val();

            // Tạo một đối tượng FormData để chứa dữ liệu form
            var formData = new FormData($('#CreateOrUpdateForm')[0]);
            console.log('dsfs', formData);
            // Sử dụng Ajax để gửi dữ liệu form
            // Lấy giá trị của CSRF token
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            // Xây dựng URL dựa trên actionType
            var url = (actionType === 'create') ? '{{ route('product.handle-create') }}' :
                '{{ url('product/update') }}/' + productId;

            // Nếu là phương thức PUT, thêm CSRF token vào URL và sử dụng `_method`
            if (actionType === 'edit') {
                url = '{{ url('product/update') }}/' + productId;
                formData.append('_method', 'PUT'); // Thêm phương thức PUT
            }

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
                    console.log(response.message);
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
        $(document).ready(function() {
            // Đăng ký sự kiện khi modal được ẩn
            $('#exampleModal').on('hidden.bs.modal', function() {
                // Reset lại form
                $('#CreateOrUpdateForm')[0].reset();
                // Xóa giá trị của hiddenFileName
                $('#hiddenFileName').val('');
                // Xóa hiển thị tên file
                $('#fileNameDisplay').text('');
                // Đặt lại actionType
                $('#actionType').val('create');
                // Đặt lại tiêu đề modal
                $('#exampleModalLabel').text('Create new product');
                // Đặt lại nội dung nút tạo
                $('#btnActionText').text('Create');
            });
        });
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

        function handleDelete(productId) {
            $.ajax({
                type: 'DELETE',
                url: '/product/delete/' + productId,
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        fillDataTable(response.data);
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Product deleted success!',
                            timer: 1300
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Product deleted failed!',
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
            console.log('check data: ', data);
            $('#tableContainer tbody').empty();
            var deleteRoute = '{{ route('product.delete', ['id' => ':id']) }}';
            var deleteMethod = '{{ method_field('DELETE') }}';
            $.each(data, function(index, product) {
                var deleteUrl = deleteRoute.replace(':id', product.id);
                var row = '<tr>' +
                    '<td>' + product.id + '</td>' +
                    '<td>' + product.name + '</td>' +
                    '<td>' + product.description + '</td>' +
                    '<td>' + product.product_product_category.name + '</td>' +
                    '<td>' + product.price + '</td>' +
                    '<td>' + '<img style="width: 100px; height: 100px;" src="' + '{{ asset('product-images/') }}' +
                    '/' + product.image + '" >' +
                    '</td>' +
                    '<td style="display:flex;align-items: center;">' +
                    '<a href="#" onclick="setModalAction(\'edit\', ' + product.id + ')">' +
                    '<button type="button" class="btn btn-warning">Edit</button>' +
                    '</a> | ' +
                    '<form id="deleteForm_' + product.id +
                    '" onsubmit="return confirm(\'Are you sure you want to delete this product?\');" >' +
                    '@csrf' +
                    '@method('DELETE')' +
                    '<button type="button" class="btn btn-danger" onclick="handleDelete(' + product.id +
                    ')">Delete</button>' +
                    '</form>' +
                    '</td>' +
                    '</tr>';
                $('#tableContainer tbody').append(row);
            })
        }
    </script>
    @php
        $hideCardContent = true;
    @endphp
@endsection
