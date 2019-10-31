<?php

namespace Baufragen\Sdk\Middleware;

use Closure;

class SdkRequestsOnly
{
    public function handle($request, Closure $next)
    {
        if ($request->header('x-baufragen_sdk_apikey', null) != config('baufragensdk.apikey')) {
            abort(403, "Wrong ApiKey");
        }

        return $next($request);
    }
}
