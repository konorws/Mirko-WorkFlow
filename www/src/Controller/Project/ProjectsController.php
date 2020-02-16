<?php

namespace App\Controller\Project;

use App\Entity\Project\Project;
use App\Form\Type\Project\CreateFormType;
use App\ObjectValue\Project\ProjectRole;
use App\Repository\Project\ProjectRepository;
use App\Service\Project\SaveService;
use Doctrine\Common\Persistence\ObjectManager;
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
     * @var SaveService
     */
    private $saveService;

    /**
     * ProjectsController constructor.
     * @param ProjectRepository $projectRepository
     * @param SaveService $saveService
     */
    public function __construct(
        ProjectRepository $projectRepository,
        SaveService $saveService
    ) {
        $this->saveService = $saveService;
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
     *
     * @throws \App\Exception\NotFoundException
     */
    public function createAction(Request $request)
    {
        $project = new Project();
        $form = $this->createForm(CreateFormType::class)
            ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $project = $this->saveService->editProject($project, $form->getData());

            $this->saveService->addMember($project, $this->getUser(), ProjectRole::ROLE_OWNER);

            $objectManager = $this->container->get("doctrine")->getManager();

            $objectManager->persist($project);
            $objectManager->flush();

            $this->addFlash("success", "Project success create");
            return $this->redirect($this->generateUrl("project.list"));
        }

        return $this->render("@App/user/project/form/create.html.twig", [
            'form' => $form->createView()
        ]);
    }
}
