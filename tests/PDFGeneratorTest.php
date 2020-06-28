<?php

namespace Davidjr82\PhpPDFGenerator\Tests;

use PHPUnit\Framework\TestCase;
use Davidjr82\PhpPDFGenerator\PDFGenerator;
use Symfony\Component\Process\Exception\ProcessFailedException;

class PDFGeneratorTest extends TestCase
{
    public function test_default_engine()
    {
        $this->expectException(ProcessFailedException::class);
        $generator = new PDFGenerator();
    }
}
