<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class SetLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->locale) {
            App::setLocale($request->locale);
        } else {
            App::setLocale(env('LOCALE ', 'cn'));
        }
        return $next($request);
    }
}
