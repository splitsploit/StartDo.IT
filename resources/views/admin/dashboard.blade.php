@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-8 offset-2">
                <div class="card">
                    <div class="card-header mt-3">
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
                                    {{-- <th>Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($checkouts as $checkout)
                                <tr>
                                    <td>{{ $checkout->user->name }}</td>
                                    <td>{{ $checkout->camp->title }}</td>
                                    <td>
                                        <strong>Rp. {{ $checkout->total }}</strong>
                                        @if ($checkout->discount_id)
                                            <span class="badge bg-success">
                                                Use Disc: {{ $checkout->discount_percentage }}
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                No Discount Used
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $checkout->created_at->format('M d Y') }}</td>
                                    {{-- <td>
                                        @if ($checkout->is_paid)
                                            <span class="badge bg-success">Paid</span>
                                        @else
                                            <span class="badge bg-warning">Waiting</span>
                                        @endif
                                    </td> --}}
                                    <td>
                                        <strong>{{ strtoupper($checkout->payment_status) }}</strong>
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