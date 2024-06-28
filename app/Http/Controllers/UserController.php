<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Client\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    /**
     * Display all users.
     * @return JsonResponse : JSON response with the list of users
     */
    public function index(): JsonResponse
    {
        $response = Gate::inspect('viewAny', User::class);

        if ($response->allowed()) {
            $userList = User::all();
            return response()->json($userList, 201);
        } else {
            return response()->json(['message' => $response->message()], 403);
        }
    }

    /**
     * Display a user by id.
     * @param $id : The id of the user
     * @return JsonResponse : JSON response with the user
     */
    public function getById(string $id): JsonResponse
    {
        $user = User::find($id);
        if ($user === null) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $response = Gate::inspect('view', $user);

        if ($response->allowed()) {
            return response()->json($user, 201);
        } else {
            return response()->json(['message' => $response->message()], 403);
        }
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

        $response = Gate::inspect('update', $user);

        if ($response->allowed()) {
            $user->update($request->all());

            return response()->json([
                'message' => 'User updated',
                'user' => $user
            ], 201);
        }
        else {
            return response()->json(['message' => $response->message()], 403);
        }
    }

    /**
     * Remove the specified user from storage.
     * @param DestroyUserRequest $request : The request containing the user data
     * @param $id : The id of the user
     * @return JsonResponse : JSON response with the user deleted
     */
    public function destroy(DestroyUserRequest $request, $id): JsonResponse
    {
        $user = User::find($id);

        $response = Gate::inspect('delete', $user);

        if ($response->allowed()) {
            $user->delete();
            return response()->json(['message' => 'User deleted'], 201);
        }
        else {
            return response()->json(['message' => $response->message()], 403);
        }
    }
}
