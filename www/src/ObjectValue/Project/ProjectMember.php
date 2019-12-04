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

    /**
     * @return string
     */
    public static function getClass(): string
    {
        return __CLASS__;
    }
}
