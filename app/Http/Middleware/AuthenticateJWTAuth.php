<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class AuthenticateJWTAuth extends BaseMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            JWTAuth::parseToken()->authenticate();

        } catch (\Exception $ex) {
            if($ex instanceof TokenInvalidException) {
                return $this->jsonResponse('Token de acesso inválido');

            } else if($ex instanceof TokenExpiredException) {
                return $this->jsonResponse('Token de acesso espirado');

            } else {
                return $this->jsonResponse('Token de acesso não informado');
            }
        }
        return $next($request);
    }

    private function jsonResponse(string $message) : JsonResponse
    {
        return response()->json([
            'status'  => 'error',
            'data'    => (object)['message' => [$message]]
        ], Response::HTTP_BAD_REQUEST);
    }
}
