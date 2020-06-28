<?php

namespace Davidjr82\PhpPDFGenerator\Contracts;

use Symfony\Component\Process\Process;

interface EngineInterface
{
    public function getProcess($tmp_dir, $tmp_filename): Process;
}
