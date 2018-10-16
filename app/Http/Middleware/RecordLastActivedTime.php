<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class RecordLastActivedTime
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            // 记录最后登录时间
            Auth::user()->recordLastActivedAt();
        }
        return $next($request);
    }
}
