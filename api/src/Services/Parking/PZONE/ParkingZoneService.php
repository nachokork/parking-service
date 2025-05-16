<?php
namespace App\Services\Parking\PZONE;
use App\Repository\ParkingZoneRepository;
use PhpParser\Node\Scalar\MagicConst\File;

class ParkingZoneService
{
    protected function __construct(
        protected ParkingZoneRepository $repoZone,
    ){}

    public function checkSpacesByZone(File $file)
    {

    }
}