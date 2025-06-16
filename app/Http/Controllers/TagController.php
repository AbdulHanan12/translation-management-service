<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\TagStoreRequest;
use App\Http\Requests\TagUpdateRequest;

class TagController extends Controller
{
    /**
     * List all tags.
     * 
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $tags = Tag::all();
        return response()->json($tags);
    }

    /**
     * Create a new tag.
     * 
     * @param TagStoreRequest $request
     * @return JsonResponse
     */
    public function store(TagStoreRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $tag = Tag::create($validated);
        return response()->json($tag, 201);
    }

    /**
     * View a specific tag.
     * 
     * @param Tag $tag
     * @return JsonResponse
     */
    public function show(Tag $tag): JsonResponse
    {
        return response()->json($tag);
    }

    /**
     * Update a tag.
     * 
     * @param TagUpdateRequest $request
     * @param Tag $tag
     * @return JsonResponse
     */
    public function update(TagUpdateRequest $request, Tag $tag): JsonResponse
    {
        $validated = $request->validated();
        $tag->update($validated);
        return response()->json($tag);
    }

    /**
     * Delete a tag.
     * 
     * @param Tag $tag
     * @return JsonResponse
     */
    public function destroy(Tag $tag): JsonResponse
    {
        $tag->delete();
        return response()->json(null, 204);
    }
} 