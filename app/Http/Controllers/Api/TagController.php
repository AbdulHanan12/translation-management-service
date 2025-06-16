<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Http\Requests\TagStoreRequest;
use App\Http\Requests\TagUpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the tags.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $tags = Tag::withCount('translations')
            ->when($request->has('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->where('name', 'like', "%{$search}%");
            })
            ->paginate(20);

        return response()->json($tags);
    }

    /**
     * Store a newly created tag in storage.
     *
     * @param TagStoreRequest $request
     * @return JsonResponse
     */
    public function store(TagStoreRequest $request): JsonResponse
    {
        $tag = Tag::create($request->validated());
        return response()->json($tag, 201);
    }

    /**
     * Display the specified tag.
     *
     * @param Tag $tag
     * @return JsonResponse
     */
    public function show(Tag $tag): JsonResponse
    {
        return response()->json($tag->loadCount('translations'));
    }

    /**
     * Update the specified tag in storage.
     *
     * @param TagUpdateRequest $request
     * @param Tag $tag
     * @return JsonResponse
     */
    public function update(TagUpdateRequest $request, Tag $tag): JsonResponse
    {
        $tag->update($request->validated());
        return response()->json($tag);
    }

    /**
     * Remove the specified tag from storage.
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