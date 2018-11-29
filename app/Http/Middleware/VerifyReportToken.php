<?php

namespace App\Http\Middleware;

use App\Exceptions\InvalidReportTokenException;
use App\User;
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
        if (!User::query()->where('report_token', $request->input('token'))->first()) {
            throw new InvalidReportTokenException('unauthorized');
        }

        return $next($request);
    }
}
