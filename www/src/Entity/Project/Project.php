<?php

namespace App\Entity\Project;

use App\Entity\User\User;
use App\ObjectValue\Project\ProjectMember as OVProjectValue;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping AS ORM;
use App\Entity\Attachment\Attachment;

/**
 * Class Project
 * @package App\Entity\Project
 * @author Mykhailo YATSYHSYN <myyat@mirko.in.ua>
 * @copyright Mirko 2019 <https://mirko.in.ua>
 *
 * @ORM\Entity(repositoryClass="App\Repository\Project\ProjectRepository")
 */
class Project
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var ProjectMember[]
     * @ORM\OneToMany(targetEntity="\App\Entity\Project\ProjectMember", mappedBy="project")
     */
    protected $members;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $name;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=false)
     */
    protected $description;

    /**
     * @var Attachment
     * @ORM\OneToOne(targetEntity="App\Entity\Attachment\Attachment")
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id")
     */
    protected $image;

    /**
     * @var bool
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $closed = false;

    /**
     * @var string
     * @ORM\Column(type="string", length=3, nullable=false)
     */
    protected $currency;

    /**
     * @var float
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    protected $rate;

    /**
     * @var bool
     * @ORM\Column(type="string", length=3, nullable=false)
     */
    protected $public = false;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Project
     */
    public function setId(int $id): Project
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    /**
     * @param ProjectMember[] $members
     * @return Project
     */
    public function setMembers(array $members): Project
    {
        $this->members = $members;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Project
     */
    public function setName(string $name): Project
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Project
     */
    public function setDescription(string $description): Project
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return Attachment
     */
    public function getImage(): Attachment
    {
        return $this->image;
    }

    /**
     * @param Attachment $image
     * @return Project
     */
    public function setImage(Attachment $image): Project
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return bool
     */
    public function isClosed(): bool
    {
        return $this->closed;
    }

    /**
     * @param bool $closed
     * @return Project
     */
    public function setClosed(bool $closed): Project
    {
        $this->closed = $closed;
        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     * @return Project
     */
    public function setCurrency(string $currency): Project
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return float
     */
    public function getRate(): float
    {
        return $this->rate;
    }

    /**
     * @param float $rate
     * @return Project
     */
    public function setRate(float $rate): Project
    {
        $this->rate = $rate;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPublic(): bool
    {
        return $this->public;
    }

    /**
     * @param bool $public
     * @return Project
     */
    public function setPublic(bool $public): Project
    {
        $this->public = $public;
        return $this;
    }

    /**
     * @param User $user
     *
     * @return false|string
     */
    public function getUserGeneralRole(User $user)
    {
        $roles = $this->getUserRoles($user);

        return OVProjectValue::getRolePriority($roles);
    }

    /**
     * @param User $user
     *
     * @return array
     */
    public function getUserRoles(User $user)
    {
        $roles = [];
        /** @var ProjectMember $member */
        foreach ($this->getMembers()->getValues() as $member) {
            if($member->getUser()->getId() == $user->getId()) {
                $roles[] = $member->getRole();
            }
        }

        return $roles;
    }
}
