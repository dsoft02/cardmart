<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PaystackService
{
    protected $secretKey;

    public function __construct()
    {
        $this->secretKey = config('services.paystack.secret_key');
    }

    public function initialize($email, $amount, $reference, $callback)
    {
        return Http::withToken($this->secretKey)
            ->post('https://api.paystack.co/transaction/initialize', [
                'email' => $email,
                'amount' => $amount * 100,
                'reference' => $reference,
                'callback_url' => $callback,
            ])->json();
    }

    public function verify($reference)
    {
        return Http::withToken($this->secretKey)
            ->get("https://api.paystack.co/transaction/verify/{$reference}")
            ->json();
    }


}
