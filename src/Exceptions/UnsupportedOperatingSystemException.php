<?php

namespace Davidjr82\PhpPDFGenerator\Exceptions;

class UnsupportedOperatingSystemException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Unsupported Operating System');
    }
}
