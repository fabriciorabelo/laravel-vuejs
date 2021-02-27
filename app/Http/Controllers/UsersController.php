<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\PaginatedUsers;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @OA\Get(
     *     tags={"Users"},
     *     operationId="Get users",
     *     description="Return a paginated list of users.",
     *     path="/api/users",
     *     @OA\Response(
     *      response="400",
     *      description="Bad request"
     *     ),
     *     @OA\Response(
     *      response="401",
     *      description="Unauthorized"
     *     ),
     *     @OA\Response(
     *      response="200",
     *      description="Ok",
     *      @OA\JsonContent(
     *          @OA\Items(ref="#/components/schemas/user"))
     *     ),
     * )
     */
    public function index(Request $request)
    {
        // if (!auth()->user()->hasPermissionTo('users.list')) {
        //     return response()->json(['message' => 'Unauthorized'], 401);
        // }

        $users = User::all();
        return response()->json($users);
    }

    /**
     * @OA\Get(
     *     tags={"Users"},
     *     operationId="Get user",
     *     description="Get user data by id.",
     *     path="/api/users/{id}",
     *     @OA\Parameter(
     *       name="id",
     *       in="path",
     *       description="ID of user that needs to be fetched",
     *       required=true,
     *       @OA\Schema(
     *         type="integer",
     *       )
     *     ),
     *     @OA\Response(
     *      response="401",
     *      description="Unauthorized"
     *     ),
     *     @OA\Response(
     *      response="404",
     *      description="User not found"
     *     ),
     *     @OA\Response(
     *      response="422",
     *      description="Unprocessable Entity"
     *     ),
     *     @OA\Response(
     *      response="200",
     *      description="Ok",
     *      @OA\JsonContent(ref="#/components/schemas/user")
     *     ),
     * )
     */
    public function show(int $id)
    {
        // if (!auth()->user()->hasPermissionTo('users.view')) {
        //     return response()->json(['message' => 'Unauthorized'], 401);
        // }

        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' =>'User not found.'], 404);
        }

        return response()->json($user);
    }

    /**
     * @OA\Post(
     *     tags={"Users"},
     *     operationId="Create user",
     *     description="Register a new user.",
     *     path="/api/users",
     *     @OA\RequestBody(
     *      description="User data",
     *      required=true,
     *      @OA\JsonContent(ref="#/components/schemas/userDto")
     *     ),
     *     @OA\Response(
     *      response="400",
     *      description="Bad request"
     *     ),
     *     @OA\Response(
     *      response="401",
     *      description="Unauthorized"
     *     ),
     *     @OA\Response(
     *      response="422",
     *      description="Unprocessable Entity"
     *     ),
     *     @OA\Response(
     *      response="200",
     *      description="Ok",
     *      @OA\JsonContent(ref="#/components/schemas/user")
     *     ),
     * )
     */
    public function store(CreateUserRequest $request)
    {
        // if (!auth()->user()->hasPermissionTo('users.create')) {
        //     return response()->json(['message' => 'Unauthorized'], 401);
        // }

        $data = $request->only(['name', 'email', 'password']);
        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);
        if (!$user) {
            return response()->json(['Error while create user.'], 400);
        }

        return response()->json($user, 201);
    }

    /**
     * @OA\Put(
     *     tags={"Users"},
     *     operationId="Update user",
     *     description="Update an user.",
     *     path="/api/users/{id}",
     *     @OA\RequestBody(
     *      description="User data",
     *      required=true,
     *      @OA\JsonContent(ref="#/components/schemas/userDto")
     *     ),
     *     @OA\Response(
     *      response="400",
     *      description="Bad request"
     *     ),
     *     @OA\Response(
     *      response="401",
     *      description="Unauthorized"
     *     ),
     *     @OA\Response(
     *      response="422",
     *      description="Unprocessable Entity"
     *     ),
     *     @OA\Response(
     *      response="200",
     *      description="Ok",
     *      @OA\JsonContent(ref="#/components/schemas/user")
     *     ),
     * )
     */
    public function update(UpdateUserRequest $request, int $id)
    {
        // if (!auth()->user()->hasPermissionTo('users.update')) {
        //     return response()->json(['message' => 'Unauthorized'], 401);
        // }

        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' =>'User not found.'], 404);
        }

        $data = $request->only(['name', 'email', 'password']);
        $data['password'] = $request->input('password') || null;

        if (!$data['password']) {
            unset($data['password']);
        } else {
            $data['password'] = bcrypt($data['password']);
        }

        $user->update($data);

        return response()->json($user);
    }

    /**
     * @OA\Delete(
     *     tags={"Users"},
     *     operationId="Delete user",
     *     description="Delete user data by id.",
     *     path="/api/users/{id}",
     *     @OA\Parameter(
     *       name="id",
     *       in="path",
     *       description="ID of user that needs to be fetched",
     *       required=true,
     *       @OA\Schema(
     *         type="integer",
     *       )
     *     ),
     *     @OA\Response(
     *      response="404",
     *      description="User not found"
     *     ),
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
    public function destroy(int $id)
    {
        // if (!auth()->user()->hasPermissionTo('users.delete')) {
        //     return response()->json(['message' => 'Unauthorized'], 401);
        // }

        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' =>'User not found.'], 404);
        }

        if ($user->id === auth()->user()->id) {
            return response()->json(['message' =>'You can not delete youself.'], 400);
        }

        if ($user->delete()) {
            return response()->json(['message' =>'User deleted.']);
        }

        return response()->json(['message' =>'Error while deleting.']);
    }
}
