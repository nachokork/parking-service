<?php
namespace App\Services\PSPACE;

use App\Repository\ParkingSpaceRepository;

class ParkingSpaceService
{
    public function __construct(
        protected ParkingSpaceRepository $repoSpace,
    ){}

}