<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = News::all();
        return response()->json(
            ['success' => true, 'message' => 'News retrieved successfully', 'data' => $news],
            200
        );
    }

    /**
     * Display the specified resource.
     */
    public function getById(int $id)
    {
        $news = News::find($id);

        if (!$news) {
            return response()->json(
                ['success' => false, 'message' => 'News not found'],
                404
            );
        }

        return response()->json(
            ['success' => true, 'message' => 'News retrieved successfully', 'data' => $news],
            200
        );
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
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255|unique:news,title',
                'description' => 'required|string',
                'image_news' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'author' => 'required|string|max:255',
                'image_author' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $request['slug'] = Str::slug($request->title);

            if ($validator->fails()) {
                return response()->json(
                    ['success' => false, 'message' => 'Validation errors', 'errors' => $validator->errors()],
                    422
                );
            }

            if ($request->hasFile('image_news')) {
                $image = $request->file('image_news');
                $folder = News::IMAGE_URL_PATH;
                $filename = time() . '_' . $image->getClientOriginalName();

                if (!file_exists(public_path($folder))) {
                    mkdir(public_path($folder), 0755, true);
                }

                $image->move(public_path($folder), $filename);
                $request['image_url'] = $folder . '/' . $filename;
            }

            if ($request->hasFile('image_author')) {
                $image = $request->file('image_author');
                $folder = News::AUTHOR_IMAGE_URL_PATH;
                $filename = time() . '_' . $image->getClientOriginalName();

                if (!file_exists(public_path($folder))) {
                    mkdir(public_path($folder), 0755, true);
                }

                $image->move(public_path($folder), $filename);
                $request['author_image'] = $folder . '/' . $filename;
            }


            $news = News::create($request->all());
            return response()->json(
                ['success' => true, 'message' => 'News created successfully', 'data' => $news],
                200
            );
        } catch (\Exception $e) {
            return response()->json(
                ['success' => false, 'message' => 'Failed to create news', 'error' => $e->getMessage()],
                500
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255|unique:news,title,' . $news->id,
                'description' => 'required|string',
                'image_news' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'author' => 'required|string|max:255',
                'image_author' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $request['slug'] = Str::slug($request->title);

            if ($validator->fails()) {
                return response()->json(
                    ['success' => false, 'message' => 'Validation errors', 'errors' => $validator->errors()],
                    422
                );
            }

            if ($request->hasFile('image_news')) {
                if ($news->image_url) {
                    $oldPath = public_path($news->image_url);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }

                $image = $request->file('image_news');
                $folder = News::IMAGE_URL_PATH;
                $filename = time() . '_' . $image->getClientOriginalName();

                if (!file_exists(public_path($folder))) {
                    mkdir(public_path($folder), 0755, true);
                }

                $image->move(public_path($folder), $filename);
                $request['image_url'] = $folder . '/' . $filename;
            }

            if ($request->hasFile('image_author')) {
                if ($news->author_image) {
                    $oldPath = public_path($news->author_image);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }

                $image = $request->file('image_author');
                $folder = News::AUTHOR_IMAGE_URL_PATH;
                $filename = time() . '_' . $image->getClientOriginalName();

                if (!file_exists(public_path($folder))) {
                    mkdir(public_path($folder), 0755, true);
                }

                $image->move(public_path($folder), $filename);
                $request['author_image'] = $folder . '/' . $filename;
            }


            $news->update($request->all());
            return response()->json(
                ['success' => true, 'message' => 'News updated successfully', 'data' => $news],
                200
            );
        } catch (\Exception $e) {
            return response()->json(
                ['success' => false, 'message' => 'Failed to update news', 'error' => $e->getMessage()],
                500
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        try {
            if ($news->image_url) {
                Storage::disk('public')->delete(str_replace('storage/', '', $news->image_url));
            }

            if ($news->author_image) {
                Storage::disk('public')->delete(str_replace('storage/', '', $news->author_image));
            }

            $news->delete();
            return response()->json(
                ['success' => true, 'message' => 'News deleted successfully'],
                200
            );
        } catch (\Exception $e) {
            return response()->json(
                ['success' => false, 'message' => 'Failed to delete news', 'error' => $e->getMessage()],
                500
            );
        }
    }

    /**
     * Get references for the specified resource.
     */
    public function getReferences()
    {
        $references = News::all();
        return response()->json(
            ['success' => true, 'message' => 'References retrieved successfully', 'data' => $references],
            200
        );
    }

    public function getBySlug($slug)
    {
        $news = News::where('slug', $slug)->first();
        return response()->json(
            ['success' => true, 'message' => 'News retrieved successfully', 'data' => $news],
            200
        );
    }
}
