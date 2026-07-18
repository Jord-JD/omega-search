<?php

namespace JordJD\OmegaSearch;

use JordJD\uxdm\Interfaces\TransformerInterface;
use JordJD\uxdm\Objects\DataRow;

class CallbackTransformer implements TransformerInterface
{
    private $callback;

    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    public function transform(DataRow &$dataRow): void
    {
        call_user_func($this->callback, $dataRow);
    }
}
