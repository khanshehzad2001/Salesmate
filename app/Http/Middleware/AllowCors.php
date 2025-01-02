<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerJourneyController;


class AllowCors
{
    public function handle($request, Closure $next)
    {
        return $next($request)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    }
}