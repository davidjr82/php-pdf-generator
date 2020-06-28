<?php

namespace Davidjr82\PhpPDFGenerator\Concerns;

use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

trait HasResponses
{
    protected function response($filetype, $disposition_type, $filename = null): BinaryFileResponse
    {
        if(!isset($this->tmp_source_filename)) {
            $this->generate();
        }

        $file_path =  $this->getFilePath($filetype, $this->tmp_source_filename);
        $filename ??= basename($file_path);

        $response = new BinaryFileResponse($file_path, 200, ['Content-Type' => $this->getContentType($filetype)], true);

        return $response->setContentDisposition($disposition_type, $filename);
    }

    private function getFilePath($filetype, $file_path): string
    {
        if($filetype === 'tex') {
            return $file_path;
        }

        if($filetype === 'pdf') {
            return $file_path . '.pdf';
        }

        if($filetype === 'log') {
            return $file_path . '.log';
        }

        if($filetype === 'aux') {
            return $file_path . '.aux';
        }

        throw new Exception("Filetype not supported", 1);
    }

    private function getContentType($filetype): string
    {
        if($filetype === 'pdf') {
            return 'application/pdf';
        }

        return 'text/plain';
    }

    public function download($filename = null, $filetype = 'pdf'): BinaryFileResponse
    {
        return $this->response($filetype, ResponseHeaderBag::DISPOSITION_ATTACHMENT, $filename);
    }

    public function showInBrowser($filename = null, $filetype = 'pdf'): BinaryFileResponse
    {
        return $this->response($filetype, ResponseHeaderBag::DISPOSITION_INLINE, $filename);
    }
}
