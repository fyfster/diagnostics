<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;

class CheckPermission
{
    public function handle($request, Closure $next, $permissions)
    {
        if (!$request->user()->hasRole(Role::ADMIN)){
            return $next($request);
        }

        $permissionsArray = explode('|', $permissions);
        foreach($permissionsArray as $permission){
            if (!$request->user()->hasPermission($permission)){
                return redirect()->back();
            }
        }

        return $next($request);
    }
}
