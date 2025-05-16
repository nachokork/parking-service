<?php

namespace App\Services\Parking;

use App\Services\Parking\Responses\ParkingDetectionResponse;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Mime\Part\Multipart\FormDataPart;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Mime\Part\DataPart;

class ParkingService
{
    public function __construct(
        protected HttpClientInterface $httpClient,
        protected ParkingDetectionResponse $parkingResponse,
    ){}

    /**
     * @throws TransportExceptionInterface
     */

    public function ckeckImage(File $file)
    {
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

        if (!in_array($file->getMimeType(), $allowedMimeTypes)) {
            throw new \InvalidArgumentException('Solo se permiten archivos de imagen.');
        }

        $formData = new FormDataPart([
            'file' => new DataPart(fopen($file->getPathname(), 'r'), $file->getClientOriginalName(), $file->getMimeType())
        ]);

        $request = $this->httpClient->request('POST', 'http://parking_service:8100/detect', [
            'headers' => $formData->getPreparedHeaders()->toArray(),
            'body' => $formData->bodyToIterable(),
        ]);

        return $this->parkingResponse->parkingImageDetails(json_decode($request->getContent(), true));
    }
}