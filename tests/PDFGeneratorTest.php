<?php

namespace Davidjr82\PhpPDFGenerator\Tests;

use Davidjr82\PhpPDFGenerator\Exceptions\PDFGeneratorException;
use Davidjr82\PhpPDFGenerator\PDFGenerator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Process\Exception\ProcessFailedException;

class PDFGeneratorTest extends TestCase
{
    public function testDefaultEngine()
    {
        $this->expectException(ProcessFailedException::class);
        $generator = new PDFGenerator();
    }

    public function testDefaultException()
    {
        $exception = new PDFGeneratorException('Exception message test');
        $this->assertEquals('Exception message test', $exception->getMessage());
    }
}
