<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\{Request, Response, JSONResponse};
use App\Http\Requests\Auth\SigninRequest;
use App\Services\AuthService;

class AuthController extends Controller
{
    public function __construct(
        private AuthService $authService
    ) {}

    public function signin(SigninRequest $request) : JSONResponse
    {
        $result = $this->authService->signin($request->validated());

        return response()->json($result, Response::HTTP_OK);
    }
}
