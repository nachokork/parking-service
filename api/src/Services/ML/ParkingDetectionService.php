<?php

namespace App\Services\ML;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ParkingDetectionService
{
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function analyzeParkingImage(string $imagePath): array
    {
        $response = $this->client->request(
            'POST',
            'http://parking_service:5000/detect',
            [
                'headers' => [
                    'Content-Type' => 'multipart/form-data',
                ],
                'body' => [
                    'file' => fopen($imagePath, 'r'),
                ],
            ]
        );

        return $response->toArray();
    }
}