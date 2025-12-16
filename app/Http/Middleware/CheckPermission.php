<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    public function handle($request, Closure $next, $permission)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Unauthorized');
        }

        /**
         * =================================================
         *  FULL ACCESS CONDITIONS (BYPASS PERMISSION CHECK)
         * =================================================
         * 1. User type is admin
         * 2. User does NOT have a role_group_id (null)
         */
        if ($user->type === 'admin' && is_null($user->role_group_id)) {
            return $next($request);
        }

        /**
         * ================
         *  SUBADMIN CHECK
         * ================
         */

        if (!$user->roleGroup) {
            abort(403, 'Role group missing.');
        }

        $permissions = $user->roleGroup->permissions ?? [];

        if (!is_array($permissions)) {
            abort(403, 'Invalid Permission Format.');
        }

        // Check in JSON
        if (!isset($permissions[$permission]) || $permissions[$permission] !== "yes") {
            abort(403, "Permission Denied: {$permission}");
        }

        return $next($request);
    }
}
