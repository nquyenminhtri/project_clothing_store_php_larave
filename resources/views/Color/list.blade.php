@extends('layout')
@section('content')
    <div style="margin-left:1%;withd:100%;height:50px;display:flex; margin-top:-20px" class="row">
        <h4 style="width:50%;">List color</h4>
        <div style="width:40%;" class="col-md-6">
            <input style="width:100%;" type="text" class="form-control" id="search" placeholder="Enter keywords">
        </div>
    </div>
    <!-- Hidden Inputs -->
    <input type="hidden" id="colorId" name="color" value="">
    <input type="hidden" id="actionType" name="actionType" value="create">
    <input type="hidden" id="hiddenFileName" name="hiddenFileName" value="">
    <!-- Button trigger modal for Create -->
    <button type="button" class="waves-effect waves-light btn-primary btn-outline-primary btn btn-primary btn-click"
        onclick="setModalAction('create')">
        <i class="icofont icofont-user-alt-3"></i>Create new color
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
                                <input type="color" class="form-control" id="colorPicker" name="color" />
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
                            <th>Code</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($colorList as $color)
                            <tr>
                                <td> {{ $color->id }}</td>
                                <td>{{ $color->name }}</td>
                                <td style=" width: 10px; height: 10px; background-color: {{ $color->color_code }};">
                                    {{ $color->color_code }}</td>
                                <td style="display:flex;align-items: center;">
                                    <a href="#" onclick="setModalAction('edit', {{ $color->id }})"><button
                                            type="button" class="btn btn-warning">Edit</button></a>
                                    |
                                    <form method="POST" action="{{ route('color.delete', ['id' => $color->id]) }}">
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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        function handleFileChange() {
            if (this.files && this.files.length > 0) {
                var fileName = this.files[0].name;
                $('#hiddenFileName').val(fileName);
                $('#fileNameDisplay').text('Selected file: ' + fileName);
            }
        }
        $(document).ready(function() {
            $("#colorPicker").spectrum({
                preferredFormat: "hex",
                showInput: true,
                showPalette: true,
                palette: [
                    ["#ff0000", "#00ff00", "#0000ff"],
                    // Các màu khác có thể được thêm vào đây
                ],
            });

            // Lắng nghe sự kiện khi giá trị màu thay đổi
            $("#colorPicker").on("change", function() {
                var selectedColor = $(this).val();
                // Cập nhật giá trị màu vào hidden input
                $("#colorId").val(selectedColor);
            });
        });

        // Hàm để set hành động của modal (create hoặc edit)
        function setModalAction(action, colorId = null) {

            if (action === 'create') {
                // Nếu là tạo mới, đặt lại biểu mẫu và thay đổi tiêu đề modal
                $('#colorId').val('');
                currentColorId = colorId;
                $('#actionType').val('create');
                $('#CreateOrUpdateForm').attr('action', '{{ route('color.handle-create') }}');
                $('#CreateOrUpdateForm')[0].reset();
                $("#colorPicker").spectrum("set", "#000000");
                $('#exampleModalLabel').text('Create a new color');
                $('#btnActionText').text('Create');
            } else if (action === 'edit') {
                $('#actionType').val('edit');
                $('#colorId').val(colorId);
                currentColorId = colorId;
                $('#CreateOrUpdateForm').attr('action', '{{ url('color/update') }}/' + colorId);
                $('#exampleModalLabel').text('Edit color');
                $('#btnActionText').text('Save');

                // Lấy dữ liệu bằng Ajax
                $.ajax({
                    type: 'GET',
                    url: '{{ url('color/update') }}/' + colorId,
                    success: function(response) {
                        $('#CreateOrUpdateForm input[name="name"]').val(response.data.name);
                        $('#CreateOrUpdateForm input[name="color"]').val(response.data.color_code);
                        $("#colorPicker").spectrum("set", response.data.color);

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
            // Nếu form không hợp lệ, dừng lại và không gửi Ajax request
            if (!formIsValid) {
                return;
            }

            var actionType = $('#actionType').val();
            // Lấy giá trị của ID (nếu có)
            var colorId = currentColorId;
            console.log('colorID: ', colorId);
            // Tạo một đối tượng FormData để chứa dữ liệu form
            var formData = new FormData($('#CreateOrUpdateForm')[0]);
            // Lấy giá trị của CSRF token
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            // Xây dựng URL dựa trên actionType
            var url = (actionType === 'create') ? '{{ route('color.handle-create') }}' :
                '{{ url('color/update') }}/' + colorId;
            // Nếu là phương thức PUT, thêm CSRF token vào URL và sử dụng `_method`
            if (actionType === 'edit') {
                url = '{{ url('color/update') }}/' + colorId;
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

        function handleDelete(colorId) {
            $.ajax({
                type: 'DELETE',
                url: '/color/delete/' + colorId,
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
            var deleteRoute = '{{ route('color.delete', ['id' => ':id']) }}';
            var deleteMethod = '{{ method_field('DELETE') }}';
            $.each(data, function(index, color) {
                var deleteUrl = deleteRoute.replace(':id', color.id);
                var row = '<tr>' +
                    '<td>' + color.id + '</td>' +
                    '<td>' + color.name + '</td>' +
                    '<td>' + color.color_code + '</td>' +
                    '<td style="display:flex;align-items: center;">' +
                    '<a href="#" onclick="setModalAction(\'edit\', ' + color.id + ')">' +
                    '<button type="button" class="btn btn-warning">Edit</button>' +
                    '</a> | ' +
                    '<form id="deleteForm_' + color.id +
                    '" onsubmit="return confirm(\'Are you sure you want to delete this color?\');" >' +
                    '@csrf' +
                    '@method('DELETE')' +
                    '<button type="button" class="btn btn-danger" onclick="handleDelete(' + color.id +
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
