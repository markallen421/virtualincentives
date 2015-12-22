<?php
namespace Ktcrain\VirtualIncentives\Util;

class Arr
{
    /**
     * Has
     *
     * @param array  $array Array
     * @param string $key   Key
     *
     * @return boolean Whether the key exists or not
     */
    public static function has($array, $key)
    {
        if (array_key_exists($key, $array)) {
            return true;
        }

        $keys = explode('.', $key);

        while (count($keys) > 1) {
            $key = array_shift($keys);

            if (!array_key_exists($key, $array) || !is_array($array[$key])) {
                return false;
            }

            $array = $array[$key];
        }

        $key = array_shift($keys);

        return array_key_exists($key, $array);
    }

    /**
     * Set
     *
     * @param array  $array Array
     * @param string $key   Key
     * @param mixed  $value Value
     */
    public static function set(&$array, $key, $value)
    {
        $keys = explode('.', $key);

        while (count($keys) > 1) {
            $key = array_shift($keys);

            if (!array_key_exists($key, $array) || !is_array($array[$key])) {
                $array[$key] = [];
            }

            $array =& $array[$key];
        }

        $key = array_shift($keys);

        $array[$key] = $value;
    }

    /**
     * Get
     *
     * @param array  $array    Array
     * @param string $key      Key
     * @param mixed  $fallback Default return value
     *
     * @return mixed Value
     */
    public static function get($array, $key, $fallback = NULL)
    {
        if (array_key_exists($key, $array)) {
            return $array[$key];
        }

        $keys = explode('.', $key);

        while (count($keys) > 1) {
            $key = array_shift($keys);

            if (!array_key_exists($key, $array) || !is_array($array[$key])) {
                return $fallback;
            }

            $array = $array[$key];
        }

        $key = array_shift($keys);

        if (!array_key_exists($key, $array)) {
            return $fallback;
        }

        return $array[$key];
    }

    /**
     * First
     *
     * @param array $array    Array
     * @param mixed $callback Callback
     * @param mixed $fallback Fallback
     *
     * @return mixed Value
     */
    public static function first($array, $callback, $fallback = NULL)
    {
        foreach ($array as $key => $value) {
            if (call_user_func($callback, $value, $key)) {
                return $value;
            }
        }

        return $fallback;
    }

    /**
     * Where
     *
     * @param array $array    Array
     * @param mixed $callback Callback
     *
     * @return array Filtered Array
     */
    public static function where($array, $callback)
    {
        $filtered_array = [];

        foreach ($array as $key => $value) {
            if (call_user_func($callback, $value, $key)) {
                $filtered_array[$key] = $value;
            }
        }

        return $filtered_array;
    }

}
