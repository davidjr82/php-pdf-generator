<?php

namespace Davidjr82\PhpPDFGenerator\Tests;

use PHPUnit\Framework\TestCase;
use Davidjr82\PhpPDFGenerator\PDFGenerator;
use Davidjr82\PhpPDFGenerator\Exceptions\PDFGeneratorException;
use Symfony\Component\Process\Exception\ProcessFailedException;

class PDFGeneratorTest extends TestCase
{
    public function test_default_engine()
    {
        $this->expectException(ProcessFailedException::class);
        $generator = new PDFGenerator();
    }

    public function test_default_exception()
    {
        $exception = new PDFGeneratorException("Exception message");
        $this->assertEquals("Exception message", $exception->getMessage());
    }
}
