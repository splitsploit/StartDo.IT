<?php

namespace App\Http\Controllers\User;

use Midtrans;
use Exception;
use App\Models\Camp;
use App\Models\Checkout;
use App\Models\Discount;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\Checkout\CheckoutMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\User\Checkout\StoreRequest;

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
        $user->phone = $data['phone'];
        $user->address = $data['address'];
        $user->save();

        // check discount
        if($request->discount) {
            $discount = Discount::where('code', $request->discount)->first();
            $data['discount_id'] = $discount->id;
            $data['discount_percentage'] = $discount->percentage;
        }

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

        $item_details[] = [
            'id' => $orderId,
            'price' => $price,
            'quantity' => 1,
            'name' => "Payment for {$checkout->camp->title}",
        ];

        // if checkout has discount
        $discountPrice = 0;
        if($checkout->discount) {
            
            // logic price discount
            $discountPrice = $price * $checkout->discount_percentage / 100;

            $item_details[] = [
                'id' => $checkout->discount->code,
                'price' => -$discountPrice,
                'quantity' => 1,
                'name' => "Discount {$checkout->discount->name} ({ $checkout->discount_percentage }%)",
            ];
        }

        $total = $price - $discountPrice;
        $transaction_details = [
            'order_id' => $orderId,
            'gross_amount' => $total,
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
            $checkout->total = $total;
            $checkout->save();

            return $paymentUrl;

        } catch (Exception $e) {

            //throw $th;
            return false;

        }
    }

    public function midtransCallback(Request $request) {
        $notif =  $request->method() == 'POST' ? new Midtrans\Notification() : \Midtrans\Transaction::status($request->order_id) ;

        $transaction_status = $notif->transaction_status;
        $fraud = $notif->fraud_status;

        $checkout_id = explode('-', $notif->order_id)[0];
        $checkout = Checkout::find($checkout_id);

        if ($transaction_status == 'capture') {
            if ($fraud == 'challenge') {
                // TODO Set payment status in merchant's database to 'challenge'
                $checkout->payment_status = 'pending';
            }
            else if ($fraud == 'accept') {
                // TODO Set payment status in merchant's database to 'success'
                $checkout->payment_status = 'paid';
            }
        }
        else if ($transaction_status == 'cancel') {
            if ($fraud == 'challenge') {
                // TODO Set payment status in merchant's database to 'failure'
                $checkout->payment_status = 'failed';
            }
            else if ($fraud == 'accept') {
                // TODO Set payment status in merchant's database to 'failure'
                $checkout->payment_status = 'failed';
            }
        }
        else if ($transaction_status == 'deny') {
                // TODO Set payment status in merchant's database to 'failure'
                $checkout->payment_status = 'failed';    
        }
        else if ($transaction_status == 'settlement') {
                // TODO set payment status in merchant's database to 'Settlement'
                $checkout->payment_status = 'paid';    
        }
        else if ($transaction_status == 'pending') {
                // TODO set payment status in merchant's database to 'Pending'
                $checkout->payment_status = 'pending';
        }
        else if ($transaction_status == 'expire') {
                // TODO set payment status in merchant's database to 'expire'
                $checkout->payment_status = 'failed';
        }

        $checkout->save();
        return view('checkout.success');
    }
}
