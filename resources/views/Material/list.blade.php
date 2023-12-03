@extends('layout')
@section('content')
    <div style="margin-left:1%;withd:100%;height:50px;display:flex; margin-top:-20px" class="row">
        <h4 style="width:50%;">List Material</h4>
        <div style="width:40%;" class="col-md-6">

            <input style="width:100%;" type="text" class="form-control" id="search" placeholder="Enter keywords">
        </div>
    </div>
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
    @php
        $hideCardContent = true;
    @endphp
@endsection
