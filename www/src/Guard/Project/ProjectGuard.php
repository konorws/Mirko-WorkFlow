<?php

namespace App\Guard\Project;

use App\Entity\User\User;
use App\Entity\Project\Project;
use App\ObjectValue\Project\ProjectRole;
use App\Exception\PermissionDeniedException;

/**
 * Class ProjectGuard
 * @package App\Guard\Project
 * @author Mykhailo YATSYHSYN <myyat@mirko.in.ua>
 * @copyright Mirko 2019-2020 <https://mirko.in.ua>
 */
class ProjectGuard
{
    /**
     * @param Project $project
     * @param User $user
     *
     * @throws PermissionDeniedException
     */
    public static function edit(Project $project, User $user)
    {
        $role = $project->getUserGeneralRole($user);
        if(!in_array($role, ProjectRole::getPermissionEdit())) {
            throw new PermissionDeniedException("You not have permission for edit project");
        }
    }

    /**
     * @param Project $project
     * @param User $user
     *
     * @throws PermissionDeniedException
     */
    public static function view(Project $project, User $user)
    {
        if($project->isPublic()) {
            return;
        }

        $role = $project->getUserGeneralRole($user);
        if(!in_array($role, ProjectRole::getAllValues())) {
            throw new PermissionDeniedException("You not have permission for edit project");
        }
    }
}