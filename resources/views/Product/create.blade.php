@extends('layout')
@section('content')
    <h1>Create new product</h1>
    <div class="page-body">
        <div class="row">
            <div class="col-sm-12">
                <!-- Basic Form Inputs card start -->
                <div class="card">
                    <div class="card-block">
                        <form method='POST' action="{{ route('product.handle-create') }}">
                            @csrf
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Product Name</label>
                                <div class="col-sm-10">
                                    <input type="text" name="name" class="form-control"
                                        placeholder="Enter the product name !">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Description</label>
                                <div class="col-sm-10">
                                    <textarea rows="5" cols="5" name="description" class="form-control" placeholder="Enter the description !"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Category product</label>
                                <div class="col-sm-10">
                                    <select name="select" class="form-control">
                                        @foreach ($productCategoryList as $productCategory)
                                            <option value="{{ $productCategory->id }}">{{ $productCategory->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Price</label>
                                <div class="col-sm-10">
                                    <input type="text" name="price" class="form-control"
                                        placeholder="Enter the price !">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label" name="image">Image</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <button type="submit"
                                        class=" btn waves-effect waves-light btn-primary btn-outline-primary"><i
                                            class="icofont icofont-user-alt-3"></i>Create</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <!-- Basic Form Inputs card end -->
            </div>
        </div>
    </div>
@endsection
