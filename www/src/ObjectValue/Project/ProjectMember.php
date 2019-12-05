<?php

namespace App\ObjectValue\Project;

use App\ObjectValue\AbstractObjectValue;

/**
 * Class ProjectMember
 *
 * @package App\ObjectValue\Project
 * @author Mykhailo YATSYHSYN <myyat@mirko.in.ua>
 * @copyright Mirko 2019 <https://mirko.in.ua>
 */
class ProjectMember extends AbstractObjectValue
{
    const ROLE_OWNER = 'owner';
    const ROLE_MANAGER = 'manager';
    const ROLE_DEVELOPER = 'developer';
    const ROLE_TESTER = 'tester';
    const ROLE_VIEW = 'view';
    const ROLE_CLIENT = 'client';

    const ROLE_PRIORITY = [
        self::ROLE_OWNER => 100,
        self::ROLE_MANAGER => 80,
        self::ROLE_DEVELOPER => 70,
        self::ROLE_TESTER => 60,
        self::ROLE_VIEW => 50,
        self::ROLE_CLIENT => 40
    ];


    /**
     * @return string
     */
    public static function getClass(): string
    {
        return __CLASS__;
    }

    /**
     * @param array $roles
     * @return false|int|string
     */
    public static function getRolePriority(array $roles)
    {
        $priorities = [];

        foreach ($roles as $role) {
            if(isset(self::ROLE_PRIORITY[$role])){
                $priorities[] = self::ROLE_PRIORITY[$role];
            }
        }

        $max = max($priorities);

        return array_search($max,self::ROLE_PRIORITY);
    }
}
