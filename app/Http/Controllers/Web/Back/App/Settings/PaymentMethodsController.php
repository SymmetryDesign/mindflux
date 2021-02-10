<?php

namespace App\Http\Controllers\Web\Back\App\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentMethodsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('tenant.owner');
    }

    /**
     * Store a newly created payment method.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nonce' => 'required',
        ]);

        auth()->user()->tenant->addPaymentMethod(
            $request->input('payment_method')
        );

        session()->flash('message', __('app.messages.payment-method-added'));

        return back();
    }

    /**
     * Update the default payment method.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        tenant()->setDefaultPaymentMethod(
            $request->payment_method
        );

        session()->flash('message', __('app.messages.default-payment-method-changed'));

        return back();
    }

    /**
     * Delete an existing payment method.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        tenant()->deletePaymentMethod(
            $request->payment_method
        );

        session()->flash('message', __('app.messages.payment-method-deleted'));

        return back();
    }
}
