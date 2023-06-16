<?php

namespace Davidjr82\PhpPDFGenerator\Exceptions;

class FileNotFoundException extends \Exception
{
    public function __construct($file)
    {
        parent::__construct('File ' . $file . ' not found');
    }
}
