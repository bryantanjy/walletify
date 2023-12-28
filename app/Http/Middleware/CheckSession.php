<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $activeGroupId = session('active_group_id');

        if ($activeGroupId) {
            // It's a group session, you can set a flag or do additional actions here
            session(['app.user_session_type' => 'group']);
        } else {
            // It's a personal session, you can set a flag or do additional actions here
            session(['app.user_session_type' => 'personal']);
        }
        
        return $next($request);
    }
}
