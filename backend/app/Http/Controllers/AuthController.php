<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
     /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * @OA\Post(
     *     tags={"Auth"},
     *     operationId="Login",
     *     description="Get JWT user token.",
     *     path="/api/auth/login",
     *     @OA\RequestBody(
     *      description="User credentials",
     *      required=true,
     *      @OA\JsonContent(ref="#/components/schemas/loginDto")
     *     ),
     *     @OA\Response(
     *      response="401",
     *      description="Unauthorized"
     *     ),
     *     @OA\Response(
     *      response="200",
     *      description="Ok",
     *      @OA\JsonContent(ref="#/components/schemas/tokenDto")
     *     ),
     * )
     */
    public function login(LoginRequest $request)
    {
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'is_activated' => true
        ];

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * @OA\Post(
     *     tags={"Auth"},
     *     operationId="Register",
     *     description="Register a user user.",
     *     path="/api/auth/register",
     *     @OA\RequestBody(
     *      description="User data",
     *      required=true,
     *      @OA\JsonContent(ref="#/components/schemas/registerDto")
     *     ),
     *     @OA\Response(
     *      response="400",
     *      description="Bad request"
     *     ),
     *     @OA\Response(
     *      response="200",
     *      description="Ok",
     *      @OA\JsonContent(ref="#/components/schemas/user")
     *     ),
     * )
     */
    public function register(RegisterRequest $request)
    {
        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ];

        if (User::where('email', $data['email'])->count()) {
            return response()->json(['message' => 'E-mail aready been taken.'], 400);
        }

        $user = User::create($data);

        if (! $user) {
            return response()->json(['message' => 'Bad request'], 400);
        }

        return response()->json($user);
    }

    /**
     * @OA\Post(
     *     tags={"Auth"},
     *     operationId="Me",
     *     description="Get authenticated user data.",
     *     path="/api/auth/me",
     *     @OA\Response(
     *      response="401",
     *      description="Unauthorized"
     *     ),
     *     @OA\Response(
     *      response="200",
     *      description="Ok",
     *      @OA\JsonContent(ref="#/components/schemas/user")
     *     ),
     * )
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * @OA\Post(
     *     tags={"Auth"},
     *     operationId="Logout",
     *     description="Destroy current user session.",
     *     path="/api/auth/logout",
     *     @OA\Response(
     *      response="200",
     *      description="Ok",
     *      @OA\JsonContent(ref="#/components/schemas/errorDto")
     *     ),
     * )
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * @OA\Post(
     *     tags={"Auth"},
     *     operationId="Refresh",
     *     description="Refresh authenticated session.",
     *     path="/api/auth/refresh",
     *     @OA\Response(
     *      response="200",
     *      description="Ok",
     *      @OA\JsonContent(ref="#/components/schemas/tokenDto")
     *     ),
     * )
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->getUser(),
        ]);
    }
}
