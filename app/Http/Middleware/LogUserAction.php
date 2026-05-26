<?php

namespace App\Http\Middleware;

use App\Models\LogAction;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogUserAction
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (auth()->check() && $request->isMethod('GET')) {
            LogAction::create([
                'utilisateur_id' => auth()->id(),
                'page_visitee'   => $request->path(),
            ]);
        }

        return $response;
    }
}
