<?php
namespace Ktcrain\VirtualIncentives\Util;

class Obj
{
    /**
     * Has
     *
     * @param object $object   Object
     * @param string $property Property
     *
     * @return boolean Whether the property exists or not
     */
    public static function has($object, $property)
    {
        if (property_exists($object, $property)) {
            return true;
        }

        $properties = explode('.', $property);

        while (count($properties) > 1) {
            $property = array_shift($properties);

            if (!property_exists($object, $property) || !is_object($object->$property)) {
                return false;
            }

            $object = $object->$property;
        }

        $property = array_shift($properties);

        return property_exists($object, $property);
    }

    /**
     * Set
     *
     * @param object $object   Object
     * @param string $property Property
     * @param mixed  $value    Value
     */
    public static function set($object, $property, $value)
    {
        $properties = explode('.', $property);

        while (count($properties) > 1) {
            $property = array_shift($properties);

            if (!property_exists($object, $property) || !is_object($object->$property)) {
                $object->$property = new stdClass();
            }

            $object =& $object->$property;
        }

        $property = array_shift($properties);

        $object->$property = $value;
    }

    /**
     * Get
     *
     * @param object $object   Object
     * @param string $property Property
     * @param mixed  $fallback Default return value
     *
     * @return mixed Value
     */
    public static function get($object, $property, $fallback = NULL)
    {
        if (property_exists($object, $property)) {
            return $object->$property;
        }

        $keys = explode('.', $property);

        while (count($keys) > 1) {
            $property = array_shift($keys);

            if (!property_exists($object, $property) || !is_object($object->$property)) {
                return $fallback;
            }

            $object = $object->$property;
        }

        $property = array_shift($keys);

        if (!property_exists($object, $property)) {
            return $fallback;
        }

        return $object->$property;
    }

}
