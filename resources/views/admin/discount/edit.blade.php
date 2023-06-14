@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-8 offset-2">
                <div class="card">
                    <div class="card-header mt-3">
                        Update Discount: <strong>{{ $discount->name }}</strong>
                    </div>
                    <div class="card-body">
                        @include('components.alert')
                        <form action="{{ route('admin.discount.update', $discount->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group mb-4">
                                <label for="" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" required value="{{ old('name') ?: $discount->name }}">
                                @if ($errors->has('name'))
                                    <p class="text-danger">{{ $errors->first('name') }}</p>
                                @endif
                            </div>
                            <div class="form-group mb-4">
                                <label for="" class="form-label">Code</label>
                                <input type="text" name="code" class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" required value="{{ old('code') ?: $discount->code }}">
                                @if ($errors->has('code'))
                                    <p class="text-danger">{{ $errors->first('code') }}</p>
                                @endif
                            </div>
                            <div class="form-group mb-4">
                                <label for="" class="form-label">Description</label>
                                <textarea name="description" cols="0" rows="2" class="form-control">{{ old('description') ?: $discount->description }}</textarea>
                                @if ($errors->has('description'))
                                    <p class="text-danger">{{ $errors->first('description') }}</p>
                                @endif
                            </div>
                            <div class="form-group mb-4">
                                <label for="" class="form-label">Discount Percentage</label>
                                <input type="number" name="percentage" class="form-control" min="1" max="100" required value="{{ old('percentage') ?: $discount->percentage }}">
                                @if ($errors->has('percentage'))
                                    <p class="text-danger">{{ $errors->first('percentage') }}</p>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary">Update Discount</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection