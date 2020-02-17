<?php

namespace App\Controller\Project;

use App\Controller\AbstractAppController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TaskController
 * @package App\Controller\Project
 * @author Mykhailo YATSYHSYN <myyat@mirko.in.ua>
 * @copyright Mirko 2019-2020 <https://mirko.in.ua>
 */
class TaskController extends AbstractAppController
{

    /**
     * @Route("project/{project}/task", name="project.task.list")
     */
    public function listAction()
    {
    }
}