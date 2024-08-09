<?php

namespace App\Services\Payment;

interface PaymentInterface
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     */
    public function __construct(
        \Illuminate\Http\Request $request,
        \App\Models\User|\App\Models\TempUser $user
    );

    /**
     * Generate a payment intent
     *
     * @param int|float $amount     The amount to initialize the transaction with
     * @param callable $successCallback     The callback function to call when the transaction is initialized
     * @param callable $errorCallback    The callback function to call when an error occurs
     * @param bool $respond     Wether to return a response or not.
     * @return array|object
     */
    public function intent(
        int|float $amount,
        ?callable $successCallback = null,
        ?callable $errorCallback = null,
        ?bool $respond = true
    );

    /**
     * Verify a payment intent
     *
     * @param string $reference
     * @param callable $successCallback
     * @param callable $errorCallback   The callback function to call when an error occurs
     * @param bool $respond     Wether to return a response or not.
     * @return array|object
     */
    public function verify(
        string $reference,
        ?callable $successCallback = null,
        ?callable $errorCallback = null,
        ?bool $respond = true
    );

    /**
     * Deauthorize a payment intent
     *
     * @param string $authorization_code
     * @param callable $successCallback
     * @param callable $errorCallback   The callback function to call when an error occurs
     * @param bool $respond     Wether to return a response or not.
     * @return array|object
     */
    public function deauthorize(
        string $authorization_code,
        ?callable $successCallback = null,
        ?callable $errorCallback = null,
        ?bool $respond = true
    );

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
    );
}
