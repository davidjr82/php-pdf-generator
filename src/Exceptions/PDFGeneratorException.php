<?php

namespace Davidjr82\PhpPDFGenerator\Exceptions;

class PDFGeneratorException extends \Exception
{
    public function __construct(string $message, bool $add_install_suggestion = false)
    {
        if ($add_install_suggestion) {
            $message .= \PHP_EOL . 'Suggestion: Install full latex requirements: apt-get update && apt-get install texlive-full poppler-utils';
        }

        parent::__construct($message);
    }
}
