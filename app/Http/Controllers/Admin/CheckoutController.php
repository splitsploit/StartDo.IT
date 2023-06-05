<?php

namespace App\Http\Controllers\Admin;

use App\Models\Checkout;
use Illuminate\Http\Request;
use App\Mail\Checkout\SuccessMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function update(Request $request, Checkout $checkout) {

        $checkout->is_paid = true;

        $checkout->save();

        // send email

        Mail::to($checkout->user->email)->send(new SuccessMail($checkout));

        $request->session()->flash('success', "Checkout id {$checkout->id} has been successfully updated");

        return redirect()->route('admin.dashboard');
    }
}
