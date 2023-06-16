<?php

namespace Davidjr82\PhpPDFGenerator\Concerns;

trait HasCallbacks
{
    protected array $callback_success = [];
    protected array $callback_error = [];

    protected function emitCallbacks(bool $result)
    {
        $callbacks = $result ? $this->callback_success : $this->callback_error;

        foreach ($callbacks as $callback) {
            if (\is_callable($callback)) {
                \call_user_func($callback);
            }
        }
    }
}
