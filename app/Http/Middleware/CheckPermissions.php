<?php

namespace App\Http\Middleware;

use App\Libs\ValueUtil;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     * @param Request $request
     */
    public function handle(Request $request, Closure $next): Response {
        $positions = collect([
            ValueUtil::constToValue('user.user_flg.DEPARTMENT_LEADER'),
            ValueUtil::constToValue('user.user_flg.TEAM_LEADER'),
            ValueUtil::constToValue('user.user_flg.TEAM_MEMBER'),
        ]);

        if (Auth::user()->position_id == ValueUtil::constToValue('user.user_flg.DIRECTOR')) {
            return $next($request);
        }

        if ($positions->contains(Auth::user()->position_id)) {
            if (isset($request->id)) {
                if (Auth::id() != $request->id) {
                    return redirect()->route('logout');
                }
            }
        }

        return $next($request);
    }
}
