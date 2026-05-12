<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;


class SmsController extends Controller
{
    public function send()
    {
        $response = Http::withHeaders([
            'api-key' => env('BREVO_API_KEY'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post('https://api.brevo.com/v3/transactionalSMS/sms', [
            'sender' => 'Laravel',
            'recipient' => '628xxxxxxxxxx',
            'content' => 'Halo ini SMS dari Laravel dan Brevo'
        ]);

        return $response->body();
    }
}
