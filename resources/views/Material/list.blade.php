@extends('layout')
@section('content')
    <h1>List material</h1>
    <a href="{{ route('material.create') }}"><button type="submit"
            class="btn waves-effect waves-light btn-primary btn-outline-primary"><i
                class="icofont icofont-user-alt-3"></i>Create new material</button></a>
    <div class="card">
        <div class="card-block table-border-style">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Number</th>
                            <th>Material Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($materialList as $material)
                            <tr>
                                <td> {{ $material->id }}</td>
                                <td>{{ $material->name }}</td>
                                <td style="display:flex;align-items: center;">
                                    <a href="{{ route('material.update', ['id' => $material->id]) }}"><button type="button"
                                            class="btn btn-warning">Edit</button></a> | <form method="POST"
                                        action="{{ route('material.delete', ['id' => $material->id]) }}">@csrf
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
