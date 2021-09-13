<?php

namespace Davidjr82\PhpPDFGenerator\Contracts;

interface PDFGenerator
{
    public function setRenderedSource(string $source_text): self;
    public function setTestRenderedSource(): self;
    public function saveFile(string $destination_path, string $extension_type = '.pdf'): bool;
    public function setRunTimes(int $run_times): self;
    public function setEnv(array $env): self;
}
