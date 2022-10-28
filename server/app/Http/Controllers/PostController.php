<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Http\Resources\PostResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::when(request('search'), function ($query) {
            $query->where('posts.title', 'like', '%' . request('search') . '%');
        })->with('user')->with('categories')->get();
        return response()->json(PostResource::collection($posts));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $imageName = time() . '.' . $request->image->extension();

        // Storage Folder
        $request->image->move(storage_path('app/public/img/posts'), $imageName);
        $post = Post::create([
            'user_id' => Auth::user()->id,
            'image' => $imageName,
            'title' => $request->title,
            'body' => $request->body,
        ]);
        $post->categories()->sync($request->categories);
        return response([
            'message' => 'success',
            'data' => $post,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::with('user')->with('categories')->find($id);
        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostUpdateRequest $request, Post $post)
    {
        //authorize user to update the post
        if ($request->user()->cannot('update', $post)) {
            abort(403);
        }
        if ($request->file('image')) {
            if (File::exists(storage_path('app/public/img/posts/') . $post->image)) {
                File::delete(storage_path('app/public/img/posts/') . $post->image);
            }
            $imageName = time() . '.' . $request->file('image')->extension();

            // Storage Folder
            $request->image->move(storage_path('app/public/img/posts'), $imageName);
            $post->image = $imageName;
        }
        $post->title = $request->title;
        $post->body = $request->body;
        $post->categories()->sync($request->categories);
        $post->save();

        return response([
            'message' => 'Post Updated',
            'data' => $post,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Post $post)
    {
        //authorize user to delete the post
        if ($request->user()->cannot('delete', $post)) {
            abort(403);
        }
        if (File::exists(storage_path('app/public/img/posts/') . $post->image)) {
            File::delete(storage_path('app/public/img/posts/') . $post->image);
        }

        $post->categories()->sync([]);
        Comment::where('post_id', $post->id)->delete();
        $post->delete();
        return response([
            'message' => 'Post deleted!',
        ]);
    }
}
