<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Http\Middleware\TrustProxies as Middleware;

class TrustProxies extends Middleware
{
    /**
     * Trust all proxies (like Ngrok)
     */
    protected $proxies = '*';

    /**
     * Trust HTTPS and forwarded headers
     */
    protected $headers = Request::HEADER_X_FORWARDED_ALL;
}
