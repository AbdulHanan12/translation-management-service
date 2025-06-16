<?php

namespace App\Http\Controllers;

use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\TranslationStoreRequest;
use App\Http\Requests\TranslationUpdateRequest;

class TranslationController extends Controller
{
    /**
     * List all translations with optional filtering by tags, keys, or content.
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $translations = Translation::filter($request)->with(['locale', 'tags'])->get();
        return response()->json($translations);
    }

    /**
     * Create a new translation.
     * 
     * @param TranslationStoreRequest $request
     * @return JsonResponse
     */
    public function store(TranslationStoreRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $translation = Translation::create($validated);

        if (isset($validated['tags'])) {
            $translation->tags()->sync($validated['tags']);
        }

        return response()->json($translation, 201);
    }

    /**
     * View a specific translation.
     * 
     * @param Translation $translation
     * @return JsonResponse
     */
    public function show(Translation $translation): JsonResponse
    {
        return response()->json($translation->load(['locale', 'tags']));
    }

    /**
     * Update a translation.
     * 
     * @param TranslationUpdateRequest $request
     * @param Translation $translation
     * @return JsonResponse
     */
    public function update(TranslationUpdateRequest $request, Translation $translation): JsonResponse
    {
        $validated = $request->validated();
        $translation->update($validated);

        if (isset($validated['tags'])) {
            $translation->tags()->sync($validated['tags']);
        }

        return response()->json($translation->load(['locale', 'tags']));
    }

    /**
     * Delete a translation.
     * 
     * @param Translation $translation
     * @return JsonResponse
     */
    public function destroy(Translation $translation): JsonResponse
    {
        $translation->delete();
        return response()->json(null, 204);
    }

    /**
     * Export translations as JSON for frontend use.
     * 
     * @return JsonResponse
     */
    public function export(): JsonResponse
    {
        $translations = Translation::with(['locale', 'tags'])->get();
        return response()->json($translations);
    }
} 