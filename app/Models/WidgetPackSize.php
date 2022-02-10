<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WidgetPackSize extends Model
{
    use HasFactory;

    protected $table = 'widget_pack_sizes';


    /**
     * Get size column from widget_pack_sizes
     *
     * @return array
     */
    public static function getAllWidgetPackSizes(): array
    {
        return self::orderBy('size', 'DESC')->pluck('size')->toArray();
    }

    /**
     * Receives array of widget pack sizes
     * and flips key values to get array of pack sizes as keys and values set to 0
     *
     * ex. input [250,500,1000,2000,5000]
     *
     * ex. output [250 => 0, 500 => 0, 1000 => 0, 2000 => 0, 5000 => 0]
     *
     * @param $widgetPackSizes
     * @return array
     */
    private static function transformPackSizesArray($widgetPackSizes): array
    {
        return array_fill_keys(array_keys(array_flip($widgetPackSizes)), 0);
    }


    /**
     * Receives amount as parameter and returns array with keys as pack sizes and values as pack amounts
     *
     * Function cycles until amount parameter is less than or equals zero
     * and on each cycle another cycling is done on widget pack sizes
     * and amount and widget pack size is compared until one of two checks are passed:
     * amount is larger number than one of pack sizes or is less than the smallest pack size
     * on both checks' widget pack size is subtracted and pack used is saved into array,
     * inner cycle breaks to make sure all large packs are used prior to smaller ones.
     *
     * @param $amount
     * @return array
     */
    public static function getPacksForAmount($amount): array
    {
        $widgetPackSizes = self::getAllWidgetPackSizes();

        $transformedPackSizes = self::transformPackSizesArray($widgetPackSizes);

        $minSizePack = $widgetPackSizes[count($widgetPackSizes) - 1];
        if ($amount < $minSizePack) {
            $transformedPackSizes[$minSizePack] += 1;
        } else {
            foreach ($widgetPackSizes as $widgetPackSize) {
                $transformedPackSizes[$widgetPackSize] = (int)floor($amount / $widgetPackSize);
                $amount = $amount % $widgetPackSize;
                if ($amount && $amount < $minSizePack) {
                    $transformedPackSizes[$minSizePack] += 1;
                }
            }

            for ($i = 0; $i < count($transformedPackSizes); $i++) {
                $sum = 0;
                $keysToNullify = [];
                for ($j=$i+1; $j < count($transformedPackSizes); $j++) {
                    $sum += $widgetPackSizes[$j] * $transformedPackSizes[$widgetPackSizes[$j]];
                    $keysToNullify[] = $widgetPackSizes[$j];
                }
                if ($sum >= $widgetPackSizes[$i]) {
                    $transformedPackSizes[$widgetPackSizes[$i]] += 1;
                    foreach ($keysToNullify as $value) {
                        $transformedPackSizes[$value] = 0;
                    }
                }
            }
        }

        return $transformedPackSizes;
    }


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
