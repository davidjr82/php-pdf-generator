<?php

namespace Davidjr82\PhpPDFGenerator\Engines;

use Davidjr82\PhpPDFGenerator\Contracts\EngineInterface;
use Davidjr82\PhpPDFGenerator\Exceptions\FileNotFoundException;
use Davidjr82\PhpPDFGenerator\Exceptions\UnsupportedOperatingSystemException;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class PDFLatexEngine implements EngineInterface
{
    private string $bin_path;

    public function __construct()
    {
        if (!\in_array(PHP_OS_FAMILY, ['Linux'])) {
            throw new UnsupportedOperatingSystemException();
        }

        $this->setBinPath();
    }

    private function setBinPath()
    {
        $process = new Process(['which', 'pdflatex']);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        if (empty(trim($process->getOutput()))) {
            throw new FileNotFoundException('pdflatex');
        }

        $this->bin_path = trim($process->getOutput());
    }

    public function getProcess($tmp_dir, $tmp_filename): Process
    {
        return new Process([$this->bin_path, '-output-directory', $tmp_dir, $tmp_filename]);
    }
}
