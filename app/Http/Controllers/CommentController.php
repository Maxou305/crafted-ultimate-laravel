<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display all the comments.
     * @return JsonResponse : JSON response with the list of comments
     */
    public function index(): JsonResponse
    {
        $commentList = Comment::all();
        return response()->json($commentList, 201);
    }

    /**
     * Display a comment by id.
     * @param $id : Comment id
     * @return JsonResponse : JSON response with the comment
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
     * @param $id : User id
     * @return JsonResponse : JSON response with the list of comments
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
     * @param $id : Product id
     * @return JsonResponse : JSON response with the list of comments
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
     * @param StoreCommentRequest $request : Request with the comment data
     * @return JsonResponse : JSON response with the created comment
     */
    public function store(StoreCommentRequest $request): JsonResponse
    {
        $comment = Comment::create(
            array_merge(
                $request->all(),
                ['user_id' => Auth::id()]
            ));
        $comment->save();
        return response()->json($comment, 201);
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateCommentRequest $request : Request with the comment data
     * @param $id : Comment id
     * @return JsonResponse : JSON response with the updated comment
     */
    public function update(UpdateCommentRequest $request, $id)
    {
        $comment = Comment::find($id);
        $comment->update(['content' => $request->get('content')]);
        return $comment;
    }

    /**
     * Remove the specified resource from storage.
     * @param $id : Comment id
     * @return JsonResponse : JSON response with the message
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
