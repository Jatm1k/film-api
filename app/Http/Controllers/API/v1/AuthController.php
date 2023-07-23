<?php

namespace App\Http\Controllers\API\v1;

use App\Contracts\API\v1\Auth\AuthContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\v1\Auth\LoginRequest;
use App\Http\Requests\API\v1\Auth\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    private AuthContract $service;

    public function __construct(AuthContract $service)
    {
        $this->service = $service;
    }

    public function register(RegisterRequest $request)
    {
        return response()->json([
            'token' => $this->service->register($request->validated())
        ], Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request)
    {
        return response()->json([
            'token' => $this->service->login($request->validated())
        ]);
    }
}
