<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\{Request, Response, JSONResponse};
use App\Http\Requests\Auth\{SigninRequest, RequestOTPRequest, VerifyOTPRequest};
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

    public function request_otp(RequestOTPRequest $request) : JSONResponse
    {
        $result = $this->authService->request_otp($request->validated());

        return response()->json($result, Response::HTTP_OK);
    }

    public function verify_otp(VerifyOTPRequest $request) : JSONResponse
    {
        $result = $this->authService->verify_otp($request->validated());

        return response()->json($result, Response::HTTP_OK);
    }
}
