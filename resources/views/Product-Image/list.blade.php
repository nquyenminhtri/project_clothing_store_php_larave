@extends('layout')
@section('content')
    <h4>List productImage</h4>
    <!-- Hidden Inputs -->
    <input type="hidden" id="productImageId" name="productImageId" value="">
    <input type="hidden" id="actionType" name="actionType" value="create">
    <input type="hidden" id="hiddenFileName" name="hiddenFileName" value="">
    <!-- Button trigger modal for Create -->
    <button type="button" class="waves-effect waves-light btn-primary btn-outline-primary btn btn-primary btn-click"
        onclick="setModalAction('create')">
        <i class="icofont icofont-user-alt-3"></i>Create new productImage
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create new productImage</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="false">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="CreateOrUpdateForm" enctype="multipart/form-data" method='POST' action="">
                        @csrf
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
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Number</th>
                            <th>Product name</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productImageList as $productImage)
                            <tr>
                                <td> {{ $productImage->id }}</td>
                                <td>{{ $productImage->productImageProduct->name }}</td>
                                <td><img style="width: 100px; height: 100px;"
                                        src="{{ asset('productImage-images/' . $productImage->image) }}" alt="no image">
                                </td>
                                <td style="display:flex;align-items: center;">
                                    <a href="{{ route('productImage.detail-list', ['id' => $productImage->id]) }}"><button
                                            class="btn btn-primary waves-effect waves-light">Add photo</button></a>|
                                    <a href="#" onclick="setModalAction('edit', {{ $productImage->id }})"><button
                                            type="button" class="btn btn-warning"><i class="far fa-edit"></i></button></a>
                                    |
                                    <form method="POST"
                                        action="{{ route('productImage.delete', ['id' => $productImage->id]) }}">
                                        @csrf
                                        @method('DELETE')<button type="submit" class="btn btn-danger"><i
                                                class="fas fa-trash-alt"></i></button>
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
        function handleFileChange() {
            if (this.files && this.files.length > 0) {
                var fileName = this.files[0].name;
                $('#hiddenFileName').val(fileName);
                $('#fileNameDisplay').text('Selected file: ' + fileName);
            }
        }
        // Hàm để set hành động của modal (create hoặc edit)
        function setModalAction(action, productImageId = null) {

            if (action === 'create') {
                // Nếu là tạo mới, đặt lại biểu mẫu và thay đổi tiêu đề modal
                $('#productImageId').val('');
                $('#actionType').val('create');
                $('#CreateOrUpdateForm').attr('action', '{{ route('productImage.handle-create') }}');
                $('#CreateOrUpdateForm')[0].reset();
                $('#exampleModalLabel').text('Create a new productImage');
                $('#btnActionText').text('Create');
            } else if (action === 'edit') {
                $('#actionType').val('edit');
                $('#productImageId').val(productImageId);
                $('#CreateOrUpdateForm').attr('action', '{{ url('productImage/update') }}/' + productImageId);
                $('#exampleModalLabel').text('Edit productImage');
                $('#btnActionText').text('Save');
                // Lấy dữ liệu bằng Ajax

                $.ajax({
                    type: 'GET',
                    url: '{{ url('productImage/update') }}/' + productImageId,
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
            var productImageId = $('#productImageId').val();

            // Tạo một đối tượng FormData để chứa dữ liệu form
            var formData = new FormData($('#CreateOrUpdateForm')[0]);
            console.log('dsfs', formData);
            // Sử dụng Ajax để gửi dữ liệu form
            // Lấy giá trị của CSRF token
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            // Xây dựng URL dựa trên actionType
            var url = (actionType === 'create') ? '{{ route('productImage.handle-create') }}' :
                '{{ url('productImage/update') }}/' + productImageId;

            // Nếu là phương thức PUT, thêm CSRF token vào URL và sử dụng `_method`
            if (actionType === 'edit') {
                url = '{{ url('productImage/update') }}/' + productImageId;
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
            // In phiên bản jQuery ra console
            console.log(jQuery.fn.jquery);

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
                $('#exampleModalLabel').text('Create new productImage');
                // Đặt lại nội dung nút tạo
                $('#btnActionText').text('Create');
            });
        });
    </script>
@endsection
