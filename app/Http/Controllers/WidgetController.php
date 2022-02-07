<?php

namespace App\Http\Controllers;

use App\Models\WidgetPackSize;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class WidgetController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function createWidgetOrder(Request $request): JsonResponse
    {
        $this->validate($request, [
            'amount' => 'required|numeric|min:1'
        ]);
        $packs = WidgetPackSize::getPacksForAmount($request->amount);
        return response()->json([
            'packs' => $packs,
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function saveWidgetPackSize(Request $request): JsonResponse
    {
        $this->validate($request, [
            'size' => 'required|numeric|min:1'
        ]);

        $widgetSaved = WidgetPackSize::saveNewSize($request->size);

        return response()->json([
            'saved' => $widgetSaved,
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function updateWidgetPackSize(Request $request): JsonResponse
    {
        $this->validate($request, [
            'size' => 'required|numeric|min:1',
            'id' => 'required|exists:widget_pack_sizes'
        ]);

        $widgetSaved = WidgetPackSize::updateSize($request->id, $request->size);

        return response()->json([
            'saved' => $widgetSaved,
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function deleteWidgetPackSize(Request $request): JsonResponse
    {
        $this->validate($request, [
            'id' => 'required|exists:widget_pack_sizes'
        ]);

        $widgetDeleted = WidgetPackSize::deleteSize($request->id);

        return response()->json([
            'deleted' => $widgetDeleted,
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function getWidgetPackSizesData(): JsonResponse
    {
        return response()->json([
            'data' => WidgetPackSize::getWidgetPackSizeData(),
        ]);
    }
}
