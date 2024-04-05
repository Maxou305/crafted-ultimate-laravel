<?php

namespace App\Http\Controllers;

use App\Models\User;
use Faker\Core\Uuid;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Display a user by id.
     */
    public function getById($id) : JsonResponse
    {
        $user = User::find($id);
        if ($user === null) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json($user);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : JsonResponse
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $user = User::create($request->all());
        $user->save();
        return response()->json($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) : JsonResponse
    {
        $user = User::find($id);
        if ($user === null) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $user->update($request->all());
        return response()->json(['message' => 'User updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) : JsonResponse
    {
        $user = User::find($id);
        if ($user === null) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $user->delete();
        return response()->json(['message' => 'User deleted']);
    }
}
