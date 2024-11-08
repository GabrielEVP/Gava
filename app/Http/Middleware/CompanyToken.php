<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CompanyToken
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (!$user || !$user->company_id) {
            return response()->json(['error' => 'You do not have an associated company'], 403);
        }

        if ($request->route('id') != $user->company_id) {
            return response()->json(['error' => 'Unauthorized access to this company'], 403);
        }

        return $next($request);
    }
}
