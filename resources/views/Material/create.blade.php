@extends('layout')
@section('content')
    <h1>Create new material</h1>
    <div class="page-body">
        <div class="row">
            <div class="col-sm-12">
                <!-- Basic Form Inputs card start -->
                <div class="card">
                    <div class="card-block">
                        <form method='POST' action="{{ route('material.handle-create') }}">
                            @csrf
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Material Name</label>
                                <div class="col-sm-10">
                                    <input type="text" name="name" class="form-control"
                                        placeholder="Enter new material !">
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
