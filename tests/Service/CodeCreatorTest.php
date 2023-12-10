<?php

namespace App\Tests\Service;

use App\Service\CodeCreator;
use Exception;
use PHPUnit\Framework\TestCase;

class CodeCreatorTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testCreateCode(): void
    {
        $codeCreator = new CodeCreator();
        $code = $codeCreator->createCode('test');

        $this->assertIsString($code);
        $this->assertEquals(9, strlen($code));
    }
}
