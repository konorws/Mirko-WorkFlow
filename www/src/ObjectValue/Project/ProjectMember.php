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

    const PRIORITY = [
        self::ROLE_OWNER => 100,
        self::ROLE_MANAGER => 80,
        self::ROLE_DEVELOPER => 70,
        self::ROLE_TESTER => 60,
        self::ROLE_VIEW => 50,
        self::ROLE_CLIENT => 40
    ];

    const STYLE = [
        self::ROLE_OWNER => 'danger',
        self::ROLE_MANAGER => 'warning',
        self::ROLE_DEVELOPER => 'primary',
        self::ROLE_TESTER => 'dark',
        self::ROLE_VIEW => 'info',
        self::ROLE_CLIENT => 'secondary'
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
            if(isset(self::PRIORITY[$role])){
                $priorities[] = self::PRIORITY[$role];
            }
        }

        $max = max($priorities);

        return array_search($max,self::PRIORITY);
    }

    /**
     * @param string $role
     * @return bool|mixed
     */
    public static function getCssClassForRole($role)
    {
        if(isset(self::STYLE[$role])) {
            return self::STYLE[$role];
        }

        return NULL;
    }
}
