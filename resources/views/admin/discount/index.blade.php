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
                            @include('components.alert')
                            <div class="col-md-12 d-flex flex-row-reverse">
                                <a href="{{ route('admin.discount.create') }}" class="btn btn-sm btn-primary">Add Discount</a>
                            </div>
                            <table class="table mt-4">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Code</th>
                                        <th>Description</th>
                                        <th>Percentage</th>
                                        <th colspan="2">Action</th>
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($discounts as $discount)
                                    <tr>
                                        <td>{{ $discount->name }}</td>
                                        <td>
                                            <span class="badge bg-primary">{{ $discount->code }}</span>
                                        </td>
                                        <td>{{ $discount->description }}k</td>
                                        <td>{{ $discount->percentage }}%</td>
                                        {{-- <td>
                                            @if ($checkout->is_paid)
                                                <span class="badge bg-success">Paid</span>
                                            @else
                                                <span class="badge bg-warning">Waiting</span>
                                            @endif
                                        </td> --}}
                                        <td>
                                            <td>
                                                <a href="{{ route('admin.discount.edit', $discount->id) }}" class="btn btn-warning">Edit</a>
                                            </td>
                                            <td>
                                                <form action="{{ route('admin.discount.destroy', $discount->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </td>
                                        {{-- <td>
                                            @if ( !$checkout->is_paid)
                                                <form action="{{ route('admin.checkout.update', $checkout->id) }}" method="POST">
                                                    @csrf
                                                    <button class="btn btn-primary btn-sm">
                                                        Set to Paid
                                                    </button>
                                                </form>
                                            @else
                                                <button class="btn btn-success btn-sm">
                                                    Already Paid
                                                </button>
                                            </form>
                                            @endif
                                        </td> --}}
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3">No Discount Created</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection