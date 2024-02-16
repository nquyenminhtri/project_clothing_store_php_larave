@extends('layout')
@section('content')
    <div style="margin-left:1%;withd:100%;height:50px;display:flex; margin-top:-20px" class="row">
        <h4 style="width:50%;">List saleInvoice Detail</h4>
        <div style="width:40%;" class="col-md-6">

            <input style="width:100%;" type="text" class="form-control" id="search" placeholder="Enter keywords">
        </div>
    </div>
    <!-- Hidden Inputs -->
    <input type="hidden" id="saleInvoiceDetailId" name="saleInvoiceDetailId" value="">
    <input type="hidden" id="actionType" name="actionType" value="create">
    <input type="hidden" id="hiddenFileName" name="hiddenFileName" value="">
    <div class="card">
        <div class="card-block table-border-style">
            <div class="table-responsive">
                @if (empty($saleInvoiceDetailList))
                    <p>saleInvoice is not available.</p>
                @else
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Number</th>
                                <th>Sale invoice</th>
                                <th>Product</th>
                                <th>Size</th>
                                <th>Color</th>
                                <th>Quantity</th>
                                <th>Unit price</th>
                                <th>Price total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($saleInvoiceDetailList as $saleInvoiceDetail)
                                <tr>
                                    <td> {{ $saleInvoiceDetail->id }}</td>
                                    <td>{{ $saleInvoiceDetail->saleInvoiceDetailSaleInvoice->id }}</td>
                                    <td>{{ $saleInvoiceDetail->saleInvoiceDetailProduct->name }}</td>
                                    <td>{{ $saleInvoiceDetail->saleInvoiceDetailSize->name }}</td>
                                    <td>{{ $saleInvoiceDetail->saleInvoiceDetailColor->name }}</td>
                                    <td>{{ $saleInvoiceDetail->quantity }}</td>
                                    <td>{{ $saleInvoiceDetail->unit_price }}</td>
                                    <td>{{ $saleInvoiceDetail->price_total }}</td>
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
