<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WidgetPackSize extends Model
{
    use HasFactory;

    protected $table = 'widget_pack_sizes';

    /**
     * Create new database entry
     *
     * @param $size
     * @return bool
     */
    public static function saveNewSize($size): bool
    {
        $widgetPackSize = new WidgetPackSize();
        return self::saveWidgetPackSize($widgetPackSize, $size);
    }

    /**
     * Update database entry based on id
     *
     * @param $id
     * @param $size
     * @return mixed
     */
    public static function updateSize($id, $size)
    {
        $widgetPackSize = WidgetPackSize::find($id);
        return self::saveWidgetPackSize($widgetPackSize, $size);
    }

    /**
     * Delete database entry based on id
     *
     * @param $id
     * @return mixed
     */
    public static function deleteSize($id)
    {
        $widgetPackSize = WidgetPackSize::find($id);
        return $widgetPackSize->delete();
    }

    /**
     * Get widgets for table
     *
     * @return mixed
     */
    public static function getWidgetPackSizeData()
    {
        return WidgetPackSize::orderBy('size')->get();
    }

    /**
     * @param WidgetPackSize $widgetPackSize
     * @param $size
     * @return bool
     */
    private static function saveWidgetPackSize(WidgetPackSize $widgetPackSize, $size): bool
    {
        $widgetPackSize->size = $size;
        return $widgetPackSize->save();
    }
}
