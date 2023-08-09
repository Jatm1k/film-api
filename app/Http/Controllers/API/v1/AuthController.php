<?php

namespace App\Http\Controllers\API\v1;

use App\Contracts\API\v1\Auth\AuthContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Auth\LoginRequest;
use App\Http\Requests\API\v1\Auth\RegisterRequest;
use App\Http\Resources\API\v1\User\UserResource;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    private AuthContract $service;

    public function __construct(AuthContract $service)
    {
        $this->service = $service;
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        return response()->json(
            new UserResource(
                $this->service
                    ->register($request->validated())
            ),
            Response::HTTP_CREATED
        );
    }

    public function login(LoginRequest $request): JsonResponse
    {
        return response()->json(
            new UserResource(
                $this->service
                    ->login($request->validated())
            )
        );
    }

    public function logout()
    {
        $this->service->logout();
        return response()->noContent();
    }
}
