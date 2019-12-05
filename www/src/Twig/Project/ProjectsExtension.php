<?php

namespace App\Twig\Project;

use App\Entity\Project\Project;
use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;

/**
 * Class ProjectsExtension
 * @package App\Twig\Project
 * @author Mykhailo YATSYHSYN <myyat@mirko.in.ua>
 * @copyright Mirko 2019 <https://mirko.in.ua>
 */
class ProjectsExtension extends AbstractExtension
{
    /**
     * @return array|\Twig\TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('projectProgress', [$this, 'getProjectProgress'])
        ];
    }

    /**
     * @param Project $project
     * @return int
     */
    public function getProjectProgress(Project $project):int
    {
        // @TODO: Need implement function
        return rand(0, 100);
    }
}
