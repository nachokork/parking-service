<?php
namespace App\Services\Parking;

use Symfony\Component\HttpFoundation\JsonResponse;

interface ParkingHandlerInterface
{
    public function getSpaces(): JsonResponse;

    public function getStatus(): JsonResponse;

    public function updateStatus(): JsonResponse;

    public function getZones(): JsonResponse;
}