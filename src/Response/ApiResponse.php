<?php

namespace JeroenFrenken\Chat\Response;

use JeroenFrenken\Chat\Core\Response\JsonResponse;
use JeroenFrenken\Chat\Core\Response\Response;

/**
 * Class ApiResponse
 * @package JeroenFrenken\Chat\Response
 */
class ApiResponse
{

    /**
     * Returns a bad request formatted as validator error messages
     *
     * @param string $field
     * @param string $message
     * @return JsonResponse
     */
    public static function badRequest(string $field, string $message)
    {
        return new JsonResponse([
            [
                'field' => $field,
                'message' => $message
            ]
        ], Response::BAD_REQUEST);
    }

    /**
     * Returns the data that is passed as a bad request
     *
     * @param $data
     * @return JsonResponse
     */
    public static function badRequestWithData($data)
    {
        return new JsonResponse($data, Response::BAD_REQUEST);
    }

    /**
     * Returns a not found formatted as validator error messages
     *
     * @param string $field
     * @param string $message
     * @return JsonResponse
     */
    public static function notFound(string $field, string $message)
    {
        return new JsonResponse([
            [
                'field' => $field,
                'message' => $message
            ]
        ], Response::NOT_FOUND);
    }

    /**
     * Returns a server error formatted as validator error messages
     *
     * @param string $field
     * @param string $message
     * @return JsonResponse
     */
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
