<?php

declare(strict_types=1);

namespace HTMx\Http;

use Concrete\Core\Http\Response;

class HtmxResponseClientRedirect extends Response
{
    public function __construct(string $to)
    {
        $headers = [
            'HX-Redirect' => $to
        ];

        parent::__construct('', 200, $headers);
    }
}