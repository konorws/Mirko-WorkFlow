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
    public static function hasKeyExist(string $key)
    {
        self::init();
        return self::$reflectionClass->hasConstant($key);
    }

    /**
     * @param string $string
     * @return bool
     */
    public static function hasExist(string $string)
    {
        $constants = self::getAllValues();
        return in_array($string, $constants);
    }

    /**
     * @return array
     */
    public static function getAllValues() {
        self::init();
        $constants = self::$reflectionClass->getConstants();

        if(static::getKeyPrefix() === NULL) {
            return  $constants;
        }

        foreach ($constants as $key => $constant) {
            if(strpos($key, static::getKeyPrefix()) !== 0) {
                unset($constants[$key]);
            }
        }

        return  $constants;
    }


    /**
     * @return string|null
     */
    public static function getKeyPrefix(): ?string
    {
        return NULL;
    }

    private function init()
    {
        self::$reflectionClass = new \ReflectionClass(get_called_class());
    }
}
