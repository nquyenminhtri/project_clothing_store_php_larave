@extends('layout')
@section('content')
    <h1>List Product</h1>
    <a href="{{ route('product.create') }}"><button type="submit"
            class="btn waves-effect waves-light btn-primary btn-outline-primary"><i
                class="icofont icofont-user-alt-3"></i>Create new product</button></a>
    <div class="card">
        <div class="card-block table-border-style">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Number</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Image</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productList as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->description }}</td>
                                <td>{{ $product->productProductCategory->name }}</td>
                                <td>{{ $product->image }}</td>
                                <td style="display:flex;align-items: center;">
                                    <a href="{{ route('product.update', ['id' => $product->id]) }}"><button type="button"
                                            class="btn btn-warning">Edit</button></a> | <form method="POST"
                                        action="{{ route('product.delete', ['id' => $product->id]) }}">@csrf
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
