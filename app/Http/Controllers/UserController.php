<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display all users.
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $userList = User::all();
        return response()->json($userList, 201);
    }

    /**
     * Display a user by id.
     * @param $id
     * @return JsonResponse
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
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $user = User::create($request->all());
        $user->save();
        return response()->json($user, 201);
    }

    /**
     * Update the specified user in storage.
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $user = User::find($id);
        if ($user === null) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $user->update($request->all());
        return response()->json(['message' => 'User updated'], 201);
    }

    /**
     * Remove the specified user from storage.
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $user = User::find($id);
        if ($user === null) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $user->delete();
        return response()->json(['message' => 'User deleted'], 201);
    }
}
