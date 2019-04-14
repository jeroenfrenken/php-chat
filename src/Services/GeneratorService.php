<?php

namespace JeroenFrenken\Chat\Services;

/**
 * Class GeneratorService
 * @package JeroenFrenken\Chat\Services
 */
class GeneratorService
{

    /**
     * Generates a random string for api tokens
     *
     * Length 128 characters
     *
     * @return string
     * @throws \Exception
     */
    public function generateToken(): string
    {
        return bin2hex(random_bytes(64));
    }

}
