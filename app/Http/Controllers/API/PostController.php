<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('category', 'tags')->paginate(10);
        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {

        try{
            $selectedImage =  Str::random($length = 10).time().'.'.$request->image->getClientOriginalExtension();

            // $request->image->move(public_path('images'), $selectedImage);

            Storage::disk('public')->put($selectedImage, file_get_contents($request->image));

            $post = Post::create([
                'title' => $request->title,
                'description' => $request->description,
                'image' => $selectedImage,
                'author' => $request->author,
                'category_id' => $request->category_id,
            ]);

            $post->category()->associate($request->category_id);
            $post->tags()->attach($request->tags);

            return new PostResource($post);

        }catch(\Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }

    }

    public function getPostsByCategory($category)
    {
        $category = Category::where('name', $category)->first();

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $posts = Post::where('category_id', $category->id)->with('category', 'tags')->paginate(10);

        return PostResource::collection($posts);
    }

    public function getPostsByTag($tag)
    {
        $posts = Post::whereHas('tags', function ($query) use ($tag) {
            $query->where('name', $tag);
        })->with('category', 'tags')->paginate(10);

        return PostResource::collection($posts);
    }



    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    {
        $post->update($request->validated());

        // Attach categories and tags to the post if needed
        $post->category()->associate($request->category);
        $post->tags()->sync($request->tags);

        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->noContent();
    }
}
