<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\AppUtilities;
class checkIfOwnerOrAdmin
{
    protected $appUtilities;
    public function __construct(AppUtilities $appUtilities)
    {
        $this->appUtilities = $appUtilities;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $homeData = $this->appUtilities->findHomeData(auth()->user());
        if ($homeData){
            if($homeData->role == 'admin' || $homeData->role == 'owner'){
                return $next($request);
            }
        }
        return redirect('/');
    }
}
