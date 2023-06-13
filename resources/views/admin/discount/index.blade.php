@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-8 offset-2">
                <div class="card">
                    <div class="card-header mt-3">
                        Add Discount
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 d-flex flex-row-reverse">
                                <a href="{{ route('admin.discount.create') }}" class="btn btn-sm btn-primary">Add Discount</a>
                            </div>
                            @include('components.alert')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection