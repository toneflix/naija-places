<?php

namespace App\Services\Payment;

use App\Enums\HttpStatus;
use App\Helpers\Providers;
use App\Models\User;
use Illuminate\Http\Request;
use Valorin\Random\Random;

final class WalletProcessor implements PaymentInterface
{
    protected $request;

    protected $user;

    /**
     * WalletProcessor constructor.
     */
    public function __construct(Request $request, User $user = null)
    {
        $this->request = $request;
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
        // Try to create the payment intent
        try {
            $reference = Providers::config('reference_prefix', 'TRX-') . Random::string(20, ! 1, ! 0, ! 0, ! 1);

            $this->user->pay($amount, ['main_wallet'], 'Payment for service/order.');
            $tranx = $this->user->walletLog()->latest()->first();

            $intent = new \App\Services\CustomObject([
                'id' => $tranx->id,
                'code' => HttpStatus::OK,
                'amount' => $amount,
                'status' => 'success',
                'message' => __('Transaction Complete.'),
                'balance' => $this->user->wallet_balance,
                'reference' => $tranx->reference ?: $tranx->id,
            ]);

            // Call the callback function
            if ($successCallback && $respond) {
                $intent = $successCallback($reference, $intent, $amount, $intent['message'], $intent['code']);
            }

            if ($respond) {
                return $intent;
            }
        } catch (\HPWebdeveloper\LaravelPayPocket\Exceptions\InsufficientBalanceException $e) {
            $error = new \App\Services\CustomObject([
                'code' => HttpStatus::BAD_REQUEST,
                'error' => HttpStatus::BAD_REQUEST,
                'status' => 'error',
                'message' => __('You do not have sufficient funds to complete this transaction.'),
            ]);

            if ($errorCallback) {
                $error = $errorCallback($error, $e);
            }

            if ($respond) {
                return $error;
            }
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
        $tranx = $this->user->walletLog()->whereReference($reference)->first();

        if ($tranx) {
            $response = new \App\Services\CustomObject([
                'code' => HttpStatus::OK,
                'amount' => $tranx->value,
                'status' => 'success',
                'message' => __('Transaction Verified.'),
                'balance' => $this->user->wallet_balance,
                'reference' => $tranx->reference ?: $tranx->id,
                'payment_approved' => true,
            ]);

            // Call the callback function
            if ($successCallback) {
                $response = $successCallback(
                    $reference,
                    $tranx,
                    $tranx->value,
                    $response['message'],
                    $response['code']
                );
            }

            if ($respond) {
                return $response;
            }
        } else {
            $response = [
                'code' => HttpStatus::NOT_FOUND,
                'error' => HttpStatus::NOT_FOUND,
                'status' => 'error',
                'message' => __('Transaction not found.'),
            ];

            $response = new \App\Services\CustomObject($response);
            if ($errorCallback) {
                $response = $errorCallback($response);
            }

            if ($respond) {
                return $response;
            }
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
