@extends('layout')
@section('content')
    <h1>List Comment</h1>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary btn-click" data-toggle="modal" data-target="#exampleModal">
        Launch demo modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
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
@endsection
$('.btn-click').click(function(){

})
