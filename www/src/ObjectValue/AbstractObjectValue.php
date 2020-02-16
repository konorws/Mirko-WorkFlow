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
     * @var \ReflectionClass
     */
    private static $reflectionClass;

    /**
     * @param string $key
     * @return mixed
     */
    public static function get(string $key)
    {
        self::init();
        return self::$reflectionClass->getConstant($key);
    }

    /**
     * @param string $key
     * @return bool
     */
    public static function hasExist(string $key)
    {
        self::init();
        return self::$reflectionClass->hasConstant($key);
    }

    /**
     * @return array
     */
    public static function getAllValues() {
        self::init();
        return self::$reflectionClass->getConstants();
    }

    private function init()
    {
        self::$reflectionClass = new \ReflectionClass(get_called_class());
    }
}
