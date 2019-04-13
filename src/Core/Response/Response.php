<?php

namespace JeroenFrenken\Chat\Core\Response;

class Response
{

    public const OK = 200;
    public const BAD_REQUEST = 400;
    public const NOT_FOUND = 404;
    public const METHOD_NOT_ALLOWED = 405;
    public const SERVER_ERROR = 500;

    protected $code;
    protected $headers;
    protected $return;

    public function __construct(string $return, int $code = self::OK, array $headers = [])
    {
        $this->return = $return;
        $this->headers = $headers;
        $this->code = $code;
    }

    private function setHeaders(array $headers)
    {
        foreach ($headers as $key => $value) {
            header("{$key}: $value");
        }
    }

    public function send()
    {
        http_response_code($this->code);
        $this->setHeaders($this->headers);
        echo $this->return;
    }

}
