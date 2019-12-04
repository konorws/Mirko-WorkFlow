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
    public static function checkExist(string $value)
    {
        try {
            $objectValueReflection = new \ReflectionClass(self::getClass());
            $constants = $objectValueReflection->getConstants($value);

            return in_array($value, $constants);
        } catch (\ReflectionException $e) {
            return false;
        }
    }

    /**
     * @return string
     */
    public static function getClass(): string
    {
        return __CLASS__;
    }
}
