<?php

namespace App\Tests\Service;

use App\Service\CodeCreator;
use App\Service\CodeGenerator;
use Exception;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Filesystem\Filesystem;

class CodeGeneratorTest extends KernelTestCase
{
    /**
     * @throws Exception
     */
    public function testGenerateCode(): void
    {
        self::bootKernel();

        $container = static::getContainer();

        $fileSystem = $container->get(Filesystem::class);
        $codeCreator = $container->get(CodeCreator::class);

        $codeGenerator = new CodeGenerator(
            $fileSystem,
            $codeCreator,
            'test'
        );

        $code = $codeGenerator->generate();
        $this->assertIsString($code);
        $this->assertMatchesRegularExpression('/test-[0-9]{4}/', $code);
    }
}
