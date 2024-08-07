<?php

use App\Libs\ValueUtil;
use App\Libs\ConfigUtil;
use App\Libs\DateUtil;

if (!function_exists('getConstToValue')) {
    /**
     * Get value from constant
     *
     * @param string $key
     * @return int|string|null
     */
    function getConstToValue($key) {
        return ValueUtil::constToValue($key);
    }
}

if (!function_exists('getConstToText')) {
    /**
     * Get text from const (in Yml config file)
     *
     * @param $key
     * @return int|null|string
     */
    function getConstToText($key) {
        return ValueUtil::constToText($key);
    }
}

if (!function_exists('getList')) {
    /**
     * Get value for select/checkbox/radio option from key
     *
     * @param string $key
     * @return array|string|null
     */
    function getList($key) {
        return ValueUtil::getList($key);
    }
}

if (!function_exists('getMessage')) {
    /**
     * Get message from key
     *
     * @param string $messId
     * @param array $options
     * @return mixed|string|null
     */
    function getMessage($messId, $paramArray = []) {
        return ConfigUtil::getMessage($messId, $paramArray);
    }
}

if (!function_exists('getValueToText')) {
    /**
     * Convert from value into text in view
     *
     * @param string|int $value property value Ex: 1
     * @param string $listKey list defined in yml Ex: web.type
     * @return null|string text if exists else blank
     */
    function getValueToText($value, $listKey) {
        return ValueUtil::valueToText($value, $listKey);
    }
}

if (!function_exists('formatDate')) {
    /**
     * Format date
     * @param string|object $date
     * @param string $format
     * @return string;
     */
    function formatDate($date, $format = 'Y/m/d') {
        return DateUtil::formatDate($date, $format);
    }
}

