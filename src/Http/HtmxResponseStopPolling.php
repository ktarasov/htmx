<?php

declare(strict_types=1);

namespace HTMx\Http;

use Concrete\Core\Http\Response;

class HtmxResponseStopPolling extends Response
{
    public const HTMX_STOP_POLLING = 286;

    public function __construct($content = '', array $headers = [])
    {
        parent::__construct($content, static::HTMX_STOP_POLLING, $headers);
    }
}