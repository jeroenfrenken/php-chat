<?php

namespace JeroenFrenken\Chat\Core\Response;

/**
 * A response for json data.
 *
 * Sets the right headers and preforms a json_encode on the data
 *
 * Class JsonResponse
 * @package JeroenFrenken\Chat\Core\Response
 */
class JsonResponse extends Response
{

    public function __construct($data, int $code = parent::OK, array $headers = [])
    {
        parent::__construct(json_encode($data), $code, array_merge([
            'Content-type' => 'application/json'
        ], $headers));
    }

}
