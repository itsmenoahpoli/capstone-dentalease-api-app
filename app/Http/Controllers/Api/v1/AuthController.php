<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\{Request, Response, JSONResponse};
use App\Http\Requests\Auth\{SigninRequest, RequestOTPRequest, VerifyOTPRequest};
use App\Services\AuthService;

/**
 * @OA\Info(
 *     title="DentalEase API",
 *     version="1.0.0",
 *     description="API for DentalEase application - managing dental services and user authentication",
 *     @OA\Contact(
 *         email="support@dentalease.com",
 *         name="DentalEase Team"
 *     )
 * )
 *
 * @OA\Server(
 *     url="http://localhost:8000/api/v1",
 *     description="Development server"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="BearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
class AuthController extends Controller
{
    public function __construct(
        private AuthService $authService
    ) {}

    /**
     * @OA\Post(
     *     path="/auth/signin",
     *     tags={"Authentication"},
     *     summary="User sign in",
     *     description="Authenticate user with email and password",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="password", type="string", minLength=8, example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful authentication",
     *         @OA\JsonContent(
     *             @OA\Property(property="user", type="object",
     *                 @OA\Property(property="email", type="string"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="role", type="string")
     *             ),
     *             @OA\Property(property="session", type="string"),
     *             @OA\Property(property="token", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid credentials"
     *     )
     * )
     */
    public function signin(SigninRequest $request) : JSONResponse
    {
        $result = $this->authService->sign_in($request->validated(), $request);

        return response()->json($result, Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/auth/signout",
     *     tags={"Authentication"},
     *     summary="User sign out",
     *     description="Sign out user and invalidate session",
     *     security={{"BearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"session_id"},
     *             @OA\Property(property="session_id", type="string", example="session_123456")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully signed out",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function signout(Request $request) : JSONResponse
    {
        $this->authService->sign_out($request->user(), $request->session_id);

        return response()->json(true, Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/auth/request-otp",
     *     tags={"Authentication"},
     *     summary="Request OTP",
     *     description="Request one-time password for email verification",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","type"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="type", type="string", enum={"signup","reset_password"}, example="signup")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OTP sent successfully"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )
     * )
     */
    public function request_otp(RequestOTPRequest $request) : JSONResponse
    {
        $result = $this->authService->request_otp($request->validated());

        return response()->json($result, Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/auth/verify-otp",
     *     tags={"Authentication"},
     *     summary="Verify OTP",
     *     description="Verify one-time password",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","otp"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="otp", type="string", minLength=6, maxLength=6, example="123456")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OTP verified successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid OTP"
     *     )
     * )
     */
    public function verify_otp(VerifyOTPRequest $request) : JSONResponse
    {
        $result = $this->authService->verify_otp($request->validated());

        return response()->json($result, Response::HTTP_OK);
    }
}
