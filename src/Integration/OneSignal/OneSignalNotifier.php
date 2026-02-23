<?php

namespace ArtifyForm\Integration\OneSignal;

class OneSignalNotifier
{
    private $appId;
    private $restApiKey;

    public function __construct(string $appId, string $restApiKey)
    {
        $this->appId = $appId;
        $this->restApiKey = $restApiKey;
    }

    /**
     * Broadcasts a real-time push notification to a specific Segment when the form successfully validates.
     */
    public function notifyAdmins(string $message, string $heading = 'New Form Submission', string $segment = 'Admin'): bool
    {
        $fields = [
            'app_id' => $this->appId,
            'included_segments' => [$segment],
            'contents' => ["en" => $message],
            'headings' => ["en" => $heading]
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic ' . $this->restApiKey
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        // In local environments curl SSL verification might fail.
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode((string)$response, true);
        return isset($result['id']);
    }
}
