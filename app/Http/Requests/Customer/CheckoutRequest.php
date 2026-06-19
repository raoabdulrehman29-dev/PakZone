<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only logged-in users can checkout
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'address_id' => ['required', 'exists:addresses,id'],
            'payment_method' => ['required', 'in:cod,card,paypal,jazzcash,easypaisa'],
            'notes' => ['nullable', 'string', 'max:500'],
            'shipping_method' => ['nullable', 'string', 'max:100'],
            'coupon_code' => ['nullable', 'string', 'exists:coupons,code'],
        ];
    }

    /**
     * Get custom error messages.
     */
    public function messages(): array
    {
        return [
            'address_id.required' => 'Please select a shipping address.',
            'address_id.exists' => 'The selected address does not exist.',
            'payment_method.required' => 'Please select a payment method.',
            'payment_method.in' => 'Invalid payment method selected.',
            'coupon_code.exists' => 'Invalid coupon code.',
        ];
    }

    /**
     * Additional validation after main validation.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Check if cart has items
            $user = auth()->user();
            $cart = \App\Models\Customer\Cart::where('user_id', $user->id)
                ->where('status', 'active')
                ->first();

            if (!$cart || $cart->items->isEmpty()) {
                $validator->errors()->add('cart', 'Your cart is empty.');
            }

            // Check if selected address belongs to user
            if ($this->has('address_id')) {
                $address = \App\Models\Customer\Address::find($this->address_id);
                if ($address && $address->user_id !== $user->id) {
                    $validator->errors()->add('address_id', 'Invalid address selected.');
                }
            }
        });
    }
}
