<?php

namespace App\Http\Controllers;

use App\Models\Locale;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\LocaleStoreRequest;
use App\Http\Requests\LocaleUpdateRequest;

class LocaleController extends Controller
{
    /**
     * List all locales.
     * 
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $locales = Locale::all();
        return response()->json($locales);
    }

    /**
     * Create a new locale.
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function store(LocaleStoreRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $locale = Locale::create($validated);
        return response()->json($locale, 201);
    }

    /**
     * View a specific locale.
     * 
     * @param Locale $locale
     * @return JsonResponse
     */
    public function show(Locale $locale): JsonResponse
    {
        return response()->json($locale);
    }

    /**
     * Update a locale.
     * 
     * @param Request $request
     * @param Locale $locale
     * @return JsonResponse
     */
    public function update(LocaleUpdateRequest $request, Locale $locale): JsonResponse
    {
        $validated = $request->validated();
        $locale->update($validated);
        return response()->json($locale);
    }

    /**
     * Delete a locale.
     * 
     * @param Locale $locale
     * @return JsonResponse
     */
    public function destroy(Locale $locale): JsonResponse
    {
        $locale->delete();
        return response()->json(null, 204);
    }
} 