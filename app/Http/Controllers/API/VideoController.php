<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\VideoRequest;
use App\Http\Resources\VideoResource;
use App\Models\Category;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = Video::with('category')->paginate(10);
        return VideoResource::collection($videos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VideoRequest $request)
    {
        try {
            // Handle file upload
            $selectedThumbnail = $this->handleFileUpload($request);

            // Create a new video
            $video = Video::create([
                'title' => $request->title,
                'link' => $request->link,
                'image' => $selectedThumbnail,
                'category_id' => $request->category_id,
            ]);

            return new VideoResource($video);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getVideosByCategory($category){
        $category = Category::where('name', $category)->first();

        if(!$category){
            return response()->json([
                'message' => 'Category not found'
            ], 404);
        }

        $videos = Video::where('category_id', $category->id)->with('category')->paginate(10);

        return VideoResource::collection($videos);
    }

    /**
     * Display the specified resource.
     */
    public function show(Video $video)
    {
        return new VideoResource($video);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VideoRequest $request, Video $video)
    {
        try {
            // Handle file upload
            $selectedThumbnail = $this->handleFileUpload($request);

            $video->update([
                'title' => $request->title,
                'link' => $request->link,
                'image' => $selectedThumbnail,
                'category_id' => $request->category_id,
            ]);

            return new VideoResource($video);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Video $video)
    {
        try{
            $video->delete();

            return response()->json([
                'message' => 'Video deleted successfully'
            ], 200);

        } catch(\Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    private function handleFileUpload(VideoRequest $request)
    {
        if ($request->hasFile('image')) {
            $selectedThumbnail = Str::random(10) . time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('public', $selectedThumbnail);
        } else {
            // Handle cases where no image is provided (e.g., for updates)
            $selectedThumbnail = $request->input('image', ''); // Assuming your form sends an 'image' field even if no file is selected
        }

        return $selectedThumbnail;
    }
}
