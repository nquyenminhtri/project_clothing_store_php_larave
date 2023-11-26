@extends('layout')
@section('content')
    <h1>List product category</h1>
    <a href="{{ route('product-category.create') }}"><button type="submit"
            class="btn waves-effect waves-light btn-primary btn-outline-primary"><i
                class="icofont icofont-user-alt-3"></i>Create new product category</button></a>
    <div class="card">
        <div class="card-block table-border-style">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Number</th>
                            <th>Product category Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productCategoryList as $productCategory)
                            <tr>
                                <td> {{ $productCategory->id }}</td>
                                <td>{{ $productCategory->name }}</td>
                                <td style="display:flex;align-items: center;">
                                    <a href="{{ route('product-category.update', ['id' => $productCategory->id]) }}"><button
                                            type="button" class="btn btn-warning">Edit</button></a> | <form method="POST"
                                        action="{{ route('product-category.delete', ['id' => $productCategory->id]) }}">
                                        @csrf @method('DELETE')<button type="submit" class="btn btn-danger">Delete</button>
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
