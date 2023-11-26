@extends('layout')
@section('content')
    <h1>Update Material</h1>
    <div class="page-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-block">
                        <form method='POST' action="{{ route('material.handle-update', ['id' => $material->id]) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Material name</label>
                                <div class="col-sm-10">
                                    <input type="text" name="name" class="form-control"
                                        value= "{{ $material->name }}">
                                </div>
                            </div>
                            <button type="submit" class=" btn waves-effect waves-light btn-primary btn-outline-primary"><i
                                    class="icofont icofont-user-alt-3"></i>Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
