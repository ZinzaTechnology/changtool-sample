<?php
/**
 * @author: cuongnx
 * @email: cuong@zinza.com.vn
 * @license: ZINZA Technology
 */

namespace common\lib\helpers;

use Yii;

class AppArrayHelper extends yii\helpers\ArrayHelper
{
    /**
     * This function filter keys that exist in the original array
     * and return an array with the keys given
     *
     * any key that does not have a value will be null
     * in the returned array
     * yii\helpers\ArrayHelper::filter() will not return empty key
     *
     * @return array
     */
    public static function filterKeys($array, $keys)
    {
        $result = [];

        foreach ($keys as $key) {
            $result[$key] = (isset($array[$key])) ? $array[$key] : null;
        }

        return $result;
    }
}

