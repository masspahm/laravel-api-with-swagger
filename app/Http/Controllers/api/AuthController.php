<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\ResponseController;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

class AuthController extends ResponseController
{
    /**
     * @OA\Post(
     * path="/auth/login",
     * summary="Sign in",
     * description="Login by email, password",
     * operationId="authLogin",
     * tags={"Auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"email","password"},
     *       @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
     *       @OA\Property(property="password", type="string", format="password", example="PassWord12345"),     
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Login success",
     *    @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example="true"),
     *       @OA\Property(property="message", type="string", example="User login successfully."),
     *       @OA\Property(property="payload", type="object",      
     *              @OA\Property(property="token", type="string", example="Sanctum token"),
     *              @OA\Property(property="name", type="string", example="User Name"),
     *       ),
     *       )
     *     ),
     * @OA\Response(
     *    response=401,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example="false"),
     *       @OA\Property(property="message", type="string", example="Login failed"),
     *       @OA\Property(property="payload", type="object",      
     *              @OA\Property(property="error", type="string", example="Invalid credentials")
     *          ),
     *       )
     *     )
     *      )
     * ),
     */

    public function login(LoginRequest $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->plainTextToken;
            $success['name'] =  $user->name;

            return $this->responseSuccess($success, 'User login successfully.');
        } else {
            return $this->responseError('Login failed', ['error' => 'Invalid credentials'], 401);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return $this->responseSuccess(null, 'User logout');
        } catch (\Throwable $th) {
            return $this->responseError('Error', $th);
        }
    }
}
