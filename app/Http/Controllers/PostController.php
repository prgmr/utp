<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class PostController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Post::all('id', 'title', 'content', 'author_id', 'status', 'created_at'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'author_id' => 'required|integer',
                'status' => 'required|integer',
            ]);
        } catch (ValidationException $exception) {
            return response()->json([ 'errors' => $exception->validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $post = Post::create($validated);
        return response()->json($post->only(['id', 'created_at']), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $post_id)
    {
        try {
            $post = Post::findOrFail($post_id);
        } catch (ModelNotFoundException $exception) {
            return response()->json([ 'errors' => "Post with id {$post_id} not found"], Response::HTTP_NOT_FOUND);
        }
        return response()->json($post->only(['id', 'title', 'content', 'author_id', 'status', 'created_at', 'updated_at']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $post_id)
    {
        try {
            $validated = $request->validate([
                'title' => 'string|max:255',
                'content' => 'string',
                'author_id' => 'integer',
                'status' => 'integer',
            ]);
            $post = Post::findOrFail($post_id);
        } catch (ModelNotFoundException $exception) {
            return response()->json([ 'errors' => "Post with id {$post_id} not found"], Response::HTTP_NOT_FOUND);
        } catch (ValidationException $exception) {
            return response()->json([ 'errors' => $exception->validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $post->update($validated);
        return response()->json($post->only(['id', 'updated_at']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $post_id)
    {
        try {
            $post = Post::findOrFail($post_id);
        } catch (ModelNotFoundException $exception) {
            return response()->json([ 'errors' => "Post with id {$post_id} not found"], Response::HTTP_NOT_FOUND);
        }
        $post->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
