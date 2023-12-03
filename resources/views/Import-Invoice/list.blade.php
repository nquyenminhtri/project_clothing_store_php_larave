@extends('layout')
@section('content')
    <div style="margin-left:1%;withd:100%;height:50px;display:flex; margin-top:-20px" class="row">
        <h4 style="width:50%;">List Import Invoice</h4>
        <div style="width:40%;" class="col-md-6">

            <input style="width:100%;" type="text" class="form-control" id="search" placeholder="Enter keywords">
        </div>
    </div>

    <div class="card">
        <a href="{{ route('import-invoice.create') }}"><button type="button" class="btn btn-primary">Create new Import
                invoice</button></a>
        <div class="card-block table-border-style">
            <div class="table-responsive">
                <table id="tableContainer" class="table table-hover">
                    <thead>
                        <tr>
                            <th>Number</th>
                            <th>Admin</th>
                            <th>Supplier</th>
                            <th>Import date</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($importInvoiceList as $importInvoice)
                            <tr>
                                <td> {{ $importInvoice->id }}</td>
                                <td>{{ $importInvoice->importInvoiceAdmin->name }}</td>
                                <td>{{ $importInvoice->importInvoiceSupplier->name }}</td>
                                <td>{{ $importInvoice->import_date }}</td>
                                <td>{{ $importInvoice->total_amount }}</td>
                                <td style="display:flex;align-items: center;">
                                    <a href="{{ route('import-invoice.detail-list', ['id' => $importInvoice->id]) }}"><button
                                            class="btn waves-effect waves-light btn-info btn-outline-info"><i
                                                class="icofont icofont-info-square"></i>Detail</button></a>|
                                    <a href="{{ route('import-invoice.update', ['id' => $importInvoice->id]) }}"><button
                                            type="button" class="btn btn-warning">Edit</button></a>
                                    |
                                    <form method="POST"
                                        action="{{ route('import-invoice.delete', ['id' => $importInvoice->id]) }}">
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
    <div style="">{{ $importInvoiceList->links() }}</div>
    <script>
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
