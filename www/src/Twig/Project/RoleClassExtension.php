<?php

namespace App\Twig\Project;

use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;
use App\ObjectValue\Project\ProjectMember;

/**
 * Class RoleClassExtension
 * @package App\Twig\Project
 * @author Mykhailo YATSYHSYN <myyat@mirko.in.ua>
 * @copyright Mirko 2019 <https://mirko.in.ua>
 */
class RoleClassExtension extends AbstractExtension
{
    /**
     * @return array|\Twig\TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('projectRoleClass', [$this, 'getClassForRole'])
        ];
    }

    /**
     * @param string $role
     *
     * @return string
     */
    public function getClassForRole(string $role): ? string
    {
        return ProjectMember::getCssClassForRole($role);
    }
}
