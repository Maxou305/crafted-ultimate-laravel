<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateCommentRequest;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Comment::all();
    }

    public function getById($id)
    {
        $comment = Comment::find($id);
        if ($comment === null) {
            return response()->json(['message' => 'Comment not found'], 404);
        }
        return $comment;
    }

    public function getByUserId($id)
    {
        $comment = Comment::where('user_id', $id)->get();
        if ($comment === null) {
            return response()->json(['message' => 'Comment not found'], 404);
        }
        if ($comment->count() === 1) {
            return $comment[0];
        }
        return $comment;
    }

    public function getByProductId($id)
    {
        $comment = Comment::where('product_id', $id)->get();
        if ($comment === null) {
            return response()->json(['message' => 'Comment not found'], 404);
        }
        if ($comment->count() === 1) {
            return $comment[0];
        }
        return $comment;
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
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
            'user_id' => 'required',
            'product_id' => 'required',
        ]);
        $comment = Comment::create($request->all());
        $comment->save();
        return response()->json($comment, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $comment = Comment::find($id);
        if ($comment === null) {
            return response()->json(['message' => 'Comment not found'], 404);
        }
        $comment->update(['content' => $request->get('content')]);
        return response()->json($comment, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        $comment = Comment::find($id);
        if ($comment === null) {
            return response()->json(['message' => 'Comment not found'], 404);
        }
        $comment->delete();
        return response()->json(['message' => 'Comment deleted']);
    }
}
