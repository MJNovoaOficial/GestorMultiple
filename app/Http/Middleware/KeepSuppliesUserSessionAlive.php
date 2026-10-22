<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class KeepSuppliesUserSessionAlive
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (
            $request->user()
            && (int) $request->user()->id === 11
            && $request->hasSession()
        ) {
            $request->session()->put(
                'supplies_terminal_last_activity',
                now()->timestamp
            );
        }

        return $response;
    }
}

