<?php

namespace JeroenFrenken\Chat\Core\Response;

class JsonResponse extends Response
{

    public function __construct(array $data, int $code = parent::OK, array $headers = [])
    {
        parent::__construct(json_encode($data), $code, array_merge([
            'Content-type' => 'application/json'
        ], $headers));
    }

}
