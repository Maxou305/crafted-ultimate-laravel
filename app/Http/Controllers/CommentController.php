<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display all the comments.
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $commentList = Comment::all();
        return response()->json($commentList, 201);
    }

    /**
     * Display a comment by id.
     * @param $id
     * @return JsonResponse
     */
    public function getById($id): JsonResponse
    {
        $comment = Comment::find($id);
        if ($comment === null) {
            return response()->json(['message' => 'Comment not found'], 404);
        }
        return response()->json($comment, 201);
    }

    /**
     * Display all the comments by user id.
     * @param $id
     * @return JsonResponse
     */
    public function getByUserId($id): JsonResponse
    {
        $comment = Comment::where('user_id', $id)->get();
        if ($comment === null) {
            return response()->json(['message' => 'Comment not found'], 404);
        }
        if ($comment->count() === 1) {
            return $comment[0];
        }
        return response()->json($comment, 201);
    }

    /**
     * Display all the comments by product id.
     * @param $id
     * @return JsonResponse
     */
    public function getByProductId($id): JsonResponse
    {
        $comment = Comment::where('product_id', $id)->get();
        if ($comment === null) {
            return response()->json(['message' => 'Comment not found'], 404);
        }
        if ($comment->count() === 1) {
            return $comment[0];
        }
        return response()->json($comment, 201);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
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
     * Update the specified resource in storage.
     * @param Request $request
     * @param $id
     * @return JsonResponse
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
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $comment = Comment::find($id);
        if ($comment === null) {
            return response()->json(['message' => 'Comment not found'], 404);
        }
        $comment->delete();
        return response()->json(['message' => 'Comment deleted'], 201);
    }
}
