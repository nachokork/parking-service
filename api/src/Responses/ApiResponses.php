<?php

namespace App\Responses;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiResponses
{
    static public function success(
        ?string $message = null,
        mixed $data = []
    ): JsonResponse
    {
        return new JsonResponse([
            'status' => StatusType::SUCCESS->value,
            'message' => $message,
            'data' => $data
        ], Response::HTTP_OK);
    }

    static public function object(mixed $data): JsonResponse
    {
        return new JsonResponse($data ?? null, Response::HTTP_OK);
    }

    static public function error(
        ?string $message = null,
        mixed $data = [],
        int $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR
    ): JsonResponse
    {
        $statusCode = ($statusCode >= 100 && $statusCode <= 599) ? $statusCode : 500;

        return new JsonResponse([
            'status' => StatusType::ERROR->value,
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    static public function badRequest(
        ?string $message = null,
        mixed $data = [],
        int $statusCode = Response::HTTP_BAD_REQUEST
    ): JsonResponse
    {
        return new JsonResponse([
            'status' => StatusType::BADRQ->value,
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    static public function conflict(
        ?string $message = null,
        mixed $data = [],
        int $statusCode = Response::HTTP_CONFLICT
    ): JsonResponse
    {
        return new JsonResponse([
            'status' => StatusType::CONFLICT->value,
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }
}