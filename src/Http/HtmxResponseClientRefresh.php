<?php

declare(strict_types=1);

namespace HTMx\Http;

use Concrete\Core\Http\Response;

class HtmxResponseClientRefresh extends Response
{
    public function __construct()
    {
        $headers = [
            'HX-Refresh' => 'true'
        ];

        parent::__construct('', static::HTTP_OK, $headers);
    }
}