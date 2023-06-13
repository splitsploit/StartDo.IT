@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-8 offset-2">
                <div class="card">
                    <div class="card-header mt-3">
                        Create New Discount
                    </div>
                    <div class="card-body">
                        @include('components.alert')
                        <form action="{{ route('admin.discount.store') }}" method="POST">
                            @csrf
                            <div class="form-group mb-4">
                                <label for="" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control">
                            </div>
                            <div class="form-group mb-4">
                                <label for="" class="form-label">Code</label>
                                <input type="text" name="name" class="form-control">
                            </div>
                            <div class="form-group mb-4">
                                <label for="" class="form-label">Description</label>
                                <textarea name="description" cols="0" rows="2" class="form-control"></textarea>
                            </div>
                            <div class="form-group mb-4">
                                <label for="" class="form-label">Discount Percentage</label>
                                <input type="number" name="percentage" class="form-control" min="1" max="100">
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary">Create Discount</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection