<?php

namespace App\Http\Middleware;

use App\Http\Controllers\api\cart\apiResponse;
use App\Models\cart;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ownCart
{
    use apiResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check())
        {
            if (cart::where('user_id', Auth::user()->id)->first() || Auth::user()->role == 'admin')
            {
              return $next($request);
            }
            else if (cart::where('user_id', Auth::user()->id)->first() == 0){
                return $next($request);
            }
        }

        return response()->json(['message' => 'UnAuthorized Acess'],401);
    }
}
