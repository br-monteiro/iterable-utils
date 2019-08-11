<?php
namespace HTR\Utils\Iterables;

class IterableUtils
{

    /**
     * It goes through all the elements and performs the function of callabck
     *
     * @param array $arr The array to be used
     * @param callable $callback Function fired in array elements
     * @return array
     */
    public static function map(array $arr, callable $callback): array
    {
        $arrResult = [];

        foreach ($arr as $index => $value) {
            $arrResult[] = $callback($value, $index);
        }

        return $arrResult;
    }

    /**
     * Find a value in array. Return the first found
     *
     * @param array $arr The array to be used
     * @param callable $callback Function fired in array elements
     * @return mixed
     */
    public static function find(array $arr, callable $callback)
    {
        foreach ($arr as $index => $value) {
            if ($callback($value, $index) === true) {
                return $value;
            }
        }

        return null;
    }

    /**
     * Filter the array according callback
     *
     * @param array $arr The array to be used
     * @param callable $callback Function fired in array elements
     * @return array The array filtered
     */
    public static function filter(array $arr, callable $callback): array
    {
        $arrResult = [];

        foreach ($arr as $index => $value) {
            if ($callback($value, $index) === true) {
                $arrResult[] = $value;
            }
        }

        return $arrResult;
    }

    /**
     * Verify if in all elements the condition is once accepted
     *
     * @param array $arr The array to be used
     * @param $callback Function fired in array elements
     * @return bool
     */
    public static function only(array $arr, callable $callback): bool
    {
        $arrLength = 0;

        foreach ($arr as $index => $value) {
            if ($callback($value, $index) === true) {
                $arrLength++;
                if ($arrLength > 1) {
                    return false;
                }
            }
        }

        return $arrLength === 1;
    }

    /**
     * Verify if in all elements the condition is always accepted
     *
     * @param array $arr The array to be used
     * @param $callback Function fired in array elements
     * @return bool
     */
    public static function even(array $arr, callable $callback): bool
    {
        if (count($arr) === 0) {
            return false;
        }

        foreach ($arr as $index => $value) {
            if ($callback($value, $index) !== true) { // false, 0 or null
                return false;
            }
        }

        return true;
    }

    /**
     * Find a value in array. Return the last found
     *
     * @param array $arr The array to be used
     * @param callable $callback Function fired in array elements
     * @return mixed
     */
    public static function last(array $arr, callable $callback)
    {
        $arrLength = count($arr);

        if ($arrLength === 0) {
            return null;
        }

        $index = $arrLength - 1;

        while($index >= 0) {
            if ($callback($arr[$index], $index) === true) {
                return $arr[$index];
            }
            $index--;
        }

        return null;
    }

    /**
     * The reduce() method executes a reducer function (that you provide) on each element of the array, resulting in a single output value
     *
     * @param array $arr The array to be used
     * @param callable $callback The callback executed on each element of the array
     * @param midex $default The default entry value
     * @return midex
     */
    public static function reduce(array $arr, callable $callback, $default = null)
    {
        $acc = $default;

        foreach ($arr as $index => $value) {
            $acc = $callback($acc, $value, $index);
        }

        return $acc;
    }
}
