@extends('layout')
@section('content')
    <h1>Create new admin</h1>
    <div class="page-body">
        <div class="row">
            <div class="col-sm-12">
                <!-- Basic Form Inputs card start -->
                <div class="card">
                    <div class="card-block">
                        <form method='POST' action="{{ route('admin.handle-create') }}">
                            @csrf
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Full name</label>
                                <div class="col-sm-10">
                                    <input type="text" name="name" class="form-control"
                                        placeholder="Enter the full name !">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Username</label>
                                <div class="col-sm-10">
                                    <input type="text" name="user_name" class="form-control"
                                        placeholder="Enter the username !">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Password</label>
                                <div class="col-sm-10">
                                    <input type="password" name="password" class="form-control"
                                        placeholder="Enter the password !">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Image</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" name="image">
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
