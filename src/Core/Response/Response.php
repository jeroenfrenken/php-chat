<?php
namespace JeroenFrenken\Chat\Core\Response;

class Response
{

    public const OK = 200;
    public const BAD_REQUEST = 400;
    public const NOT_FOUND = 404;
    public const METHOD_NOT_ALLOWED = 405;

    public function __construct(string $return, int $code = self::OK, array $headers = [])
    {
        http_response_code($code);
        $this->setHeaders($headers);
        echo $return;
    }

    private function setHeaders(array $headers)
    {
        foreach ($headers as $key => $value) {
            header("{$key}: $value");
        }
    }

}
