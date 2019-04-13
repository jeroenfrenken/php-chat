<?php

namespace JeroenFrenken\Chat\Controller;

use JeroenFrenken\Chat\Core\Container\ContainerAwareTrait;

class BaseController
{

    use ContainerAwareTrait;

    public function handleJsonPostRequest(): array
    {
        $postContent = file_get_contents('php://input');

        $data = json_decode($postContent, true);
        if (json_last_error() !== JSON_ERROR_NONE) throw new \Exception("Json format exception");

        return $data;
    }

}
