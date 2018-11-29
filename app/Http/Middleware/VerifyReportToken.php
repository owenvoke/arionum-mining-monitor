<?php

namespace App\Http\Middleware;

use App\Exceptions\InvalidReportTokenException;
use Closure;

class VerifyReportToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     * @throws InvalidReportTokenException
     */
    public function handle($request, Closure $next)
    {
        if ($request->get('token')) {
            throw new InvalidReportTokenException('unauthorized');
        }

        return $next($request);
    }
}
