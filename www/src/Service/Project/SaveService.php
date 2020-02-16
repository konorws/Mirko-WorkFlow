<?php

namespace App\Service\Project;

use App\Entity\User\User;
use App\Entity\Project\Project;
use App\Entity\Project\ProjectMember;

/**
 * Class SaveService
 * @package App\Service\Project
 * @author Mykhailo YATSYHSYN <myyat@mirko.in.ua>
 * @copyright Mirko 2019-2020 <https://mirko.in.ua>
 */
class SaveService
{
    /**
     * Set project field to Entity
     *
     * @param Project $project
     * @param array $form
     *
     * @return Project
     */
    public function editProject(Project $project, array $form)
    {

        if(!empty($form['name'])) {
            $project->setName($form['name']);
        }

        if(!empty($form['description'])) {
            $project->setDescription($form['description']);
        }

        if(!empty($form['currency'])) {
            $project->setCurrency($form['currency']);
        }

        if(!empty($form['rate'])) {
            $project->setRate($form['rate']);
        }

        if(isset($form['public'])) {
            $project->setPublic((int)$form['public']);
        }

        // @todo: need add functionality for add image
        $project->setImage(NULL);

        return $project;
    }

    /**
     * @param Project $project
     * @param User $user
     * @param string $role
     *
     * @return ProjectMember
     *
     * @throws \App\Exception\NotFoundException
     */
    public function addMember(Project $project, User $user, string $role)
    {
        $member = ProjectMember::create($project, $user, $role);

        // @todo need implement log
        $project->addMember($member);

        return $member;
    }

    /**
     * @param Project $project
     * @param User $user
     *
     * @return bool
     */
    public function isMember(Project $project, User $user)
    {
        /** @var ProjectMember $value */
        foreach ($project->getMembers()->getValues() as $value) {
            if($value->getUser()->getId() === $user->getId()) {
                return true;
            }
        }

        return false;
    }
}