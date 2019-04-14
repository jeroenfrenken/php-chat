<?php

namespace JeroenFrenken\Chat\Response;

use JeroenFrenken\Chat\Core\Response\JsonResponse;
use JeroenFrenken\Chat\Core\Response\Response;

class ApiResponse
{

    public static function badRequest(string $field, string $message)
    {
        return new JsonResponse([
            [
                'field' => $field,
                'message' => $message
            ]
        ], Response::BAD_REQUEST);
    }

    public static function badRequestWithData($data)
    {
        return new JsonResponse($data, Response::BAD_REQUEST);
    }

    public static function notFound(string $field, string $message)
    {
        return new JsonResponse([
            [
                'field' => $field,
                'message' => $message
            ]
        ], Response::NOT_FOUND);
    }

    public static function serverError(string $field, string $message)
    {
        return new JsonResponse([
            [
                'field' => $field,
                'message' => $message
            ]
        ], Response::SERVER_ERROR);
    }

}
