<?php

namespace App\Services\Parking\Responses;

class ParkingDetectionResponse
{
    public function __construct(

    ){}

    public function parkingImageDetails(array $response): array
    {
        return  [
            'Plazas ocupadas' => $response['cars'],
            'Plazas especiales' => $response['special_slots'],
            'Plazas libres' => $response['empty_slots'],
            'Plazas totales' => $response['total_detections'],
        ];
    }
}