<?php

namespace Davidjr82\PhpPDFGenerator;

use Davidjr82\PhpPDFGenerator\Concerns\HasDebug;
use Davidjr82\PhpPDFGenerator\Concerns\HasCallbacks;
use Davidjr82\PhpPDFGenerator\Concerns\HasResponses;
use Davidjr82\PhpPDFGenerator\Engines\XeLatexEngine;
use Davidjr82\PhpPDFGenerator\Contracts\EngineInterface;
use Davidjr82\PhpPDFGenerator\Exceptions\PDFGeneratorException;

class PDFGenerator
{
    use HasDebug;
    use HasCallbacks;
    use HasResponses;

    private EngineInterface $engine;
    private ?string $rendered_source = null;
    private string $tmp_source_filename;

    // run twice to generate index pages
    private int $run_times = 2;

    public function __construct(?string $engine_class = null)
    {
        $engine_class ??= XeLatexEngine::class;
        $this->engine = new $engine_class();
    }

    public function setRenderedSource(string $source_text): self
    {
        $this->rendered_source = $source_text;

        return $this;
    }

    public function setTestRenderedSource(): self
    {
        $demo_source_text = file_get_contents(__DIR__ . '/Stubs/example.tex');

        return $this->setRenderedSource($demo_source_text);
    }

    public function saveFile(string $destination_path): bool
    {
        $generated_file_path = $this->generate();

        $file_has_been_moved = rename($generated_file_path, $destination_path);

        $this->emitCallbacks($file_has_been_moved);

        return $file_has_been_moved;
    }

    public function setRunTImes(int $run_times): self
    {
        $this->run_times = max(1, $run_times);

        return $this;
    }

    private function generate(): string
    {
        if (null === $this->rendered_source) {
            throw new PDFGeneratorException('The source file content (tex) must be provided with ->setRenderedSource($text) method');
        }

        $tmpfresource = tmpfile();

        if (!$tmpfresource) {
            throw new PDFGeneratorException('Temp file can not be created');
        }

        $this->tmp_source_filename = stream_get_meta_data($tmpfresource)['uri'];

        if (!is_writable($this->tmp_source_filename)) {
            throw new PDFGeneratorException("File $this->tmp_source_filename is not writable");
        }

        file_put_contents($this->tmp_source_filename, $this->rendered_source);

        $process = $this->engine->getProcess(\dirname($this->tmp_source_filename), $this->tmp_source_filename);

        foreach(range(1, $this->run_times) as $run_iteration) {
            $process->run();
        }

        if (!$process->isSuccessful()) {
            return $this->parseError($process);
        }

        register_shutdown_function(function () {
            $this->cleanup();
        });

        return $this->tmp_source_filename;
    }

    private function parseError($process)
    {
        $logfile = $this->tmp_source_filename . '.log';

        if (!file_exists($logfile)) {
            throw new PDFGeneratorException($process->getOutput());
        }

        if($this->debug) {
            return $this->showLogInBrowser($logfile);
        }

        $log_contents = file_get_contents($logfile);
        $this->cleanup();
        throw new PDFGeneratorException("Error. To see logfile directly in the browser use ->setDebug(true) method. Logfile contents: " . $log_contents);
    }

    private function cleanup(): self
    {
        if($this->debug) {
            return $this;
        }

        if(!isset($this->tmp_source_filename) || empty($this->tmp_source_filename)) {
            return $this;
        }

        return $this
                ->deleteFile($this->tmp_source_filename)
                ->deleteFile($this->tmp_source_filename . '.pdf')
                ->deleteFile($this->tmp_source_filename . '.out')
                ->deleteFile($this->tmp_source_filename . '.aux')
                ->deleteFile($this->tmp_source_filename . '.log');
    }

    private function deleteFile($path): self
    {
        if (file_exists($path)) {
            @unlink($path);
        }

        return $this;
    }
}
