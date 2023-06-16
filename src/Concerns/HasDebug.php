<?php

namespace Davidjr82\PhpPDFGenerator\Concerns;

use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

trait HasDebug
{
    protected bool $debug = false;

    public function setDebug(bool $debug): self
    {
        $this->debug = $debug;

        return $this;
    }

    protected function showLogInBrowser($logfile): BinaryFileResponse
    {
        $response = new BinaryFileResponse($logfile, 200, ['Content-Type' => 'text/plain'], true, ResponseHeaderBag::DISPOSITION_INLINE);
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_INLINE, basename($logfile));

        return $response->send();
    }
}
