<?php

namespace App\Service;

/**
 * Class KeyGeneratorService
 * @package App\Service
 * @author Mykhailo YATSYHSYN <myyat@mirko.in.ua>
 * @copyright Mirko 2019 <https://mirko.in.ua>
 */
class KeyGeneratorService
{

    /**
     * @param int $length
     *
     * @return string
     */
    public static function generateKey(int $length = 36) {
        $key = '';
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        for ($i = 0; $i < $length; $i++) {
            $key .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $key;
    }
}
