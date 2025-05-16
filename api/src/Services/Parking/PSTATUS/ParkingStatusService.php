<?php
namespace App\Services\PSTATUS;
use App\Repository\ParkingStatusRepository;

class ParkingStatusService
{
    public function __construct(
        protected ParkingStatusRepository $repoStatus,
    ){}

}