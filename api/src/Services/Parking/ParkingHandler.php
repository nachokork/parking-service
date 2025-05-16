<?php
namespace App\Services\Parking;

use App\Repository\ParkingSpaceRepository;
use App\Repository\ParkingStatusRepository;
use App\Repository\ParkingZoneRepository;
use App\Responses\ApiResponses;
use App\Services\PSPACE\ParkingSpaceService;
use App\Services\PSTATUS\ParkingStatusService;
use App\Services\PZONE\ParkingZoneService;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\JsonResponse;

class ParkingHandler implements ParkingHandlerInterface
{
    public function __construct(
        //protected ParkingSpaceService     $spaceService,
        //protected ParkingStatusService    $statusService,
        //protected ParkingZoneService      $zoneService,
        protected ParkingService            $parkingService,
        protected ParkingSpaceRepository    $repoSpace,
        protected ParkingStatusRepository   $repoStatus,
        protected ParkingZoneRepository     $repoZone,
    ){}

    public function getSpaces(): JsonResponse
    {
        try {

            return ApiResponses::success('success', $this->repoSpace->findAll());
        } catch (\Exception $e) {
            return ApiResponses::error('error', $e->getMessage());
        }
    }

    public function getStatus(): JsonResponse
    {
        try {

            return ApiResponses::success('success', $this->repoStatus->findAll());
        } catch (\Exception $e) {
            return ApiResponses::error('error', $e->getMessage());
        }
    }

    public function updateStatus(): JsonResponse
    {
        try {

            return ApiResponses::success('success');
        } catch (\Exception $e) {
            return ApiResponses::error('error', $e->getMessage());
        }
    }

    public function getZones(): JsonResponse
    {
        try {
            return ApiResponses::success('success', $this->repoZone->findAll());
        } catch (\Exception $e) {
            return ApiResponses::error('error', $e->getMessage());
        }
    }

    public function checkSpacesByZone(File $file): JsonResponse
    {
        try {
            $response = $this->parkingService->ckeckImage($file);
            return ApiResponses::success('Estos son los resultados de la imagen : ', $response);
        } catch (\Exception $e) {
            return ApiResponses::error('error', $e->getMessage());
        }
    }


}