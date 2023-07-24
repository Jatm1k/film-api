<?php

namespace App\Http\Middleware;

use App\Enums\API\v1\Role;
use Closure;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if ($request->user()->role_id !== $this->roleId($role)) {
            throw new HttpResponseException(
                response()->json([
                    'message' => __('auth.forbidden')
                ], Response::HTTP_FORBIDDEN)
            );
        }
        return $next($request);
    }

    private function roleId(string $role): int
    {
        return Role::tryFrom($role)->getId();
    }
}
