<?php

namespace App\Http;

class ApiRequest
{
    private string $baseUrl;

    public function __construct()
    {
        // A config mappából is olvashatnánk, de első körben legyen fix
        $this->baseUrl = "http://localhost:8000";
    }

    public function get(string $endpoint): array
    {
        $url = $this->baseUrl . $endpoint;
        $json = file_get_contents($url);

        return json_decode($json, true);
    }

    public function post(string $endpoint, array $data): array
    {
        return $this->send("POST", $endpoint, $data);
    }

    public function put(string $endpoint, array $data): array
    {
        return $this->send("PUT", $endpoint, $data);
    }

    public function delete(string $endpoint): array
    {
        return $this->send("DELETE", $endpoint);
    }

    private function send(string $method, string $endpoint, array $data = []): array
    {
        $url = $this->baseUrl . $endpoint;

        $options = [
            "http" => [
                "method"  => $method,
                "header"  => "Content-Type: application/json",
                "content" => json_encode($data)
            ]
        ];

        $context = stream_context_create($options);
        $json = file_get_contents($url, false, $context);

        return json_decode($json, true);
    }
}