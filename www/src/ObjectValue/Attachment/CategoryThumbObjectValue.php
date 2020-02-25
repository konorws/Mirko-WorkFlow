<?php

namespace App\ObjectValue\Attachment;

use App\ObjectValue\AbstractObjectValue;

/**
 * Class CategoryThumbObjectValue
 * @package App\ObjectValue\Attachment
 * @author Mykhailo YATSYHSYN <myyat@mirko.in.ua>
 * @copyright Mirko 1019-2020 <https://mirko.in.ua>
 */
class CategoryThumbObjectValue extends AbstractObjectValue
{
    const DEFAULT = "/assets/images/no-image-icon.png";
    const USER__PROFILE = '/assets/images/no-image-icon.png';

    /**
     * @param string $key
     * @return mixed
     */
    public static function get(string $key)
    {
        $key = str_replace(".", "__", $key);
        return parent::get($key);
    }

    /**
     * @param string $key
     * @return bool
     */
    public static function hasKeyExist(string $key)
    {
        $key = str_replace(".", "__", $key);
        return parent::hasKeyExist($key);
    }
}