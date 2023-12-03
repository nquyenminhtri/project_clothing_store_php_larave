@extends('layout')
@section('content')
    <div style="display:flex; margin-top:-20px" class="row">
        <h4 style="margin-left:2%;margin-right:36%">List Favorite Product</h4>
        <div class="col-md-6">

            <input type="text" class="form-control" id="search" placeholder="Enter keywords">
        </div>
    </div>
    <a href="{{ route('admin.create') }}"><button type="submit"
            class="btn waves-effect waves-light btn-primary btn-outline-primary"><i
                class="icofont icofont-user-alt-3"></i>Create new admin</button></a>
    <div class="card">
        <div class="card-block table-border-style">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Number</th>
                            <th>Full name</th>
                            <th>Username</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($adminList as $admin)
                            <tr>
                                <td> {{ $admin->id }}</td>
                                <td>{{ $admin->name }}</td>
                                <td>{{ $admin->user_name }}</td>
                                <td>{{ $admin->password }}</td>
                                <td>{{ $admin->image }}</td>
                                <td>
                                    <a href="{{ route('admin.update', ['id' => $admin->id]) }}"><button type="button"
                                            class="btn btn-warning">Edit</button></a> | <a
                                        href="{{ route('admin.delete', ['id' => $admin->id]) }}"><button type="button"
                                            class="btn btn-danger">Delete</button></a>
                                </td>
                            <tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @php
        $hideCardContent = true;
    @endphp
@endsection
