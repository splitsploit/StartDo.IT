<?php

namespace App\Http\Controllers\User;

use Midtrans;
use App\Models\Camp;
use App\Models\Checkout;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\Checkout\CheckoutMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\User\Checkout\StoreRequest;
use Exception;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVERKEY');
        \Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
        \Midtrans\Config::$isSanitized = env('MIDTRANS_IS_SANITIZED');
        \Midtrans\Config::$is3ds = env('MIDTRANS_3DS');
    }
    
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Camp $camp, Request $request)
    {

        if($camp->isRegistered) {

            $request->session()->flash('error', "You Already Join This {$camp->title}");

            return redirect()->route('user.dashboard');
        }

        return view('checkout.create', [
            'camp' => $camp
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request, Camp $camp)
    {
        // return $request->except('_token');
        // return $camp;
        // return $request->all();

        // mapping request data
        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['camp_id'] = $camp->id;

        // update data user
        $user = Auth::user();
        $user->email = $data['email'];
        $user->name = $data['name'];
        $user->occupation = $data['occupation'];
        $user->save();

        // create checkout
        $checkout = Checkout::create($data);

        // midtrans payment gateway
        $this->getSnapRedirect($checkout);

        // send email notification
        $userLogin = Auth::user()->email;

        Mail::to($userLogin)->send(new CheckoutMail($checkout));

        return redirect(route('checkout.success'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Checkout $checkout)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Checkout $checkout)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Checkout $checkout)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Checkout $checkout)
    {
        //
    }

    public function success() {
        return view('checkout.success');
    }

    // public function invoice(Checkout $checkout) {
    //     return $checkout;
    // }

    public function getSnapRedirect(Checkout $checkout) {

        $orderId = $checkout->id.'-'.Str::random(5);
        $price = $checkout->camp->price * 1000;

        $checkout->midtrans_booking_code = $orderId;

        $transaction_details = [
            'order_id' => $orderId,
            'gross_amount' => $price,
        ];

        $item_details[] = [
            'id' => $orderId,
            'price' => $price,
            'quantity' => 1,
            'name' => "Payment for {$checkout->camp->title}",
        ];

        $userData = [
            'first_name' => $checkout->user->name,
            'last_name' => "",
            'address' => $checkout->user->address,
            'city' => "",
            'postal_code' => "",
            'phone' => $checkout->user->phone,
            'country_code' => "IDN",
        ];

        $customer_details = [
            "first_name" => $checkout->user->name,
            "last_name" => "",
            "email" => $checkout->user->email,
            "phone" => $checkout->user->phone,
            "billing_address" => $userData,
            "shipping_address" => $userData,
        ];

        $midtrans_params = [
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
            'item_details' => $item_details,
        ];

        try {

            // Get SNAP payment URL
            $paymentUrl = \Midtrans\Snap::createTransaction($midtrans_params)->redirect_url;
            $checkout->midtrans_url = $paymentUrl;
            $checkout->save();

            return $paymentUrl;

        } catch (Exception $e) {

            //throw $th;
            return false;

        }
    }
}
