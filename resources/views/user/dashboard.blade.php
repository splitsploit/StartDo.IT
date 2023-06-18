@extends('layouts.app')

@section('content')
    
    <section class="dashboard my-5">
        <div class="container">
            <div class="row text-left">
                <div class=" col-lg-12 col-12 header-wrap mt-4">
                    <p class="story">
                        DASHBOARD
                    </p>
                    <h2 class="primary-header ">
                        My Bootcamps
                    </h2>
                </div>
            </div>
            <div class="row my-5">
                <table class="table">
                    @include('components.alert')
                    <tbody>
                        @forelse ($checkouts as $checkout)
                            <tr class="align-middle">
                                <td width="18%">
                                    <img src="{{ asset('assets/images/item_bootcamp.png') }}" height="120" alt="">
                                </td>
                                <td>
                                    <p class="mb-2">
                                        <strong>{{ $checkout->camp->title }}</strong>
                                    </p>
                                    <p>
                                        {{ $checkout->created_at->format('M d Y') }}
                                    </p>
                                </td>
                                <td>
                                    <strong>
                                        Rp. {{ $checkout->total }}
                                        @if ($checkout->discount_id)
                                            <span class="badge bg-success">
                                                Use Disc: {{ $checkout->discount_percentage }}
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                No Discount Used
                                            </span>
                                        @endif
                                    </strong>
                                </td>
                                <td>
                                    {{-- not used again ( static ) --}}
                                    {{-- @if ($checkout->is_paid)
                                        <strong class="text-success">Payment Success</strong>

                                        @else
                                        <strong>Waiting for Payment</strong>

                                    @endif --}}
                                    {{ strtoupper($checkout->payment_status) }}
                                </td>
                                <td>

                                    @if($checkout->payment_status == 'waiting')

                                        <a href="{{ $checkout->midtrans_url }}" class="btn btn-primary">Pay Now</a>

                                    @endif

                                    <a href="https://wa.me/6282265157644/?text= Hai Admin, saya mau menanyakan kelas {{ $checkout->camp->title }}" class="btn btn-primary">
                                        Contact Support
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <td colspan="5">
                                <p>Nothing Data To Show</p>
                            </td>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

@endsection