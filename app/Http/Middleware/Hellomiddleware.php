<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Hellomiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Print HELLO before the controller
        echo "SIMPLE-HELLO<br>";

        return $next($request);
    }
}