<?php

namespace App\Entity\Project;

use Doctrine\ORM\Mapping AS ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Project
 * @package App\Entity\Project
 * @author Mykhailo YATSYHSYN <myyat@mirko.in.ua>
 * @copyright Mirko 2019 <https://mirko.in.ua>
 *
 * @ORM\Entity
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
     */
    protected $name;

    protected $closed;
}
