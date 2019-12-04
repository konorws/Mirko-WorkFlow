<?php

namespace App\Controller\Project;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class ProjectsController
 * @package App\Controller\Project
 * @author Mykhailo YATSYHSYN <myyat@mirko.in.ua>
 * @copyright Mirko 2019 <https://mirko.in.ua>
 */
class ProjectsController extends AbstractController
{
    /**
     * @Route("project/list", name="project.list")
     */
    public function listAction()
    {

    }
}
