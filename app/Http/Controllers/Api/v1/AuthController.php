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
        $result = $this->authService->sign_in($request->validated(), $request);

        return response()->json($result, Response::HTTP_OK);
    }

    public function signout(Request $request) : JSONResponse
    {
        $this->authService->sign_out($request->user(), $request->session_id);

        return response()->json(true, Response::HTTP_OK);
    }
}
