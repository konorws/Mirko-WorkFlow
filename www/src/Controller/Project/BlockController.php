<?php

namespace App\Controller\Project;

use App\Controller\AbstractAppController;
use App\Repository\Project\ProjectRepository;
use App\Service\Project\SaveService;

/**
 * Class ProjectsController
 * @package App\Controller\Project
 * @author Mykhailo YATSYHSYN <myyat@mirko.in.ua>
 * @copyright Mirko 2019 <https://mirko.in.ua>
 */
class BlockController extends AbstractAppController
{
    /**
     * @var ProjectRepository
     */
    protected $projectRepository;

    /**
     * ProjectsController constructor.
     * @param ProjectRepository $projectRepository
     * @param SaveService $saveService
     */
    public function __construct(
        ProjectRepository $projectRepository
    ) {
        $this->projectRepository = $projectRepository;
    }

    public function menuAction(int $id)
    {
        $menu = [];
        $project = $this->projectRepository->find($id);

        // Task
        $menu[] = [
            "url" => $this->generateUrl("project.view", ["id" => $project->getId()]),
            "text" => "Task",
            "active" => $this->checkIsActive("project.view")
        ];
        $menu[] = [
            "url" => $this->generateUrl("project.member.list", ["project" => $project->getId()]),
            "text" => "Members",
            "active" => $this->checkIsActive("project.member.list")
        ];

        return $this->render("@App/user/project/view/menu.html.twig", ["menu" => $menu]);
    }


    /**
     * @param string $route
     *
     * @return bool
     */
    private function checkIsActive(string $route)
    {
        $currentRoute = $this->get("request_stack")->getMasterRequest()->get("_route");

        return $route === $currentRoute;
    }
}