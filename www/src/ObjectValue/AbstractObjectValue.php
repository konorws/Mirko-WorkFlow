<?php

namespace App\ObjectValue;

/**
 * Class AbstractObjectValue
 *
 * @package App\ObjectValue
 * @author Mykhailo YATSYHSYN <myyat@mirko.in.ua>
 * @copyright Mirko 2019 <https://mirko.in.ua>
 */
abstract class AbstractObjectValue implements ObjectValueInterface
{

    /**
     * Check is value
     *
     * @param string $value
     *
     * @return bool
     */
    public  function checkExist(string $value)
    {
    }

    /**
     * @return array
     */
    public static  function getAllValues() {
        return self::getConstants();
    }

    /**
     * @return array
     */
    private static function getConstants()
    {
        try {
            $objectValueReflection = new \ReflectionClass(get_called_class());
        } catch (\ReflectionException $e) {
            return NULL;
        }

        return $objectValueReflection->getConstants();
    }
}
