<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display all users.
     * @return JsonResponse : JSON response with the list of users
     */
    public function index(): JsonResponse
    {
        $userList = User::all();
        return response()->json($userList, 201);
    }

    /**
     * Display a user by id.
     * @param $id : The id of the user
     * @return JsonResponse : JSON response with the user
     */
    public function getById($id): JsonResponse
    {
        $user = User::find($id);
        if ($user === null) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json($user, 201);
    }

    /**
     * Store a newly created user in storage.
     * @param StoreUserRequest $request : The request containing the user data
     * @return JsonResponse : JSON response with the user created
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $user = User::create(
            $request->all(),
            ['password' => bcrypt($request->password)]
        );
        $user->save();
        return response()->json($user, 201);
    }

    /**
     * Update the specified user in storage.
     * @param UpdateUserRequest $request : The request containing the user data
     * @param $id : The id of the user
     * @return JsonResponse : JSON response with the user updated
     */
    public function update(UpdateUserRequest $request, $id): JsonResponse
    {
        $user = User::find($id);
        $user->update($request->all());
        return response()->json(['message' => 'User updated'], 201);
    }

    /**
     * Remove the specified user from storage.
     * @param DestroyUserRequest $request : The request containing the user data
     * @param $id : The id of the user
     * @return JsonResponse : JSON response with the user deleted
     */
    public function destroy(DestroyUserRequest $request, $id): JsonResponse
    {
        $request->validated();
        $user = User::find($id);
        $user->delete();
        return response()->json(['message' => 'User deleted'], 201);
    }
}
