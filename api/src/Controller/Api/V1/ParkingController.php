<?php

namespace App\Controller\Api\V1;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\Parking\ParkingHandler;
use \Symfony\Component\HttpFoundation\JsonResponse;

class ParkingController extends AbstractController
{
    public function __construct(
        protected ParkingHandler $handler,
    ){}

    #[Route('/spaces', name: 'spaces', methods: ['GET'])]
    public function getSpaces(): JsonResponse
    {
        return $this->handler->getSpaces();
    }

    #[Route('/status', name: 'status', methods: ['GET'])]
    public function getStatus(): JsonResponse
    {
        return $this->handler->getStatus();
    }

    #[Route('/update', name: 'update', methods: ['POST'])]
    public function updateStatus(): JsonResponse
    {
        return $this->handler->updateStatus();
    }

    #[Route('/zones', name: 'zones', methods: ['GET'])]
    public function getZones(): JsonResponse
    {
        return $this->handler->getZones();
    }

    #[Route('/parking/image', name: 'parkingImage', methods: ['POST'])]
    public function postImage(Request $request): JsonResponse
    {
        return $this->handler->checkSpacesByZone($request->files->get('file'));
    }



}