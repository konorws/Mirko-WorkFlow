<?php

namespace App\Controller\Project;

use App\Controller\AbstractAppController;
use App\Repository\Project\ProjectRepository;
use App\Service\Project\SaveService;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MemberController
 * @package App\Controller\Project
 * @author Mykhailo YATSYHSYN <myyat@mirko.in.ua>
 * @copyright Mirko 2019-2020 <https://mirko.in.ua>
 */
class MemberController extends AbstractAppController
{

    /**
     * @var ProjectRepository
     */
    protected $projectRepository;

    /**
     * ProjectsController constructor.
     * @param ProjectRepository $projectRepository
     */
    public function __construct(
        ProjectRepository $projectRepository
    ) {
        $this->projectRepository = $projectRepository;
    }

    /**
     * @Route("project/{project}/member", name="project.member.list")
     * @param int $project
     */
    public function listAction(int $project)
    {
        $project = $this->projectRepository->find($project);

        return $this->render("@App/user/project/list/member.html.twig", [
            "members" => $project->getMembers(),
            "project" => $project
        ]);
    }
}