<?php

namespace ArtifyForm\Integration\SignalR;

class SignalRNotifier
{
    private $endpoint;
    private $hubName;
    private $accessKey;

    public function __construct(string $endpoint, string $hubName, string $accessKey)
    {
        $this->endpoint = rtrim($endpoint, '/');
        $this->hubName = strtolower($hubName);
        $this->accessKey = $accessKey;
    }

    /**
     * Broadcasts a message to connected client WebSockets via Azure SignalR REST API upon form success.
     */
    public function broadcast(string $methodTarget, array $arguments): bool
    {
        $url = "{$this->endpoint}/api/v1/hubs/{$this->hubName}";
        
        // SignalR Requires JWT Token based Authentication Server-to-Server
        $payload = [
            'exp' => time() + 3600,
            'aud' => $url
        ];
        
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode(json_encode($payload)));
        
        // Generate HMAC SHA256 Signature
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $this->accessKey, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
        
        $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

        $messagePayload = [
            'target' => $methodTarget,
            'arguments' => $arguments
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $jwt
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($messagePayload));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $httpCode === 202; // Azure Returns 202 Accepted on success
    }
}
