<?php

namespace JeroenFrenken\Chat\Services;

class GeneratorService
{

    public function generateToken(): string
    {
        return bin2hex(random_bytes(64));
    }

}
