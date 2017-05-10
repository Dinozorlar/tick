<?php
namespace Tick\Service;

class RandomGenerator
{
    public function generate($length = 10)
    {
        return substr(
            bin2hex(random_bytes($length)),
            0,
            $length
        );
    }
}