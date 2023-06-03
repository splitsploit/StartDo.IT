<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Checkout;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function update(Request $request, Checkout $checkout) {

        $checkout->is_paid = true;

        $checkout->save();

        $request->session()->flash('success', "Checkout id {$checkout->id} has been successfully updated");

        return redirect()->route('admin.dashboard');
    }
}
