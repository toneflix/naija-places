<?php

namespace App\Services\Payment;

use App\Helpers\Providers;
use App\Models\User;
use Cartalyst\Stripe\Stripe;
use Illuminate\Http\Request;

final class StripeProcessor implements PaymentInterface
{
    protected $request;

    protected $stripe;

    protected $user;

    /**
     * StripeProcessor constructor.
     */
    public function __construct(Request $request, User $user = null)
    {
        // Stripe instance
        $this->request = $request;
        $this->stripe = Stripe::make(Providers::config('stripe_secret_key', env('STRIPE_SECRET_KEY'), true));
        $this->user = $user;
    }

    /**
     * Generate a payment intent
     *
     * @param  int|float  $amount     The amount to initialize the transaction with
     * @param  callable  $successCallback     The callback function to call when the transaction is initialized
     * @param  callable  $errorCallback    The callback function to call when an error occurs
     * @param  bool  $respond     Wether to return a response or not.
     * @return array|object|\App\Services\CustomObject
     */
    public function intent(
        int|float $amount,
        callable $successCallback = null,
        callable $errorCallback = null,
        ?bool $respond = true
    ) {
        // Parameters
        $params = [
            'amount' => $amount,
            'currency' => Providers::config('app_currency', 'USD'),
            'payment_method' => $this->request->pm_id,
        ];

        // Set the customer on the payment intent
        if ($this->user->stripe_id) {
            $params['customer'] = $this->user->stripe_id;
        }

        // Try to create the payment intent
        try {
            $intent = new \App\Services\CustomObject($this->stripe->paymentIntents()->create($params));
            if (isset($intent['status']) && $intent['status'] === 'succeeded') {
                $intent['status'] = 'success';
            }
            if ($successCallback) {
                $successCallback($intent);
            }

            return $intent;
        } catch (\Cartalyst\Stripe\Exception\MissingParameterException | NotFoundException $th) {
            if ($errorCallback) {
                $errorCallback([
                    'code' => $th->getCode(),
                    'message' => $th->getMessage(),
                ]);
            }

            return new \App\Services\CustomObject([
                'error' => $th->getCode(),
                'message' => $th->getMessage(),
            ]);
        }
    }

    /**
     * Verify a payment intent
     *
     * @param  callable  $errorCallback   The callback function to call when an error occurs
     * @param  bool  $respond     Wether to return a response or not.
     * @return array|object|\App\Services\CustomObject
     */
    public function verify(
        string $reference,
        callable $successCallback = null,
        callable $errorCallback = null,
        ?bool $respond = true,
    ) {
        // Try to find the payment intent
        try {
            $ref = $this->stripe->paymentIntents()->find($reference);

            if (isset($ref['status']) && $ref['status'] === 'succeeded') {
                $ref['status'] = 'success';
                $ref['payment_approved'] = true;
            }

            $ref = new \App\Services\CustomObject($ref);
            if ($successCallback) {
                $successCallback($ref);
            }

            return $ref;
        } catch (\Cartalyst\Stripe\Exception\MissingParameterException | NotFoundException $th) {
            $error = new \App\Services\CustomObject([
                'code' => $th->getCode(),
                'error' => $th->getCode(),
                'message' => $th->getMessage(),
            ]);

            if ($errorCallback) {
                $errorCallback($error);
            }

            return $error;
        }
    }

    /**
     * Deauthorize a transaction payment
     *
     * @param  callable  $successCallback
     * @param  callable  $errorCallback
     * @param  bool  $respond Wether to return a response or not.
     */
    public function deauthorize(
        string $authorization_code,
        callable $callback = null,
        callable $error_callback = null,
        ?bool $respond = true
    ) {
    }

    /**
     * Do transfter to the specified user
     *
     * @param int|float $amount
     * @param ?string $reason
     * @param ?callable $successCallback
     * @param ?callable $errorCallback   The callback function to call when an error occurs
     * @param bool $respond     Wether to return a response or not.
     * @return array|object|\App\Services\CustomObject
     */
    public function transfer(
        int|float $amount,
        ?string $reason = null,
        ?callable $successCallback = null,
        ?callable $errorCallback = null,
        ?bool $respond = true
    ) {
    }
}
