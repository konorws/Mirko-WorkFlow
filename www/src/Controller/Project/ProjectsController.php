<?php

namespace App\Controller\Project;

use App\Form\Type\Project\CreateType;
use App\Repository\Project\ProjectRepository;
use Symfony\Component\HttpFoundation\Request;
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

        return $this->render('@App/user/project/list/view.html.twig', [
            'projects' => $projects
        ]);
    }

    /**
     * @Route("project/create", name="project.create")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {

        $form = $this->createForm(CreateType::class);

        return $this->render("@App/user/project/form/create.html.twig", [
            'form' => $form->createView()
        ]);
    }
}
