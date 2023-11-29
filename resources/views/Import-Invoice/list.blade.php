@extends('layout')
@section('content')
    <h1>List Import invoice</h1>

    <div class="card">
        <a href="{{ route('import-invoice.create') }}"><button type="button" class="btn btn-primary">Create new Import
                invoice</button></a>
        <div class="card-block table-border-style">
            <div class="table-responsive">
                <table id="tableContainer" class="table table-hover">
                    <thead>
                        <tr>
                            <th>Number</th>
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
@endsection
