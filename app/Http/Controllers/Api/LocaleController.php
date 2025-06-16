<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Locale;
use App\Http\Requests\LocaleStoreRequest;
use App\Http\Requests\LocaleUpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    /**
     * Display a listing of the locales.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $locales = Locale::withCount('translations')
            ->when($request->has('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('code', 'like', "%{$search}%")
                      ->orWhere('name', 'like', "%{$search}%");
                });
            })
            ->paginate(20);

        return response()->json($locales);
    }

    /**
     * Store a newly created locale in storage.
     *
     * @param LocaleStoreRequest $request
     * @return JsonResponse
     */
    public function store(LocaleStoreRequest $request): JsonResponse
    {
        $locale = Locale::create($request->validated());
        return response()->json($locale, 201);
    }

    /**
     * Display the specified locale.
     *
     * @param Locale $locale
     * @return JsonResponse
     */
    public function show(Locale $locale): JsonResponse
    {
        return response()->json($locale->loadCount('translations'));
    }

    /**
     * Update the specified locale in storage.
     *
     * @param LocaleUpdateRequest $request
     * @param Locale $locale
     * @return JsonResponse
     */
    public function update(LocaleUpdateRequest $request, Locale $locale): JsonResponse
    {
        $locale->update($request->validated());
        return response()->json($locale);
    }

    /**
     * Remove the specified locale from storage.
     *
     * @param Locale $locale
     * @return JsonResponse
     */
    public function destroy(Locale $locale): JsonResponse
    {
        if ($locale->translations()->exists()) {
            return response()->json([
                'message' => 'Cannot delete locale with existing translations.'
            ], 422);
        }

        $locale->delete();
        return response()->json(null, 204);
    }
} 