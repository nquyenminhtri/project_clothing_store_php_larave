@extends('layout')
@section('content')
    <script>
        {{ asset('jquery/dist/jquery.min.js') }}
    </script>
    <h4>List Sale invoice</h4>
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
                                        <button type="submit" class="btn btn-danger">Cancel</button>
                                    </form>
                                </td>
                            <tr>
                        @endforeach

                    </tbody>

                </table>

            </div>
        </div>

    </div>
    {{-- <div style="">{{ $saleInvoice->links() }}</div> --}}
@endsection
