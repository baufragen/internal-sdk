<?php

namespace Baufragen\Sdk\Middleware;

use Closure;

class SdkRequestsOnly
{
    public function handle($request, Closure $next)
    {
        if (!$request->header('baufragen_sdk_apikey', null)) {
            abort(400, "No ApiKey");
        }
        if ($request->header('baufragen_sdk_apikey', null) != config('baufragensdk.apikey')) {
            abort(403, "Wrong ApiKey");
        }

        return $next($request);
    }
}
