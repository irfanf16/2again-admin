<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle(Request $request, Closure $next)
    {

        $route = app()->router->getCurrentRoute();

        if($route->uri == 'api/appStoreServerNotification'){
            return $next($request);
        }
        if($route->uri == 'api/notifications/android'){
            return $next($request);
        }
        if($route->uri == 'api/notifications/ios'){
            return $next($request);
        }
        if($route->uri == 'api/cron'){
            return $next($request);
        }



        $key = $request->header('KEY');
        if($key == '')
        {
            return response()->json(['ResponseCode' => 0, 'ResponseMessage' => null, 'error' => ['App key not found']]);
        }
        if($key != 'YW1Gb1lXNTZZV2xpTG1GemJHRnRMbTFsYUdGeVFHZHRZV2xzTG1OdmJUb3lZV2RoYVc0PQ=='){
            return response()->json(['ResponseCode' => 0, 'ResponseMessage' => null, 'error' => ['Invalid App key']]);
        }

        return $next($request);
    }
}
