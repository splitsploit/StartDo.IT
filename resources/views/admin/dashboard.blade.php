@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-8 offset-2">
                <div class="card">
                    <div class="card-header">
                        StartDo.IT List Transaction
                    </div>
                    <div class="card-body">
                        @include('components.alert')
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Camp</th>
                                    <th>Price</th>
                                    <th>Register Data</th>
                                    <th>Paid Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($checkouts as $checkout)
                                <tr>
                                    <td>{{ $checkout->user->name }}</td>
                                    <td>{{ $checkout->camp->title }}</td>
                                    <td>{{ $checkout->camp->price }}k</td>
                                    <td>{{ $checkout->created_at->format('M d Y') }}</td>
                                    <td>
                                        @if ($checkout->is_paid)
                                            <span class="badge bg-success">Paid</span>
                                        @else
                                            <span class="badge bg-warning">Waiting</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="#">
                                            @csrf
                                            <button class="btn btn-primary btn-sm">
                                                Set to Paid
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">No Data Transaction</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection