<?php

namespace App\Service;

use Exception;
use Symfony\Component\Filesystem\Filesystem;

class CodeGenerator
{
    /**
     * @param Filesystem $filesystem
     * @param CodeCreator $codeCreator
     * @param string $codePrefix
     */
    public function __construct(
        public Filesystem $filesystem,
        public CodeCreator $codeCreator,
        public string $codePrefix)
    {
        $this->filesystem = $filesystem;
        $this->codePrefix = $codePrefix;
    }

    /**
     * @throws Exception
     */
    public function generate(): string
    {
        $code = $this->codeCreator->createCode($this->codePrefix);

        $this->filesystem->mkdir('codes');
        $this->filesystem->touch('codes/' . $code . '.txt');
        file_put_contents('codes/' . $code . '.txt', $code);

        return $code;
    }
}