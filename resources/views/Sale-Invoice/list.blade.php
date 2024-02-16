@extends('layout')
@section('content')
    <div style="margin-left:1%;withd:100%;height:50px;display:flex; margin-top:-20px" class="row">
        <h4 style="width:50%;">List Sale Invoice</h4>
        <div style="width:40%;" class="col-md-6">

            <input style="width:100%;" type="text" class="form-control" id="search" placeholder="Enter keywords">
        </div>
    </div>
    <div class="card">
        <div class="card-block table-border-style">
            <div class="table-responsive">
                <table id="tableContainer" class="table table-hover">
                    <thead>
                        <tr>
                            <th>Number</th>
                            <th>Customer</th>
                            <th>Export date</th>
                            <th>Status</th>
                            <th>Payment method</th>
                            <th>Total amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($saleInvoiceList as $saleInvoice)
                            <tr>
                                <td> {{ $saleInvoice->id }}</td>
                                <td>{{ $saleInvoice->saleInvoiceCustomer->name }}</td>
                                <td>{{ $saleInvoice->export_date }}</td>
                                <td>
                                    @if ($saleInvoice->status === 'unconfimred')
                                        <div class="label-main">
                                            <label class="label label-warning">{{ $saleInvoice->status }}</label>
                                        </div>
                                    @elseif($saleInvoice->status === 'delivering')
                                        <div class="label-main">
                                            <label class="label label-success">{{ $saleInvoice->status }}</label>
                                        </div>
                                    @elseif($saleInvoice->status === 'successed')
                                        <div class="label-main">
                                            <label class="label label-primary">{{ $saleInvoice->status }}</label>
                                        </div>
                                    @else
                                        <div class="label-main">
                                            <label class="label label-danger">{{ $saleInvoice->status }}</label>
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $saleInvoice->payment_method }}</td>
                                <td>{{ $saleInvoice->total_amount }}</td>
                                <td style="display:flex;align-items: center;">
                                    <form method="POST"
                                        action="{{ route('sale-invoice.confirm', ['id' => $saleInvoice->id]) }}">
                                        @csrf<button class="btn waves-effect waves-light btn-primary btn-outline-primary"><i
                                                class="icofont icofont-info-square"></i>
                                            Confirm</button>
                                    </form>|
                                    <a href="{{ route('sale-invoice.detail-list', ['id' => $saleInvoice->id]) }}"><button
                                            class="btn waves-effect waves-light btn-info btn-outline-info"><i
                                                class="icofont icofont-info-square"></i>Detail</button></a>|
                                    <form method="POST"
                                        action="{{ route('sale-invoice.cancel', ['id' => $saleInvoice->id]) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-danger"
                                            @if ($saleInvoice->status === 'successed') disabled @endif>
                                            Cancel
                                        </button>
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
    {{-- <div style="">{{ $saleInvoice->links() }}</div> --}}
    @php
        $hideCardContent = true;
    @endphp
@endsection
