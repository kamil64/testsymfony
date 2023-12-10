<?php

namespace App\Service;

use Exception;

class CodeCreator
{
    /**
     * @throws Exception
     */
    public function createCode(string $prefix): string
    {
        return $prefix . '-' . random_int(1000, 9000);
    }
}