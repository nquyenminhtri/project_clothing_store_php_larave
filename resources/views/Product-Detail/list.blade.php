@extends('layout')
@section('content')
    <h1>List product detail</h1>
    <!-- Hidden Inputs -->
    <input type="hidden" id="productDetailId" name="productDetailId" value="">
    <input type="hidden" id="actionType" name="actionType" value="create">
    <input type="hidden" id="hiddenFileName" name="hiddenFileName" value="">

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
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
                                <input type="text" name="product_id" class="form-control" readonly>
                                <div class="error-message"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Size</label>
                            <div class="col-sm-10">
                                <select name="size_id" class="form-control">
                                    @foreach ($sizeList as $size)
                                        <option value="{{ $size->id }}">{{ $size->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Color</label>
                            <div class="col-sm-10">
                                <select name="color_id" class="form-control">
                                    @foreach ($colorList as $color)
                                        <option value="{{ $color->id }}">{{ $color->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Material</label>
                            <div class="col-sm-10">
                                <select name="material_id" class="form-control">
                                    @foreach ($materialList as $material)
                                        <option value="{{ $material->id }}">{{ $material->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Quantity</label>
                            <div class="col-sm-10">
                                <input type="text" name="quantity" class="form-control"
                                    placeholder="Enter the description !" required>
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
                @if ($productDetailList->isEmpty())
                    <p>Product is not available.</p>
                @else
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Number</th>
                                <th>Name</th>
                                <th>Size</th>
                                <th>Color</th>
                                <th>Material</th>
                                <th>Quantity</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productDetailList as $productDetail)
                                <tr>
                                    <td> {{ $productDetail->id }}</td>
                                    <td>{{ $productDetail->productDetailProduct->name }}</td>
                                    <td>{{ $productDetail->productDetailSize->name }}</td>
                                    <td>{{ $productDetail->productDetailColor->name }}</td>
                                    <td>{{ $productDetail->productDetailMaterial->name }}</td>
                                    <td>{{ $productDetail->quantity }}</td>
                                    <td style="display:flex;align-items: center;">
                                        <a href="#" data-action="edit" data-product-id="{{ $productDetail->id }}"
                                            data-product-name="{{ $productDetail->productDetailProduct->name }}"
                                            onclick="setModalAction(this)">
                                            <button type="button" class="btn btn-warning">Edit</button>
                                        </a>
                                        |
                                        <form method="POST"
                                            action="{{ route('product.detail-delete', ['id' => $productDetail->id]) }}">
                                            @csrf
                                            @method('DELETE')<button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                <tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    <script src="{{ asset('jquery-3.6.4.min.js') }}"></script>
    <script>
        function handleFileChange() {
            if (this.files && this.files.length > 0) {
                var fileName = this.files[0].name;
                $('#hiddenFileName').val(fileName);
                $('#fileNameDisplay').text('Selected file: ' + fileName);
            }
        }

        function setModalAction(element) {
            var action = element.getAttribute('data-action');
            var productDetailId = element.getAttribute('data-product-id');
            var productName = element.getAttribute('data-product-name');

            if (action === 'edit') {
                $('#actionType').val('edit');
                $('#productDetailId').val(productDetailId);
                $('#CreateOrUpdateForm').attr('action', '{{ url('product/detail/update') }}/' + productDetailId);
                $('#exampleModalLabel').text('Edit product detail');
                $('#btnActionText').text('Save');

                // Hiển thị tên sản phẩm trong modal
                $('#productNameDisplay').text(productName);

                // Lấy dữ liệu bằng Ajax
                $.ajax({
                    type: 'GET',
                    url: '{{ url('product/detail/update') }}/' + productDetailId,
                    success: function(response) {
                        // Điền vào biểu mẫu với dữ liệu
                        $('#CreateOrUpdateForm input[name="product_id"]').val(productName);
                        $('#CreateOrUpdateForm input[name="size_id"]').val(response.data.size);
                        $('#CreateOrUpdateForm input[name="color_id"]').val(response.data.color);
                        $('#CreateOrUpdateForm input[name="material"]').val(response.data.material);
                        $('#CreateOrUpdateForm input[name="quantity"]').val(response.data.quantity);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });

                // Hiển thị modal
                $('#exampleModal').modal('show');
            }
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
            var productDetailId = $('#productDetailId').val();

            // Tạo một đối tượng FormData để chứa dữ liệu form
            var formData = new FormData($('#CreateOrUpdateForm')[0]);
            // Sử dụng Ajax để gửi dữ liệu form
            // Lấy giá trị của CSRF token
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            // Xây dựng URL dựa trên actionType
            var url = '{{ url('product/detail/update') }}/' + productDetailId;

            // Nếu là phương thức PUT, thêm CSRF token vào URL và sử dụng `_method`
            if (actionType === 'edit') {
                url = '{{ url('product/detail/update') }}/' + productDetailId;
                formData.append('_method', 'PUT'); // Thêm phương thức PUT
            }

            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                contentType: false,
                processData: false,
                success: function(response) {
                    // Đóng modal khi dữ liệu đã được lưu
                    $('#exampleModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Data saved successfully!',
                        showConfirmButton: false,
                        timer: 1000
                    });
                },
                error: function(error) {
                    console.log(error.responseJSON);
                }
            });
        }
    </script>
@endsection
