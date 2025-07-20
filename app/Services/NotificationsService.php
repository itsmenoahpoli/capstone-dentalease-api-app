<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NotificationsService
{
    private string $api_key;
    private string $api_url;
    private string $sender_name;

    public function __construct()
    {
        $this->api_key = config('semaphore.api_key');
        $this->api_url = config('semaphore.api_url');
        $this->sender_name = config('semaphore.sender_name');
    }

    public function send_sms($phone, $message)
    {
        $smsData = [
            'phone'     => $phone,
            'message'   => $message,
            'sender'    => $this->sender_name,
            'timestamp' => now()->toISOString(),
        ];

        Log::channel('sms')->info('SMS sent', $smsData);

        $response = Http::asForm()->post($this->api_url, [
            'apikey'    => $this->api_key,
            'number'    => $phone,
            'message'   => $message,
            'sender'    => $this->sender_name,
        ]);

        $responseData = $response->json();

        if ($response->successful()) {
            Log::channel('sms')->info('SMS sent successfully', array_merge($smsData, ['response' => $responseData]));
        } else {
            Log::channel('sms')->error('SMS sending failed', array_merge($smsData, ['response' => $responseData]));
            throw new \Exception('SMS sending failed: ' . json_encode($responseData));
        }

        return $responseData;
    }
}
