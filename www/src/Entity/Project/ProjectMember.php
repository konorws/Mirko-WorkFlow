<?php

namespace App\Entity\Project;

use App\Entity\User\User;
use Doctrine\ORM\Mapping AS ORM;

/**
 * Class ProjectMember
 * @package App\Entity\Project
 * @author Mykhailo YATSYHSYN <myyat@mirko.in.ua>
 * @copyright Mirko 2019 <https://mirko.in.ua>
 *
 * @ORM\Entity
 */
class ProjectMember
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="\App\Entity\User\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @var Project
     * @ORM\ManyToOne(targetEntity="\App\Entity\Project\Project")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     */
    protected $project;

    /**
     * @var string
     * @ORM\Column(type="string", length=25, nullable=false)
     */
    protected $role;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return ProjectMember
     */
    public function setId(int $id): ProjectMember
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return ProjectMember
     */
    public function setUser(User $user): ProjectMember
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return Project
     */
    public function getProject(): Project
    {
        return $this->project;
    }

    /**
     * @param Project $project
     * @return ProjectMember
     */
    public function setProject(Project $project): ProjectMember
    {
        $this->project = $project;
        return $this;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @param string $role
     * @return ProjectMember
     */
    public function setRole(string $role): ProjectMember
    {
        $this->role = $role;

        return $this;
    }
}
