<?php

namespace App\Controller\Project;

use App\Repository\Project\ProjectRepository;
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
     * @var ProjectRepository
     */
    protected $projectRepository;

    /**
     * ProjectsController constructor.
     * @param ProjectRepository $projectRepository
     */
    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    /**
     * @Route("project/list", name="project.list")
     */
    public function listAction()
    {
        $projects = $this->projectRepository->getProjectByUser($this->getUser());

        foreach ($projects as $project)
        {
            var_dump($project->getMyRole($this->getUser()));
        }

        return $this->render('@App/user/project/list/view.html.twig', [
        ]);
    }
}
